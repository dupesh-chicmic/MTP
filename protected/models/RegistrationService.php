<?php
class RegistrationService
{
    public static $PARAM_MOCK_DATA = false;
    public static $PARAM_MOCK_REG_PLATE_NUMBER = "131D1234"; //"131D1234";//"09D4406";//"131D15065";

    public static function mockRiData()
    {
        $returnedCode = "3002400265"; //"3002400265"; //"3202400074";
        return $riData = array( // MOCK
            "registerVehicleNumber" => self::$PARAM_MOCK_REG_PLATE_NUMBER,
            "code" => $returnedCode,
            "make" => "RI",
            "model" => "RI",
            "transmission" => "RI",
            "CO2" => "RI",
            "roadTax" => "RI",
            "colour" => "RI",
            "engine" => "RI",
            "fuel" => "RI",
            "importTitle" => "RI",
            "year" => RegistrationService::getCarYear(self::$PARAM_MOCK_REG_PLATE_NUMBER),
            'body' => "RI",
        );
    }

    public static function getFirstArrayItem($arrIn)
    {
        $arrVal = array_values($arrIn);
        if (is_array($arrVal)) {
            return $arrVal[0];
        } else return null;
    }
    public static function isUKRegPlate($regNumber)
    {
        return !is_numeric($regNumber[0]);
    }


    public static function getCarsByTextValuesFromVerisk($riData, $selectModel, $range = null)
    {

        // HERE
        $fuelLetter = strtoupper(substr($riData['fuel'], 0, 1));
        $importId = Import::getLastImportId($selectModel);
        $model = "";
        if ($selectModel == "UsedCarsModel") {
            $carOrComm = 'used_cars';
            $orderField = 'id_used_cars';
            $joinCondition = 'used_cars.id = used_cars_model.id_used_cars';
        } else {
            $carOrComm = 'used_com_cars';
            $orderField = 'id_used_com_cars';
            $joinCondition = 'used_com_cars.id = used_com_cars_model.id_used_com_cars';
        }
        $fieldnames = Import::getAllFields($carOrComm);
        // SELECT * FROM `used_cars_model` `t` WHERE codenumber = '3002400265' ORDER BY `id_used_cars` DESC LIMIT 1

        $query = "SELECT " . $fieldnames . " FROM " . (($selectModel == "UsedCarsModel") ? "`used_cars_model`, `used_cars`" : "`used_com_cars_model`, `used_com_cars`");
        $query .= " WHERE " . (($selectModel == "UsedCarsModel") ? "`used_cars`" : "`used_com_cars`") . ".id_import=" . $importId;
        $query .= " AND `fuel` = '" . $fuelLetter . "'";
        $query .= " AND `maker` = '" . $riData['make'] . "'";
        if (!empty($range)) {
            $query .= " AND `rangecode` = '" . $range->rangecode . "'";
        }
        $query .= " AND " . $joinCondition;

        // echo '>>>>>--------------query('.$selectModel.'):'.$query.'---------------';

        $result = Yii::app()->db->createCommand($query)->queryAll();

        // echo '--------------results:---------------';
        //        var_dump($result);
        //        exit;

        //        if($selectModel == "UsedCarsModel")
        //        {
        //            $model = UsedCarsModel::model()->findBySql($query);
        //        }
        //        else 
        //        {
        //            $model = UsedComCarsModel::model()->findBySql($query);
        //        }

        return $result;
    }



    public static function getRiDataResults($lvVehicleRegNumber)
    {
        // Get the logged-in user's ID (if available)
        $userId = Yii::app()->user->id ? Yii::app()->user->id : null; // Use null if no user is logged in

        Yii::log("user Id: ". $userId. CLogger::LEVEL_ERROR, 'application');
        Yii::log("RI lookup request reg=" . $lvVehicleRegNumber, CLogger::LEVEL_ERROR, 'application.registration');

        if (self::$PARAM_MOCK_DATA) {

            // ----------- MOCK DATA -----------
            $lvVehicleRegNumber = self::$PARAM_MOCK_REG_PLATE_NUMBER;
            $riData = RegistrationService::mockRiData();
            return $riData;
        } else {
            //echo $lvVehicleRegNumber; die;
            $riData = RegistrationService::getRiDataByRegLookUp($lvVehicleRegNumber);
            Yii::log(
                "RI lookup response reg=" . $lvVehicleRegNumber . " data=" . json_encode($riData),
                CLogger::LEVEL_ERROR,
                'application.registration'
            );

            // Log the request
            Yii::log("Logging request for: " . $lvVehicleRegNumber . " by user: " . $userId, CLogger::LEVEL_ERROR, 'application');

            // Insert into database
            $command = Yii::app()->db->createCommand();
            $command->insert('ri_data_lookup', array(
                'vehicle_reg_number' => $lvVehicleRegNumber,
                'request_time' => new CDbExpression('NOW()'), // Store current timestamp
                'user_id' => $userId
            ));
            
            /* if($lvVehicleRegNumber=='192KK424'){
                echo "<pre>"; print_r($riData); die;
            } */
        }

        if (is_array($riData['VehicleData']['Engine_Size'])) {
            $riData['VehicleData']['Engine_Size'] = isset($riData['VehicleData']['Engine_Size']) ? $riData['VehicleData']['Engine_Size']['@value'] : '';
        }

        if (!empty($riData['errors'][0])) {
            return array('errors' => $riData['errors'][0]);
        }

        if ((isset($riData['matches']) && $riData['matches'] == "0")) {
            return array('errors' => 'No vehicle found');
        }

        $import = Import::getLastImportData();

        if (isset($riData['code']) && $riData['code'] != "") {
            $vehicleData = array(
                "registerVehicleNumber" => $lvVehicleRegNumber,
                "code" => $riData['code'],
                "make" => $riData['make'],
                "model" => $riData['model'],
                "transmission" => $riData['transmission'],
                "CO2" => $riData['CO2'],
                "roadTax" => $riData['roadTax'],
                "colour" => $riData['colour'],
                "engine" => $riData['engine'],
                "fuel" => $riData['fuel'],
                "importTitle" => $riData['importTitle'], //$import->nazwa,
                "year" => $riData['year'], //RegistrationService::getCarYear($lvVehicleRegNumber)
                'body' => $riData['VehicleData']['Body_Type'],
            );
        } else {
            //echo 'codeVal:'.$riData['Valuation']['Code'];
            //echo "<pre>"; print_r($riData); die("==");
            /* if (
                $riData['VehicleData']['Make'] == "Toyota" &&
                strpos($riData['VehicleData']['Model'], "Yaris") !== false &&
                strpos($riData['VehicleData']['Model'], "Cross") !== false
            ) {

                $riData['Valuation']['Code'] = "";
                //$riData = RegistrationService::getRiDataByRegLookUp($lvVehicleRegNumber);
                //echo "<pre>"; print_r($riData); die("=||=");
            } */
            $vehicleData = array(
                "registerVehicleNumber" => $lvVehicleRegNumber,
                "code" => $riData['Valuation']['Code'], //make it blank when Make is Toyota and Model contains Cross
                "make" => $riData['VehicleData']['Make'],
                "model" => $riData['VehicleData']['Model'],
                "transmission" => $riData['VehicleData']['Transmission'],
                "CO2" => $riData['VehicleData']['CO2_Emissions'],
                "roadTax" => $riData['VehicleData']['Tax_Cost'],
                "colour" => $riData['VehicleData']['Colour'],
                "engine" => $riData['VehicleData']['Engine_Size'],
                "fuel" => $riData['VehicleData']['Fuel_Type'],
                "importTitle" => $import->nazwa,
                "year" => RegistrationService::getCarYear($lvVehicleRegNumber),
                'body' => $riData['VehicleData']['Body_Type'],

                'previous_reg' => $riData['VehicleData']['Previous_Registration'],
                'import_outside' => $riData['VehicleData']['Imported_Outside_UKIE'],

            );
        }
        return $vehicleData;
    }
    public static function getRiDataResults1($lvVehicleRegNumber, $getChassis)
    {
        //      if($lvVehicleRegNumber=='xxx'){
        //            $lvVehicleRegNumber = self::$PARAM_MOCK_REG_PLATE_NUMBER;
        //            $riData = RegistrationService::mockRiData();
        ////            echo "RI DATA<br /><pre>";
        ////            print_r($riData);
        ////            echo "</pre><br />END RI DATA<br />";
        //                $riData['code'] = '1202810052';
        //            return $riData;
        //        }else {
        if (self::$PARAM_MOCK_DATA) {
            // ----------- MOCK DATA -----------
            $lvVehicleRegNumber = self::$PARAM_MOCK_REG_PLATE_NUMBER;
            $riData = RegistrationService::mockRiData();
            //            echo "RI DATA<br /><pre>";
            //            print_r($riData);
            //            echo "</pre><br />END RI DATA<br />";
            return $riData;
            // ---------------------------------
        } else {

            $riData = RegistrationService::getRiDataByRegLookUp($lvVehicleRegNumber);
            //echo 'First call:<br/><br/>';

            if ($getChassis) {
                $riDataChassis = RegistrationService::getRiDataByRegLookUpChassis($lvVehicleRegNumber);
            }

            //            echo "RI DATA<br /><pre>";
            //            print_r($riData);
            //            echo "</pre><br />END RI DATA<br />";
            //  var_dump($riData);

        }
        // }
        //            var_dump($riData);
        //            echo "<br/>******************************<br/>";
        //            var_dump($riDataChassis);
        if (!empty($riDataChassis)) {
            $riData['chassisArray'] = $riDataChassis;
            //   echo "<br/><br/>-----------------------------------------------------<br/><br/>";
            //  echo 'Second call:<br/><br/>';

            //  echo '<br/><br/>Our return FULL:<br/><br/>';
        } else {
            $riData['chassisArray'] = null;
        }
        //var_dump($riData);


        //  exit;

        if (!empty($riData['errors'][0])) {
            return array('errors' => $riData['errors'][0]);
        }
        // array(2) { ["REPORTS"]=> array(0) { } ["matches"]=> string(1) "0" }
        if ((isset($riData['matches']) && $riData['matches'] == "0")) {
            return array('errors' => 'No vehicle found');
        }

        $import = Import::getLastImportData();

        if (isset($riData['code']) && $riData['code'] != "") {

            //echo 'code:'.$riData['code'];
            $vehicleData = array(
                "registerVehicleNumber" => $lvVehicleRegNumber,
                "code" => $riData['code'],
                "make" => $riData['make'],
                "model" => $riData['model'],
                "transmission" => $riData['transmission'],
                "CO2" => $riData['CO2'],
                "roadTax" => $riData['roadTax'],
                "colour" => $riData['colour'],
                "engine" => $riData['engine'],
                "fuel" => $riData['fuel'],
                "importTitle" => $riData['importTitle'], //$import->nazwa,
                "year" => $riData['year'], //RegistrationService::getCarYear($lvVehicleRegNumber)
                'body' => $riData['VehicleData']['Body_Type'],
                'chassisArray' => $riData['chassisArray']
            );
        } else {
            //echo 'codeVal:'.$riData['Valuation']['Code'];
            $vehicleData = array(
                "registerVehicleNumber" => $lvVehicleRegNumber,
                "code" => $riData['Valuation']['Code'],
                "make" => $riData['VehicleData']['Make'],
                "model" => $riData['VehicleData']['Model'],
                "transmission" => $riData['VehicleData']['Transmission'],
                "CO2" => $riData['VehicleData']['CO2_Emissions'],
                "roadTax" => $riData['VehicleData']['Tax_Cost'],
                "colour" => $riData['VehicleData']['Colour'],
                "engine" => $riData['VehicleData']['Engine_Size'],
                "fuel" => $riData['VehicleData']['Fuel_Type'],
                "importTitle" => $import->nazwa,
                "year" => RegistrationService::getCarYear($lvVehicleRegNumber),
                'body' => $riData['VehicleData']['Body_Type'],
                'chassisArray' => $riData['chassisArray']

            );
        }
        return $vehicleData;
    }

    public static function getFirstValuedHighScore($carsScores, $carsValues)
    {
        //values have Ids of cars that have values we match best scores with values and return teh highest score that has a value
        foreach ($carsScores as $id => $score) {
            if (array_key_exists($id, $carsValues)) {
                return $score;
            }
        }
        return null;
    }



    public static function checkIfRiReturnedIsNotAHighest($allHighestScoreVehicles, $returnedRICode)
    {
        foreach ($allHighestScoreVehicles as $id => $score) {
            $veh = UsedComCarsModel::model()->findByPk($id);
            if (empty($veh)) {
                $veh = UsedCarsModel::model()->findByPk($id);
            }
            if (!empty($veh)) {
                if (!empty($veh->codenumber)) {
                    if ($veh->codenumber == $returnedRICode) {
                        return $veh->id;
                    }
                }
            }
        }
        return null;
    }

    public static function getAllHighestScores($carsScores, $carsValues)
    {
        $highScores = array();
        //values have Ids of cars that have values we match best scores with values and return teh highest score that has a value
        $firstValuedHighScore = self::getFirstValuedHighScore($carsScores, $carsValues);

        foreach ($carsScores as $id => $score) {
            if ($score == $firstValuedHighScore) {
                if (array_key_exists($id, $carsValues)) {
                    $highScores[$id] = $score;
                }
            }
        }
        //krsort($highScores);
        return $highScores;
    }

    public static function getFirstValuedVehicle($carsScores, $carsValues, $returnedByRICode = null)
    {
        //public static function getFirstValuedVehicle($carsScores, $carsValues){
        //values have Ids of cars that have values we match best scores with values and return teh highest score that has a value

        $allHighestScoreVehicles =  self::getAllHighestScores($carsScores, $carsValues);
        //echo 'param:'.$returnedByRICode;
        if (!empty($returnedByRICode)) {
            $isRiCodeHigest = self::checkIfRiReturnedIsNotAHighest($allHighestScoreVehicles, $returnedByRICode);
            //  echo 'isRI highest:'.$isRiCodeHigest;
            if (!empty($isRiCodeHigest)) {
                return $isRiCodeHigest;
            }
        }
        $len = sizeof($allHighestScoreVehicles);
        $firstID = null;
        if ($len == 1) {
            foreach ($carsScores as $id => $score) {
                if (array_key_exists($id, $carsValues)) {
                    return $id;
                }
            }
        } else if ($len > 1) {
            $i = 0;

            foreach ($allHighestScoreVehicles as $id => $score) {
                if ($i == 0) {
                    $firstID = $id;
                }

                $veh = UsedComCarsModel::model()->findByPk($id);
                if (empty($veh)) {
                    $veh = UsedCarsModel::model()->findByPk($id);
                }
                if (!empty($veh)) {
                    if (empty($veh->corecode)) {
                        return $veh->id;
                    }
                }
                $i++;
            }
            return $firstID;
        } else {
            return null;
        }

        //        foreach($carsScores as $id=>$score){
        //            if(array_key_exists($id, $carsValues)){
        //                $veh = UsedComCarsModel::model()->findByPk($id);
        //                if(empty($veh)){
        //                    $veh = UsedCarsModel::model()->findByPk($id);
        //                }
        //                
        //                    if(!empty($veh)){
        //                        //echo 'FVal - veh not empty';
        //                        if(!empty($veh->corecode)){
        //                            //echo 'FVal - corecode not empty';
        //                            $coreVeh = UsedComCarsModel::model()->find('codenumber=:code ORDER BY ID DESC',array('code'=>$veh->corecode) );
        //                            if(empty($coreVeh)){
        //                                //echo 'FVal - veh not empty';
        //                                $coreVeh = UsedCarsModel::model()->find('codenumber=:code ORDER BY ID DESC',array('code'=>$veh->corecode));
        //                            }
        //                            if(!empty($coreVeh)){
        //                               // echo 'FVal - CORE veh not empty';
        //                                if(array_key_exists($coreVeh->id, $carsScores)){
        //                                  //  echo 'VAL exist';
        //                                      $coreScore = $carsScores[$coreVeh->id];
        //                                   //   echo 'VALUES:'.$coreScore.'>='.$score;
        //                                      if($coreScore>=$score) return $coreVeh->id;
        //                                }
        //                            }
        //                        }
        //                    }                
        //                return $id;
        //            }
        //        }
        //        return null;
    }

    public static function getScoreForNOTValidVehicles($cars, $riResults)
    {
        $out = array();
        $out['values'] = array();
        $out['scoreLog'] = array();
        $scores = array();
        foreach ($cars as $car) {
            //            echo '<br>-->NEW CAR';
            //            var_dump($car);
            //exit;
            // echo 'car:'.$car->id.':'.self::scoreTags($car, $riResults);
            $score = self::getPointsForFirstSelection($car, $riResults);
            $scoreResults = self::scoreTags($car, $riResults);
            $score += $scoreResults['result'];
            $out['scoreLog'][$car['id']] = $scoreResults['scoreLog'];
            $scores[$car['id']] = $score;

            $valuleAndYear = self::getValueAndKmsForYear($riResults['year'], $car);
            if (!empty($valuleAndYear['value'])) {
                $out['values'][$car['id']] = $valuleAndYear['value'];
            }
        }

        //var_dump($out);
        arsort($scores);
        $out['score'] = $scores;
        return $out;
    }

    public static function getScoreForValidVehicles($cars, $riResults)
    {
        $out = array();
        $out['scoreLog'] = array();

        $out['values'] = array();
        foreach ($cars as $car) {
            //echo '------->>>>>>car';
            // var_dump($car);
            // exit;
            // echo 'car:'.$car['id'].':'.self::scoreTags($car, $riResults);
            $scoreResults = self::scoreTags($car, $riResults);

            $scores[$car['id']] = $scoreResults['result'];
            $valuleAndYear = self::getValueAndKmsForYear($riResults['year'], $car);
            $out['scoreLog'][$car['id']] = $scoreResults['scoreLog'];
            if (!empty($valuleAndYear['value'])) {
                $out['values'][$car['id']] = $valuleAndYear['value'];
            }
        }
        //var_dump($out);
        //arsort($out['score']);

        arsort($scores);
        $out['score'] = $scores;


        return $out;
    }

    //    public static function getValueForValidVehicles($cars, $riResults){
    //        $out = array();
    //        $out['values'] = array();
    //        foreach($cars as $car){
    //            //echo '------->>>>>>car';
    //           // var_dump($car);
    //           // exit;
    //            echo 'car:'.$car['id'].':'.self::scoreTags($car, $riResults);
    //            $out[$car['id']] = self::scoreTags($car, $riResults);
    //            
    //        }
    //        //var_dump($out);
    //        arsort($out);
    //        return $out;
    //    }



    public static function getValueAndKmsForYear($regYear, $data)
    {
        for ($i = 0; $i <= 15; $i++) {
            if (empty($data['yr' . $i]) && empty($data['kms' . $i]) && empty($data['GRP' . $i]))
                continue;

            if ($regYear == $data['yr' . $i]) {
                $out = array('kms' => $data['kms' . $i], 'value' => $data['GRP' . $i]);
                return $out;
            }
        }
        return null;
    }

    public static function scoreTags($car, $riResults)
    {
        $out = array();

        $riString = $riResults['model'];
        $score = 0.0;
        $scoreLog = "";
        //$riTags = self::replaceWithDict($riString);
        $riTags = $riString;
        $mtpTags = self::getMtpTags($car);
        foreach ($mtpTags as $mtpTag) {
            // echo " >>>>IN for each".$mtpTag;
            $dict = TagsDict::getRiValuesValues('Spec', $mtpTag);
            //var_dump($dict);

            if (strpos(strtolower(' ' . $riTags . ' '), strtolower(' ' . $mtpTag . ' ')) !== false) {
                $scoreLog .= " <+1 for" . $mtpTag . '> ';
                $score++;
            } else {

                if (!empty($dict)) {

                    if (is_array($dict)) {
                        $found = false;
                        foreach ($dict as $dictRow) {
                            $scoreLog .= " *** DICT for" . $mtpTag;

                            //Echo 'BODY MATCH CHECK:(mtp val-'.$dictRow->mtp_value.'???'.$car[$dictRow->mtp_field].')';
                            if (strpos(strtolower(" " . $riTags . ' '), strtolower(' ' . $dictRow->ri_value . ' ')) !== false) {
                                $scoreLog .= " <+1 for" . $mtpTag . '(translated to[' . $dictRow->ri_value . '])> ';
                                $score++;
                                break;
                            } else {
                                if (strpos(strtolower($riTags), strtolower($dictRow->ri_value)) !== false) {
                                    $scoreLog .= " <+0.5 for" . $mtpTag . ' (translated to[' . $dictRow->ri_value . '])> ';
                                    $score = $score + 0.5;
                                    break;
                                }
                            }
                        }
                    }
                }
                $scoreLog .= " >>PARTCHECK:" . $mtpTag . "<< ";
                if (strpos(strtolower($riTags), strtolower($mtpTag)) !== false) {
                    $scoreLog .= " <+0.5 for" . $mtpTag . '> ';
                    $score = $score + 0.5;
                }
            }
        }
        //was that - till 2018/07/12 was giving lower results for better cars when they had more mtp tags - was wrong
        //$out['result'] = floatval($score/sizeof($mtpTags));
        $out['result'] = $score / 10;
        //$scoreLog .= 'CALC (score/mtpTagsLenght) : ('.$score.'/'.sizeof($mtpTags).')='.$out['result'];
        $scoreLog .= 'CALC (score/10) : (' . $score . '/10)=' . $out['result'];
        $out['scoreLog'] = $scoreLog;
        return $out;
    }

    public static function getMtpTags($car)
    {
        $tags = array();
        for ($i = 1; $i <= 15; $i++) {
            if (!empty($car['Tag' . $i])) {
                $tags[] = $car['Tag' . $i];
            }
        }
        return $tags;
    }
    //    
    //    public static function getValidVehiclesFromArray($cars, $riResults){
    //        $out = array();
    //        foreach($cars as $carArr){
    //            if(isset($carArr['id_used_cars'])){
    //                $car = new UsedCarsModel();
    //                $car->attributes = $carArr;
    //                var_dump($car);
    //                exit;
    //            }else {
    //                $car = new UsedComCarsModel();
    //                $car->attributes = $carArr;
    //            }
    //            
    ////            var_dump($car);
    ////            exit;
    //            if(self::passFirstSelection($car, $riResults)){
    //                $out[]=$car;
    //            }
    //        }
    //        return $out;
    //    }
    public static function getValidVehicles($cars, $riResults)
    {
        $out = array();
        foreach ($cars as $car) {

            //            var_dump($car);
            //            exit;
            if (self::passFirstSelection($car, $riResults)) {
                //echo 'Adding valid vehicle'.$car['id'];
                //var_dump($car);
                $out[] = $car;
            }
        }
        return $out;
    }

    public static function getPointsForFirstSelection($car, $riResults)
    {
        $points = 0.0;

        if (self::matchFuel($car, $riResults['fuel'])) {
            $points += 1;
        }

        if (self::matchTrans($car, $riResults['transmission'])) {
            $points += 1;
        }

        if (self::matchEngine($car, $riResults['engine'])) {
            $points += 1;
        }

        if (self::lookupDrive($car, $riResults['model'])) {
            $points += 1;
        }

        if (self::matchYear($car, $riResults['year'])) {
            $points += 1;
        }

        if (self::matchBody($car, $riResults['body'])) {
            $points += 1;
        }

        return $points;
    }

    public static function passFirstSelection($car, $riResults)
    {
        $passed = true;
        // var_dump($riResults);
        if (!self::matchFuel($car, $riResults['fuel'])) {
            //echo $car['codenumber'].' failed on fuel:'.$car['fuel'];
            return false;
        }
        if (!self::matchTrans($car, $riResults['transmission'])) {
            //echo $car['codenumber'].' failed on transmission:'.$car['transmission'];
            return false;
        }
        if (!self::matchEngine($car, $riResults['engine'])) {
            //echo $car['codenumber'].' failed on engine:'.$car['cc'];
            return false;
        }
        if (!self::lookupDrive($car, $riResults['model'])) {
            //echo $car['codenumber'].' failed on drive:'.$car['drive'];
            return false;
        }
        if (!self::matchYear($car, $riResults['year'])) {
            //echo $car['codenumber'].' failed on year:'.$car['years'];
            return false;
        }
        if (!self::matchBody($car, $riResults['body'])) {
            //  echo $car['codenumber'].' failed on body:'.$car['body'];
            return false;
        }
        return $passed;
    }

    public static function matchTags($car, $riResults)
    {
        $score = 0;
        foreach ($riResults as $riKey => $riVal) {
            if (self::matchField($car, $riVal, self::getFieldForRIKey($riKey))) {
                $score++;
            }
        }
        return $score;
    }

    public static function matchField($car, $tag, $field)
    {
        if (!$field) {
            return false;
        } //field we don't compare on
        if ($car[$field] == $tag) {
            return true;
        } else return false;
    }

    public static function matchEngine($car, $riValue)
    {
        $riEngineVar = str_replace('L', '', $riValue);
        $riEngineVar = str_replace('l', '', $riEngineVar);
        $riCalValue = floatval($riEngineVar);
        $riCalValue = $riCalValue * 1000;
        $mtpCalValue = floatval($car['cc']);

        //        if($mtpCalValue>$riCalValue){
        //            return false;
        //        }else {
        $diff = abs($riCalValue - $mtpCalValue);
        if ($diff > 90) {
            return false;
        } else {
            return true;
        }
        //        }

    }
    public static function matchFuel($car, $riValue)
    {
        //echo $riValue.' = '.$car['fuel'];
        if (strtolower($riValue) == 'diesel' && $car['fuel'] == 'D') return true;
        if (strtolower($riValue) == 'petrol' && $car['fuel'] == 'P') return true;
        if (strtolower($riValue) == 'electric' && $car['fuel'] == 'E') return true;
        //echo 'eliminated on Fuel';
        return false;
    }

    public static function lookupDrive($car, $riValue)
    {
        $modelArray = explode(' ', $riValue);
        if (is_array($modelArray)) {
            $found = false;
            foreach ($modelArray as $val) {
                if (self::matchDrive($car, $val)) {
                    $found = true;
                }
            }
            if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
                return true;
            } else {
                return true;
            }
        } else {
            if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
                return true;
            } else {
                return false;
            }
        }
    }
    public static function matchDrive($car, $riValue)
    {
        if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
            if (strpos(strtolower($riValue), strtolower($car['drive'])) !== false) return true;
            else {
            }

            $dict = TagsDict::getValues('Drive', $riValue);
            if (is_array($dict)) {
                $found = false;
                foreach ($dict as $dictRow) {
                    if ($dictRow->mtp_value == $car[$dictRow->mtp_field]) {
                        $found = true;
                    }
                }
                return $found;
            } else {
                if (!empty($dict)) {
                    if ($dict->mtp_value == $car[$dict->mtp_field]) {
                        return true;
                    } else return false;
                }
            }
            //echo 'eliminated on Body';      
            return false;
            if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
            }
        }
    }

    public static function matchBody($car, $riValue)
    {
        if (strpos(strtolower($riValue), strtolower($car['bod'])) !== false) return true;
        else {
            $dict = TagsDict::getValues('Body', $riValue);
            //var_dump($dict);
            if (is_array($dict)) {
                $found = false;
                foreach ($dict as $dictRow) {
                    //Echo 'BODY MATCH CHECK:(mtp val-'.$dictRow->mtp_value.'???'.$car[$dictRow->mtp_field].')';
                    if ($dictRow->mtp_value == $car[$dictRow->mtp_field]) {
                        $found = true;
                    }
                }
                //Echo 'BODY MATCH FOUND:(mtp val-'.$dictRow->mtp_value.')-'.$found;
                //                exit;
                return $found;
            } else {
                //                echo 'not an array';
                //                exit;
                if (!empty($dict)) {
                    if ($dict->mtp_value == $car[$dict->mtp_field]) {
                        return true;
                    } else return false;
                }
            }
            //echo 'eliminated on Body';      
            return false;
        }
    }

    public static function matchYear($car, $riValue)
    {
        $yearsArr = explode('/', $car['years']);
        if (is_array($yearsArr)) {
            if ($yearsArr[1] == '-') {
                $yearsArr[1] = 10000;
            }
            if ($riValue <= $yearsArr[1] && $riValue >= $yearsArr[0]) {
                return true;
            } else {
                //echo 'eliminated on Year';      
                return false;
            }
        } else {
            // echo 'eliminated on Year';      
            return false;
        }
        // echo 'eliminated on Year';      
        return false;
    }

    public static function matchTrans($car, $riValue)
    {
        // echo '>>TRANS>>>'.strtolower($riValue).'==??'.strtolower($car['transmission']);
        if (strtolower($riValue) == strtolower($car['transmission'])) return true;
        else {
            // echo '>ELSE >';
            $dict = TagsDict::getValues('Transmission', $riValue);
            if (is_array($dict)) {
                $found = false;
                // echo 'IN DICT'. sizeof($dict);

                foreach ($dict as $dictRow) {
                    //    echo ' testing '.$dictRow->mtp_value;//' == '.$car[$dictRow->mtp_field];
                    if ($dictRow->mtp_value == $car[$dictRow->mtp_field]) {
                        //      echo 'IN';
                        //      echo ' '.$dictRow->mtp_value.' == '.$car[$dictRow->mtp_field];
                        $found = true;
                    }
                }
                // echo 'BODY MATCH FOUND:'.(String)$found;
                //                exit;
                if ($found === true) {
                    return true;
                } else {
                    return false;
                }
            } else {
                //echo 'not an array';
                //                exit;
                if (!empty($dict)) {
                    if ($dict->mtp_value == $car[$dict->mtp_field]) {
                        //echo 'true';
                        return true;
                    } else return false;
                }
            }

            //            if(!empty($dict)){
            //                if($dict->mtp_value == $car[$dict->mtp_field]){
            //                    return true;
            //                }else return false;
            //            }
            ////echo 'eliminated on Trans';      
            return false;
        }
    }

    public static function getFieldForRIKey($riKey)
    {

        $fields = array('year' => '', 'make' => 'maker', 'model' => 'range', 'engine' => 'spec', 'fuel' => 'fuel', 'transmission' => '', 'CO2' => '', '' => '', '' => '', '' => '', '' => '', '' => '');
        if (isset($fields[$riKey])) {
            return $fields[$riKey];
        } else {
            return false;
        }
    }



    /**
     * 5. Model description for MTP ASSOCIATED VALUES FOR: XXXX needs to be the Model from our files (“Maker” space “Vehicle”) 
     * where the code number is returned by RI. 
     * Where it is not like with 152D798 then please use the model description returned by RI.
     * @param type $model
     * @param type $vehicleData
     */
    public static function getChangeRiDataResults($model, $vehicleData)
    {
        if (!empty($model) && (isset($vehicleData['code']) && $vehicleData['code'] != "")) {
            $vehicleData["make"] = $model['maker'];
            $vehicleData["model"] = $model['vehicle'];
        } else {
            // none for now
        }

        return $vehicleData;
    }

    /**
     * Anything outside of our valuation 2008 and 142 range returns incorrect vehicle info in the RI
     * boxes at the top.
     * We need this for pre 08 and post 142. 
     * Here’s a post 142: 152D798 but it’ also one where RI don’t return a code number. 
     * So we would need this message if the year is between 08 and 142 range but no code number returned by RI.
     * @param type $vehicleData
     * @return boolean
     * TODO: MW - make year range dynamic!! 2008 to 2015 now 08-151
     */
    public static function isValidYear($vehicleData, $registration = null)
    {

        //this function is new - based on the years stored in the XML files rasther than calculations.
        $years = Mobile::getDisplayYears('Yrs2Display_ByReg.xml');
        $out;
        if (empty($registration)) {
            if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
                $years = Mobile::getDisplayYears('Yrs2Display_ByReg.xml');
            } else {
                $years = Mobile::getDisplayYears('Yrs2Display_ByMake.xml');
            }

            // echo 'empt';
            //            if($vehicleData['code'] == "")
            //            {
            //                return false;
            //            }
            $intYear = (int)$vehicleData['year'];



            $res = array_search($intYear, $years);
            if ($res != false) {
                $out = true;
            } else {
                $out = false;
            }

            return $out;
        } else {
            // echo '!empt';
            $intYear = (int)self::getCarYear($registration);
            $strYearleadingZeros = str_pad($intYear, 2, '0', STR_PAD_LEFT);
            //echo 'Reg year:'.$strYearleadingZeros;
            $res = array_search($strYearleadingZeros, $years);
            if ($res != false) {
                $out = true;
            } else {
                $out = false;
            }
            //            if($out===false){
            //                echo "returning FALSE---";
            //            }else {
            //                echo "returning NOT FALSE---";
            //            }

            return $out;
        }
    }
    //    public static function isValidYear($vehicleData, $registration=null)
    //    {
    //        if(empty($registration)){
    //           // echo 'empt';
    //            if($vehicleData['code'] == "")
    //            {
    //                return false;
    //            }
    //            $intYear = (int)$vehicleData['year'];
    //
    //            //return ($intYear >= 8 && $intYear <= 151);
    //            //echo 'year('.$intYear.') between:'.self::getBottomYearConditionLimit().' and '.self::getTopYearConditionLimit();
    //           // echo 'left'.(bool)($intYear >= self::getBottomYearConditionLimit());
    //           // echo 'right'.(bool)($intYear <= self::getTopYearConditionLimit());
    //            $out = (bool)((bool)($intYear >= self::getBottomYearConditionLimit()) && (bool)($intYear <= self::getTopYearConditionLimit()));
    //           // var_dump($out);
    //            return $out;
    //        }else {
    //           // echo '!empt';
    //            $intYear = (int)self::getCarYear($registration);
    //           // echo $intYear;
    //            $out = (bool)((bool)($intYear >= self::getBottomYearConditionLimit()) && (bool)($intYear <= self::getTopYearConditionLimit()));           
    //          //  echo $out;
    //            return $out;
    //            
    //        }
    //    }

    public static function getCurrentYear()
    {
        return date('y');
    }

    //    public static function getCurrentRegPhase($lvVehicleRegNumber) {
    //        $year = getCarYear($lvVehicleRegNumber);
    //        
    //        if ( strlen($year) >= 3) {
    //            return $year[2];
    //            //return $year[strlen($year)-1];
    //        }
    //        
    //        else {
    //            return 0;
    //        }
    //    }

    public static function getCurrentYearPhrase()
    {
        $currentMonth = date('m');

        if ($currentMonth > 6) {
            return 2;
        } else {
            return 1;
        }
    }

    public static function getTopYearConditionLimit()
    {
        $topYearLimit = self::getCurrentYear() - 1;
        $currentYearPhrase = self::getCurrentYearPhrase();

        return $topYearLimit . $currentYearPhrase;
    }

    public static function getBottomYearConditionLimit()
    {
        $currentYear = self::getCurrentYear();
        return $currentYear - 7;
    }

    public static function getCarYear($lvVehicleRegNumber)
    {
        $year = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $lvVehicleRegNumber);
        return $year[0];
    }

    public static function getFieldKeyForYear($fieldName, $lvVehicleYear, $carModel)
    {
        foreach ($carModel as $key => $value) {
            if ($value == $lvVehicleYear) {
                $key = preg_replace("/[^0-9]/", "", $key);
                return $fieldName . $key;
            }
        }
    }


    public static function getFieldValueForYear($fieldName, $lvVehicleYear, $carModel)
    {
        if (!empty($carModel)) {
            foreach ($carModel as $key => $value) {
                if ($value == $lvVehicleYear) {
                    $prefix = substr($key, 0, 2);

                    if ($prefix != 'yr') {
                        continue;
                    }
                    $key = preg_replace("/[^0-9]/", "", $key);
                    if (isset($carModel[$fieldName . $key])) {
                        return $carModel[$fieldName . $key];
                    }
                }
            }
        } else return null;
    }

    public static function multiplyUserKm($userKm)
    {
        return $userKm * 1000;
    }


    public static function getRiDataByRegLookUp($lvVehicleRegNumber)
    {
        $lvRIVehicleData = new RIVehicleData();
        return $lvRIVehicleData->vehicleFreeReport($lvVehicleRegNumber); // change this method
    }
    public static function getRiDataByRegLookUpChassis($lvVehicleRegNumber)
    {
        $lvRIVehicleData = new RIVehicleData(array(), false, true);
        return $lvRIVehicleData->vehicleFreeReport($lvVehicleRegNumber); // change this method
    }

    public static function getCarCommModel($selectModel, $codeNumber, $arch = null)
    {
        $model = "";
        if ($selectModel == "UsedCarsModel") {
            $orderField = 'id_used_cars';
            $joinCondition = 'used_cars.id = used_cars_model.id_used_cars';
        } else {
            $orderField = 'id_used_com_cars';
            $joinCondition = 'used_com_cars.id = used_com_cars_model.id_used_com_cars';
        }
        if (!empty($arch)) {
            $query = "SELECT * FROM " . (($selectModel == "UsedCarsModel") ? "`used_cars_model`, `used_cars`" : "`used_com_cars_model`, `used_com_cars`");
            $query .= " WHERE " . (($selectModel == "UsedCarsModel") ? "`used_cars`" : "`used_com_cars`") . ".id_import=" . $arch;
            $query .= " AND `codenumber` = '" . $codeNumber . "'";
            $query .= " AND " . $joinCondition;
        } else {
            $query = "SELECT * FROM " . (($selectModel == "UsedCarsModel") ? "`used_cars_model`" : "`used_com_cars_model`");
            $query .= " WHERE `codenumber` = '" . $codeNumber . "' ORDER BY `" . $orderField . "` DESC ";
        }

        $model = $selectModel::model()->findBySql($query);
        return $model;
    }
    public static function getTestCarCommModel($selectModel, $codeNumber, $arch = null)
    {
        $model = "";
        if ($selectModel == "UsedCarsModel") {
            $orderField = 'id_used_cars';
            $joinCondition = 'used_cars.id = used_cars_model.id_used_cars';
        } else {
            $orderField = 'id_used_com_cars';
            $joinCondition = 'used_com_cars.id = used_com_cars_model.id_used_com_cars';
        }
        if (!empty($arch)) {
            $query = "SELECT * FROM " . (($selectModel == "UsedCarsModel") ? "`used_cars_model`, `used_cars`" : "`used_com_cars_model`, `used_com_cars`");
            $query .= " WHERE " . (($selectModel == "UsedCarsModel") ? "`used_cars`" : "`used_com_cars`") . ".id_import=" . $arch;
            $query .= " AND `codenumber` = '" . $codeNumber . "'";
            $query .= " AND " . $joinCondition;
        } else {
            $query = "SELECT * FROM " . (($selectModel == "UsedCarsModel") ? "`used_cars_model`" : "`used_com_cars_model`");
            $query .= " WHERE `codenumber` = '" . $codeNumber . "' ORDER BY `" . $orderField . "` DESC ";
        }

        $model = $selectModel::model()->findBySql($query);
        return $model;
    }

    public static function getMain_AllCoreWithAssociatedCarsModel($selectModel, $model, $arch = null)
    {
        $selectCarType = ($selectModel == "UsedCarsModel") ? "id_used_cars" : "id_used_com_cars";
        $idUsedCars = $model[$selectCarType];
        $carCodenumber = $model['codenumber'];
        $carBod = $model['bod'];
        $result = "";
        /*/*
         *  SELECT * FROM `used_cars_model` WHERE `id_used_cars` = 25
         *  AND `codenumber` = model[codenumber] OR `corecode` = model[codenumber]
         */
        if (!empty($arch)) {
            if ($selectModel == "UsedCarsModel") {
                $tablename = 'used_cars_model';
                $idName = 'id_used_cars';
                $fieldList = 'id_used_cars, drs, bod, transmission, badgetype, codenumber, corecode, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, mdl,linkas, rge';
            } else {
                $fieldList = 'id_used_com_cars, drs, bod, transmission, badgetype, codenumber, corecode, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, mdl,linkas, rge';
                $tablename = 'used_com_cars_model';
                $idName = 'id_used_com_cars';
            }


            $query = "SELECT DISTINCT(`" . $tablename . "`.id), " . $fieldList . " FROM " . (($selectModel == "UsedCarsModel") ? "`used_cars_model`, `used_cars`" : "`used_com_cars_model`, `used_com_cars`");
            $query .= " WHERE " . (($selectModel == "UsedCarsModel") ? "`id_used_cars`" : "`id_used_com_cars`") . "='" . $idUsedCars . "' AND " . (($selectModel == "UsedCarsModel") ? "`used_cars`" : "`used_com_cars`") . ".id_import=" . $arch;
            $query .= " AND (`codenumber` = '" . $carCodenumber . "'";
            $query .= " OR `corecode` = '" . $carCodenumber . "')";

            // echo $query;
        } else {
            $query = "SELECT * FROM " . (($selectModel == "UsedCarsModel") ? "`used_cars_model`" : "`used_com_cars_model`");
            $query .= " WHERE " . (($selectModel == "UsedCarsModel") ? "`id_used_cars`" : "`id_used_com_cars`") . "='" . $idUsedCars . "'";
            $query .= " AND (`codenumber` = '" . $carCodenumber . "'";
            $query .= " OR `corecode` = '" . $carCodenumber . "')";
        }

        //TODO MW swiched of by body filter / search for associated cars. Aiden requested that on feedback sent to Alan by Nicola on the Thu 04/02/2016 16:23
        //$query .= " AND `bod` = '".$carBod."'";

        if ($selectModel == "UsedCarsModel")
            $result = UsedCarsModel::model()->findAllBySql($query);
        else
            $result = UsedComCarsModel::model()->findAllBySql($query);

        return $result;
    }

    public static function getRest_AllCoreWithAssociatedCarsModel($selectModel, $model, $arch = null)
    {
        $selectCarType = ($selectModel == "UsedCarsModel") ? "id_used_cars" : "id_used_com_cars";
        $idUsedCars = $model[$selectCarType];
        $carRge = $model['rge'];
        $carBod = $model['bod'];
        $mainCoreCar = $model['codenumber'];
        $result = "";
        /*/*
         *  SELECT * FROM `used_cars_model` WHERE `id_used_cars` = 25
         *  AND `rge` = 100
         *  AND `bod` = 'hatch'
         *  ORDER BY `mdl`
         */

        if (!empty($arch)) {
            if ($selectModel == "UsedCarsModel") {
                $tablename = 'used_cars_model';
                $idName = 'id_used_cars';
                $fieldList = 'id_used_cars, drs, bod, transmission, badgetype, codenumber, corecode, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, mdl,linkas';
                if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {

                    $fieldList = 'id_used_cars, drs, bod, transmission, badgetype, codenumber, corecode, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, mdl,linkas,  yearfrom, yearto,mtpvariant, mtptype, lmopmake, lmopmodel, lmoptype';
                }
            } else {
                $fieldList = 'id_used_com_cars, drs, bod, transmission, badgetype, codenumber, corecode, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, mdl,linkas';
                if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
                    $fieldList = 'id_used_com_cars, drs, bod, transmission, badgetype, codenumber, corecode, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, mdl,linkas, yearfrom, yearto,mtpvariant, mtptype, lmopmake, lmopmodel, lmoptype';
                }
                $tablename = 'used_com_cars_model';
                $idName = 'id_used_com_cars';
            }

            $query = "SELECT DISTINCT(`" . $tablename . "`.id), " . $fieldList . " FROM " . (($selectModel == "UsedCarsModel") ? "`used_cars_model`, `used_cars`" : "`used_com_cars_model`, `used_com_cars`");
            $query .= " WHERE " . (($selectModel == "UsedCarsModel") ? "`id_used_cars`" : "`id_used_com_cars`") . "='" . $idUsedCars . "' AND " . (($selectModel == "UsedCarsModel") ? "`used_cars`" : "`used_com_cars`") . ".id_import=" . $arch;
            $query .= " AND `rge` = '" . $carRge . "'";
            //TODO MW swiched of by body filter / search for associated cars. Aiden requested that on feedback sent to Alan by Nicola on the Thu 04/02/2016 16:23
            //$query .= " AND `bod` = '".$carBod."'";
            $query .= " AND `codenumber` <> '" . $mainCoreCar . "'";
            //$query .= " AND ".RegistrationService::getAllMdl($carMdl);
            $query .= " ORDER BY `mdl`";
        } else {
            $query = "SELECT * FROM " . (($selectModel == "UsedCarsModel") ? "`used_cars_model`" : "`used_com_cars_model`");
            $query .= " WHERE " . (($selectModel == "UsedCarsModel") ? "`id_used_cars`" : "`id_used_com_cars`") . "='" . $idUsedCars . "'";
            $query .= " AND `rge` = '" . $carRge . "'";
            //TODO MW swiched of by body filter / search for associated cars. Aiden requested that on feedback sent to Alan by Nicola on the Thu 04/02/2016 16:23
            //$query .= " AND `bod` = '".$carBod."'";
            $query .= " AND `codenumber` <> '" . $mainCoreCar . "'";
            //$query .= " AND ".RegistrationService::getAllMdl($carMdl);
            $query .= " ORDER BY `mdl`";
        }


        if ($selectModel == "UsedCarsModel")
            $result = UsedCarsModel::model()->findAllBySql($query);
        else
            $result = UsedComCarsModel::model()->findAllBySql($query);

        return $result;
    }

    public static function odometerCalculationByRegLookUp($coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc, $arch = null)
    {
        /*
         * return array('codenumber' => 'calculatedValue');
         */
        $calculatedCars = array();

        if ($skipCalc)
            return array();

        if (empty($arch)) {
            $import = Import::getLastImportData();
        } else {
            $import = Import::model()->with('usedCars')->find('t.id=' . $arch);
        }

        if (empty($import) || empty($import->id)) {
            return array();
        }

        foreach ($coreWithAssociatedCarsModel as $item) {
            $data = array(
                "km" => $userGuideKm,
                "year" => $vehicleYear,
                "fuel" => $item['fuel'],
                "guide" => RegistrationService::getFieldValueForYear('GRP', $vehicleYear, $item),
                "guideKm" => RegistrationService::getFieldValueForYear('kms', $vehicleYear, $item) * 1000,
                "import" => $import->id,
            );

            $adjustedValue = RegistrationService::getAdjustedValue($data);

            $itemCalculatedCars = array($item['codenumber'] => $adjustedValue);
            $calculatedCars = $calculatedCars + $itemCalculatedCars;
        }
        return $calculatedCars;
    }

    public static function odometerCalculationByRegLookUpCustomValue($customValue, $userGuideKm, $vehicleYear, $selectModel, $codeNumber, $arch = null)
    {
        // echo 'selected values:'.$selectModel.'-->'.$codeNumber;
        // exit;
        $model = RegistrationService::getCarCommModel($selectModel, $codeNumber, $arch);
        if (empty($model)) {
            //   echo 'empty';
            // exit;
        }
        if (empty($arch)) {
            $import = Import::getLastImportData();
        } else {
            $import = Import::model()->with('usedCars')->find('t.id=' . $arch);
        }
        $data = array(
            "km" => $userGuideKm,
            "year" => $vehicleYear,
            "fuel" => $model['fuel'],
            "guide" => $customValue,
            "guideKm" => RegistrationService::getFieldValueForYear('kms', $vehicleYear, $model) * 1000,
            "import" => $import->id,
        );
        return RegistrationService::getAdjustedValue($data);
    }

    public static function getCalculatedValueByCodeNumber($carsArray, $codenumber)
    {
        if (!empty($carsArray)) {
            return $carsArray[$codenumber];
        } else {
            return '';
        }
    }

    /**
     * Calculate odometer value
     * @param type $data
     * @return type
     */
    public static function getAdjustedValue($data)
    {
        //        var_dump($data);
        if (!empty($data)) {
            $km = $data['km'];
            $year = $data['year'];
            $fuel = $data['fuel'];
            $guide = $data['guide']; // ze znakiem euro
            $guide = substr((string)$guide, 3); // wycina 1 znak euro
            $guideKm = $data['guideKm']; // km z tabeli
            //            $carOrCom = $data['carOrCom'];
            //            $codenumber = $data['codenumber'];
            $id_import = $data['import'];

            $adjustedValue = '-';
            if ($fuel == 'P') {
                $adjustedValue = XmlPetrolBandsModel::countPetrol($km, $year, $guide, $guideKm, $id_import);
            } else if ($fuel == 'D') {
                $adjustedValue = XmlDieselBandsModel::countDiesel($km, $year, $guide, $guideKm, $id_import);
            } else {
                //                $adjustedValue = '-'; //'Valuation cannot be provided now.';
            }
        } else {
            echo 'DATA is empty';
            //            return null;
        }
        return $adjustedValue;
    }

    public static function getBestMatchedCar($params)
    {
        $car = null;
        $skip = 0;
        $vehicle = $params['vehicle'];
        //code upto same with the guide portal logic for reg lookup
        $carData = RegistrationService::getCarDetail($params);

        $car = $carData['car'];
        $skip = $carData['skip'];
        $returnInfo = array();

        if ($skip == 0) {
            $returnInfo['status'] = 'success';
        } else if ($skip == 3) {
            $returnInfo['status'] = 'unavailable';
            $returnInfo['msg'] = 'This vehicle is outside of our API valuation range because of age.';
            $resultsOut = array();
            $resultsOut['car'] = null;
            $resultsOut['info'] = $returnInfo;
        } else if ($skip == 4) {
            $returnInfo['status'] = 'unavailable';
            $returnInfo['msg'] = 'This vehicle is too new to have a value on our API right now.';
            $resultsOut = array();
            $resultsOut['car'] = null;
            $resultsOut['info'] = $returnInfo;
        } else {
            $returnInfo['status'] = 'unavailable';
            $returnInfo['msg'] = 'This vehicle doesnt have an API valuation right now.';

            $resultsOut = array();
            $resultsOut['car'] = null;
            $resultsOut['info'] = $returnInfo;
        }

        if ($skip == 0) {
            $info = $car->getValueAndKmsForYear($vehicle['year']);
            if (!empty($_POST['userGuideKm'])) {
                $import = Import::getLastImportData();
                $input = array();
                $kms =  $_POST['userGuideKm'] / 1000;
                $input['km'] = $kms;
                $input['year'] = $vehicle['year'];
                $input['fuel'] = $car['fuel'];
                $input['guide'] = $info['value']; // ze znakiem euro            
                $input['guideKm'] = $info['kms']; // km z tabeli          
                $input['import'] = $import->id;
                $input['codenumber'] = $car['codenumber'];
                $input['carOrCom'] = 'UsedCarsModel';
                $adjustedValueArray = UsedCars::odometerCalculation($input);
                $adjustedValue = $adjustedValueArray['adjustedValue'];

                if (Mobile::isNumber($adjustedValue)) {
                    $info['kms'] = $kms;
                    $info['value'] = $adjustedValue;
                } else {
                    $info['kms'] = $kms;
                    $info['value'] = $adjustedValue; //message on reason why not valueation provided - check odometerCalculation for returned details
                }
            }

            $resultsOut = array();
            $resultsOut['car'] = null;
            $resultsOut['info'] = $returnInfo;
            // $resultsOut['scoringLog'] = $scoringLog;

            if (!empty($car)) {
                $resultsOut['car'] = $car;
            }
        }

        return $resultsOut;
    }
    public static function getCarDetail($params)
    {
        $car = null;
        $vehicle = $params['vehicle'];
        $main_coreWithAssociatedCarsModel = $params['main_coreWithAssociatedCarsModel'];
        $rest_coreWithAssociatedCarsModel = $params['rest_coreWithAssociatedCarsModel'];

        $carResults = array_merge($main_coreWithAssociatedCarsModel, $rest_coreWithAssociatedCarsModel);
        //year validation
        $carTooOldOrYoung = false;
        $skip = 0;
        if (!RegistrationService::isValidYear($vehicle, $params['regNumber'])) {
            //year outside the range
            $carTooOldOrYoung = true;
            $skip = 3;
        } else {
            if (empty($vehicle['code'])) {
                $skip = 5;
            }
        }


        //GOLF ESTATE / HATCH
        if (strpos(strtolower($vehicle['model']), 'golf') !== false && strpos(strtolower($vehicle['body']), 'estate') !== false) {
            $vehicle['body'] = 'ESTATE/HATCH';
        }
        //VELAR
        if (strpos(strtolower($vehicle['model']), 'velar') !== false) {
            //echo "skip =4";
            $skip = 4;
        }

        /* if (
            $vehicle['make'] == "Toyota" &&
            strpos($vehicle['model'], "Yaris") !== false &&
            strpos($vehicle['model'], "Cross") !== false
        ) {
            // $vehicle['code'] = "";
            // echo "<pre>"; 
            // print_r($main_coreWithAssociatedCarsModel);
            // print_r($rest_coreWithAssociatedCarsModel);
            // //print_r($carResults); 
            // die;
            //$skip = 4;
        } */
        //echo "<pre>"; print_r($carResults); echo $vehicle['body']; die;
        //NEw car
        $RiRetrunedCode = null;
        if (!empty($vehicle['code'])) {
            $RiRetrunedCode = $vehicle['code'];
            $used_or_new = substr($vehicle['code'], 3, 2);

            //echo "code:".$used_or_new;
            if ($used_or_new == '12') {
                //echo "skip =4";
                $skip = 4;
                //echo "the 12 number";
            }
        }
        $textQuerriedUCars = array();
        if (empty($carResults) || RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])) {
            //MPV, JEEP, Estat

            if (empty($carResults)) {
                //try to get range by teh first part of teh Versik make:
                $temp = explode(' ', $vehicle['model']);

                if (isset($temp[0])) {
                    $rangeVeriskCandidate = $temp[0];
                } else {
                    $rangeVeriskCandidate = $vehicle['model'];
                }

                if (!empty($rangeVeriskCandidate)) {
                    $range = UsedCarsRanges::model()->find('rangedesc=:range_desc ORDER BY id desc', array('range_desc' => $rangeVeriskCandidate));

                    if (empty($range)) {
                        if (!RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])) {
                            $range = UsedCommsRanges::model()->find('rangedesc=:range_desc ORDER BY id desc', array('range_desc' => $rangeVeriskCandidate));
                        } else $range = null;
                    }

                    if (empty($range)) {
                        $skip = 0; // no cars in that range
                    }
                }
            } else {

                $rangeVeriskCandidate = $carResults[0]['rangecode'];
                $range = UsedCarsRanges::model()->find('rangecode=:range_code ORDER BY id desc', array('range_code' => $rangeVeriskCandidate));
                if (empty($range)) {
                    if (!RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])) {
                        $range = UsedCommsRanges::model()->find('rangecode=:range_code ORDER BY id desc', array('range_code' => $rangeVeriskCandidate));
                    } else $range = null;
                }
                // when MPV is returned we have wrong range returned from comercials but we want to look in the cars as well so we try the by name approach again (like above)
                if (empty($range)) {
                    $temp = explode(' ', $vehicle['model']);
                    if (isset($temp[0])) {
                        $rangeVeriskCandidate = $temp[0];
                    } else {
                        $rangeVeriskCandidate = $vehicle['model'];
                    }
                    if (!empty($rangeVeriskCandidate)) {
                        $range = UsedCarsRanges::model()->find('rangedesc=:range_desc ORDER BY id desc', array('range_desc' => $rangeVeriskCandidate));
                        if (empty($range)) {
                            if (!RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])) {
                                $range = UsedCommsRanges::model()->find('rangedesc=:range_desc ORDER BY id desc', array('range_desc' => $rangeVeriskCandidate));
                            } else $range = null;
                        }
                    }
                }

                if (empty($range)) {
                    $skip = 0; // no cars in that range
                }
            }
            //echo "<pre>"; print_r($range); die;
            $textQuerriedUCars = RegistrationService::getCarsByTextValuesFromVerisk($vehicle, 'UsedCarsModel', $range);
            //echo "<pre>"; print_r($textQuerriedUComms); die;
            if (!RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])) {
                $textQuerriedUComms = RegistrationService::getCarsByTextValuesFromVerisk($vehicle, 'UsedComCarsModel', $range);
            }

            if (!empty($textQuerriedUComms)) {
                if (is_array($textQuerriedUCars)) {
                    $carResultsText = array_merge($textQuerriedUCars, $textQuerriedUComms);
                } else {
                    $carResultsText = $textQuerriedUComms;
                }
            } else {
                $carResultsText = $textQuerriedUCars;
            }

            $carResults = array_merge($carResults, $carResultsText);
        }
        //echo "<pre>"; print_r($carResults); die;
        // code in theguide portal starts here
        // usort($carResults, function($a, $b) {
        //     if($a['id']==$b['id']) return 0;
        //     return $a['id'] < $b['id']?1:-1;

        // });
        // code in theguide portal ends here

        $filteredCars = RegistrationService::getValidVehicles($carResults, $vehicle);
        // echo "<pre>";
        // // var_dump($carResults);
        // print_r($filteredCars);
        // // print_r($range);
        // die;    
        $valuationArray = $scoringLog = array();

        if (!empty($filteredCars)) {
            $rawResults = RegistrationService::getScoreForValidVehicles($filteredCars, $vehicle);
            $results = $rawResults['score'];
            $valuationArray = $rawResults['values'];
            $scoringLog = $rawResults['scoreLog'];
        } else {
            $rawResults = RegistrationService::getScoreForNOTValidVehicles($carResults, $vehicle);
            $results = $rawResults['score'];
            $valuationArray = $rawResults['values'];
            $scoringLog = $rawResults['scoreLog'];
        }

        if (!empty($results) && is_array($results)) {
            //echo "<pre>"; print_r($results); die;
            if (RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])) {
                $bestCarId = RegistrationService::getFirstValuedVehicle($results, $valuationArray, null);
            } else {
                $bestCarId = RegistrationService::getFirstValuedVehicle($results, $valuationArray, $RiRetrunedCode);
            }

            if (empty($bestCarId)) {
                // original fallback (kept commented for reference)
                // $arrVal = array_keys($results);
                // $bestCarId = array_shift($arrVal);

                // Prefer using the model id passed in params when available.
                // If a used_*_model row exists that matches both the passed model id
                // and the model codenumber, prefer that DB row's id as bestCarId.
                if (!empty($params['model']) && is_object($params['model']) && isset($params['model']->id)) {
                    $bestCarId = $params['model']->id;
                    if (!empty($params['model']->codenumber)) {
                        // try to find a matching used car model row (cars and commercial tables)
                        $found = UsedCarsModel::model()->find('id_used_cars=:id AND codenumber=:code ORDER BY id DESC', array(':id' => $params['model']->id, ':code' => $params['model']->codenumber));
                        if (empty($found)) {
                            $found = UsedComCarsModel::model()->find('id_used_com_cars=:id AND codenumber=:code ORDER BY id DESC', array(':id' => $params['model']->id, ':code' => $params['model']->codenumber));
                        }
                        if (!empty($found) && isset($found->id)) {
                            $bestCarId = $found->id;
                        }
                    }
                } else {
                    // fallback to original behaviour if params['model']->id isn't available
                    $arrVal = array_keys($results);
                    $bestCarId = array_shift($arrVal);
                }
            }
            //$bestCarId=779373;
            $car = UsedComCarsModel::model()->findByPk($bestCarId);
            if (empty($car)) {
                $arrVal = array_keys($results);
                $car = UsedCarsModel::model()->findByPk($bestCarId);
            }
            Yii::log(
                "REG selection reg=" . (isset($params['regNumber']) ? $params['regNumber'] : '') .
                " ri_code=" . $RiRetrunedCode .
                " bestCarId=" . $bestCarId .
                " car=" . json_encode(is_object($car) ? $car->attributes : $car) .
                " vehicle=" . json_encode($vehicle),
                CLogger::LEVEL_ERROR,
                'application.registration'
            );
        } else {
            if (!empty($carResults) && is_array($carResults)) {
                $arrVal = array_values($carResults);
                $car = array_shift($arrVal);
            } else {
                if (!$carTooOldOrYoung) {
                    $skip = 1;
                }
            }
        }

        $regTemp = isset($_POST['VehicleRegNumber']) ? strtoupper(trim($_POST['VehicleRegNumber'])) : $params['vehicle']['registerVehicleNumber'];
        if ($regTemp == '161WH6' || $regTemp == '161WH112') {
            $car = UsedCarsModel::model()->find('codenumber=:codenumber ORDER BY ID DESC', array('codenumber' => '8002400474'));
        }

        $car_data = array('car' => $car, 'skip' => $skip);
        //echo "<pre>"; print_r($car_data); die;
        return $car_data;
    }

    public static function getFuelDescription($fuelCharacter)
    {
        if ($fuelCharacter == 'D') return 'Diesel';
        if ($fuelCharacter == 'P') return 'Petrol';
        if ($fuelCharacter == 'A') return 'Petrol';
        if ($fuelCharacter == 'E') return 'Electric';
        return 'N/A';
    }

    public static function displayRegFromAvailableData($data)
    {
        if (!empty($data['regNumber'])) {
            return $data['regNumber'];
        } else if (!empty($riReturn["registerVehicleNumber"])) {
            return $riReturn["registerVehicleNumber"];
        } else if (!empty($data['vehicle']['chassisArray']['VehicleData']['Registration'])) {
            return $data['vehicle']['chassisArray']['VehicleData']['Registration'];
        } else if (!empty($_GET['reg_number'])) {
            $regNumber = base64_decode($_GET['reg_number']);
            return $regNumber;
        } else {
            return "";
        }
    }
    public static function displayRegYear($regYear)
    {
        if (!empty($regYear)) {
            if (is_numeric(substr($regYear, 0, 1))) {
                return $regYear;
            } else {
                return "";
            }
        } else {
            return "";
        }
    }

    public static function displayFullYearForRegYear($regYear)
    {
        if (!empty($regYear)) {
            $decade = substr($regYear, 0, 2);
            $year = '20' . $decade;
        } else {
            $year = "";
        }
        return $year;
    }

    public static function isMPVorOtherNonCommercialBody($body)
    {
        $body = strtolower($body);

        if ($body == 'mpv' || $body == 'estate' || $body == 'estate/jeep' || $body == 'jeep') {
            return true;
        } else {
            return false;
        }
    }

    public static function setDisplayDataEmptyFields($data)
    {
        if (empty($data['car'])) {
            $data['car'] = new ArrayObject;
            $data['car']['codenumber'] = "";
            $data['car']['maker'] = "";
            $data['car']['badge'] = "";
            $data['car']['drs'] = "";
            $data['car']['bod'] = "";
            $data['car']['transmission'] = "";
            $data['car']->fuel = "";

            $data['car']->cc = "";
            $data['car']->drive = "";
            $data['car']['vehicle'] = ""; //MTP model
        }
        if (empty($data['range'])) {

            $data['range'] = new ArrayObject;
            $data['range']->rangedesc = "";
        }
        if (empty($data['vehicle'])) {
            $data['vehicle'] = new ArrayObject;
            //$data['vehicle']->rangedesc = "";
            $data['vehicle']['body'] = "";
            $data['vehicle']['year'] = "";
            $data['vehicle']['chassisArray']['VehicleData']['Make'] = "";
            $data['vehicle']['chassisArray']['VehicleData']['Model'] = "";
            $data['vehicle']['chassisArray']['VehicleData']['Colour'] = "";
            $data['vehicle']['chassisArray']['VehicleData']['Date_1st_Registration'] = "";
            $data['vehicle']['chassisArray']['VehicleData']['Engine_Number'] = "";
            $data['vehicle']['chassisArray']['VehicleData']['Chassis_Number_Clear'] = "";
            $data['vehicle']['chassisArray']['VehicleData']['Registration'] = "";
            $data['vehicle']['registerVehicleNumber'] = "";
        }
        if (empty($data['adjustedValue'])) {
            $data['adjustedValue'] = null;
        }
        if (empty($data['chassis'])) {
            $data['chassis'] = null;
        }
        if (empty($data['returnKms'])) {
            $data['returnKms'] = null;
        }
        if (empty($data['regNumber'])) {
            $data['regNumber'] = null;
        }
        return $data;
    }
    public static function getDisplayValues($data, $apiUser = null)
    {
        if (empty($apiUser)) {
            $apiUser = new ApiUsers;
            $apiUser->setDefaults();
        }
        //echo "<pre>"; print_r($data); die;
        $data = self::setDisplayDataEmptyFields($data);
        //echo "<pre>"; print_r($data); die;
        if (!empty($apiUser->display_function_name)) {
            $functionName = $apiUser->display_function_name;
            return self::$functionName($data, $apiUser);
        } else {
            return self::getVeriskDisplayValues($data, $apiUser);
        }
    }

    public static function getMTPDisplayValues($data, $apiUser)
    {
        if ($apiUser->display_mtp_code) {
            $outVehicle['mtp_code'] = $data['car']['codenumber']; //$trace['mtpCode'];    
        }
        ////////

        $outVehicle['MTPMake'] = $data['car']['maker']; //$vehicle['make'];
        $outVehicle['MTPModel'] = $data['car']['vehicle'];
        $outVehicle['MTPRange'] = $data['range']->rangedesc; //'Sportage';//$vehicle['model'];
        $outVehicle['MTPType'] = $data['car']['badge']; //'Sprint';//$item['badgetype'];
        //$outVehicle['MTPTypeStripped'] = $car['mtptype'];

        $outVehicle['Doors'] = $data['car']['drs'];
        $outVehicle['Body'] = $data['car']['bod'];
        $outVehicle['Transmission'] = $data['car']['transmission'];
        $outVehicle['Verisk_Body'] = $data['vehicle']['body']; //versik body type
        $outVehicle['Fuel'] = RegistrationService::getFuelDescription($data['car']->fuel); //'diesel';//$item['transmission'];
        $outVehicle['CC'] = $data['car']->cc;
        $outVehicle['Drive'] = $data['car']->drive;

        $outVehicle['RegYear'] = RegistrationService::displayRegYear($data['vehicle']['year']); //'152';//$item['transmission'];
        $outVehicle['FullYear'] = RegistrationService::displayFullYearForRegYear($outVehicle['RegYear']);

        if (empty($data['car']['bod'])) {
            $outVehicle["Verisk_Make"] = $data['vehicle']["make"];
            $outVehicle["Verisk_Model"] = $data['vehicle']["model"];
            $outVehicle["Verisk_Colour"] = $data['vehicle']["colour"];
            $outVehicle["Verisk_Transmission"] = $data['vehicle']["transmission"];
            $outVehicle["Verisk_Fuel"] = $data['vehicle']["fuel"];
            $outVehicle["Verisk_Engine"] = $data['vehicle']["engine"];
        }

        //////////////////////////////

        if (!empty($data['adjustedValue'])) {
            $str = preg_replace('/\D/', '', $data['adjustedValue']);
        } else {
            if (method_exists($data['car'], 'getValueAndKmsForYear')) {
                $grp = $data['car']->getValueAndKmsForYear($data['vehicle']['year']);
            } else {
                $grp = "";
                $grp['value'] = "";
            }

            $str = preg_replace('/\D/', '', $grp['value']);
        }

        $outVehicle['GRP'] = $str;
        $outVehicle['Kms'] = (string)$data['returnKms'];


        if ($data['chassis']) {
            $outVehicle['Verisk_Make'] = $data['vehicle']['chassisArray']['VehicleData']['Make'];
            $outVehicle['Verisk_Model'] = $data['vehicle']['chassisArray']['VehicleData']['Model'];
            $outVehicle['Verisk_Colour'] = $data['vehicle']['chassisArray']['VehicleData']['Colour'];
            $outVehicle['Verisk_DateOf1stReg'] = $data['vehicle']['chassisArray']['VehicleData']['Date_1st_Registration'];
            $outVehicle['Verisk_EngineNumber'] = $data['vehicle']['chassisArray']['VehicleData']['Engine_Number'];
            $outVehicle['Verisk_Chassis'] = $data['vehicle']['chassisArray']['VehicleData']['Chassis_Number_Clear'];
            //                        $outVehicle['Verisk_Body'] = $data['vehicle']['body'];//versik body type
            $outVehicle['RegNumber'] = $data['vehicle']['chassisArray']['VehicleData']['Registration'];
        }

        return $outVehicle;
    }

    public static function getVeriskDisplayValues($data, $apiUser)
    {
        //TEST API STYLE
        if ($apiUser->display_mtp_code) {
            if (!empty($data['vehicle']['codenumber'])) {

                $outVehicle['mtp_code'] = $data['vehicle']['codenumber']; //$trace['mtpCode'];    
            } else {
                $outVehicle['mtp_code'] = $data['car']['codenumber']; //$trace['mtpCode'];    
            }
        }
        $outVehicle['RegNumber'] = RegistrationService::displayRegFromAvailableData($data);
        $outVehicle['Make'] = $data['vehicle']['make'];
        $outVehicle['Model'] = $data['vehicle']['model'];
        $outVehicle['Body'] = $data['vehicle']['body'];
        $outVehicle['Transmission'] = $data['vehicle']['transmission'];
        $outVehicle['Fuel'] = $data['vehicle']['fuel'];
        $outVehicle['Engine'] = $data['vehicle']['engine'];

        $outVehicle['Colour'] = $data['vehicle']['colour'];
        $outVehicle['RegYear'] = RegistrationService::displayRegYear($data['vehicle']['year']); //'152';//$item['transmission'];
        $outVehicle['FullYear'] = RegistrationService::displayFullYearForRegYear($outVehicle['RegYear']); //'152';//$item['transmission'];

        //////////////////////////////
        if (!empty($apiUser->valuations) && ($apiUser->valuations == 1)) {
            if (!empty($data['adjustedValue'])) {
                //echo"<pre>";print_r($data);die;
                $str = preg_replace('/\D/', '', $data['adjustedValue']);
                if(!empty($data['vehicle']['year'])){
                    if (method_exists($data['car'], 'getValueAndKmsForYear')) {
                        $grp = $data['car']->getValueAndKmsForYear($data['vehicle']['year']);
                        $newprice = preg_replace('/\D/', '', $grp['newprice']); //added by yasir on 01-04-2024
                    }else{
                        $newprice = "";
                    }
                }
            } else {
                if (method_exists($data['car'], 'getValueAndKmsForYear')) {
                    $grp = $data['car']->getValueAndKmsForYear($data['vehicle']['year']);
                } else {
                    $grp = "";
                    $grp['value'] = "";
                }
                $str = preg_replace('/\D/', '', $grp['value']);
                $newprice = preg_replace('/\D/', '', $grp['newprice']); //added by yasir on 01-03-2024
            }

            $outVehicle['GRP'] = $str;
            $outVehicle['Kms'] = (string)$data['returnKms'];
            $outVehicle['NewPrice'] = $newprice;
        }

        if ($data['chassis']) {
            $outVehicle['Verisk_Chassis'] = $data['vehicle']['chassisArray']['VehicleData']['Chassis_Number_Clear'];
        }

        return $outVehicle;
    }
}
