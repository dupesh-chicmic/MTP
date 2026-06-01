<?php
class RegistrationService 
{
    public static $PARAM_MOCK_DATA = false; 
    public static $PARAM_MOCK_REG_PLATE_NUMBER = "131D1234";//"131D1234";//"09D4406";//"131D15065";

    public static function mockRiData()
    {
        $returnedCode = "3002400265";//"3002400265"; //"3202400074";
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
            "importTitle"=> "RI",
            "year" => RegistrationService::getCarYear(self::$PARAM_MOCK_REG_PLATE_NUMBER),
            'body' => "RI",
        );
    }
    
    public static function getRiDataResults($lvVehicleRegNumber)
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
            if(self::$PARAM_MOCK_DATA)
            {
                // ----------- MOCK DATA -----------
                $lvVehicleRegNumber = self::$PARAM_MOCK_REG_PLATE_NUMBER;
                $riData = RegistrationService::mockRiData();
    //            echo "RI DATA<br /><pre>";
    //            print_r($riData);
    //            echo "</pre><br />END RI DATA<br />";
                return $riData;
                // ---------------------------------
            }
            else
            {
                
                $riData = RegistrationService::getRiDataByRegLookUp($lvVehicleRegNumber);
    //            echo "RI DATA<br /><pre>";
    //            print_r($riData);
    //            echo "</pre><br />END RI DATA<br />";
              //  var_dump($riData);
            }
   // }
        if(!empty($riData['errors'][0]))
        {
            return array('errors' => $riData['errors'][0]);
        }
        // array(2) { ["REPORTS"]=> array(0) { } ["matches"]=> string(1) "0" }
        if((isset($riData['matches']) && $riData['matches'] == "0"))
        {
            return array('errors' => 'No vehicle found');
        }
        
        $import = Import::getLastImportData();
        
        if(isset($riData['code']) && $riData['code'] != "")
        {
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
                "importTitle"=> $riData['importTitle'],//$import->nazwa,
                "year" => $riData['year'],//RegistrationService::getCarYear($lvVehicleRegNumber)
                'body' => $riData['VehicleData']['Body_Type'],
            );
        }
        else 
        {
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
                "importTitle"=> $import->nazwa,
                "year" => RegistrationService::getCarYear($lvVehicleRegNumber),
                'body' => $riData['VehicleData']['Body_Type'],
                    
            );
        }
        return $vehicleData;
    }
    
    public static function getScoreForValidVehicles($cars, $riResults){
        $out = array();
        foreach($cars as $car){
            //var_dump($car);
            //exit;
           // echo 'car:'.$car->id.':'.self::scoreTags($car, $riResults);
            $out[$car->id] = self::scoreTags($car, $riResults);
                
        }
        //var_dump($out);
        arsort($out);
        return $out;
    }
    
    public static function scoreTags($car, $riResults){
        $riString = $riResults['model'];
        $score=0;
        //$riTags = self::replaceWithDict($riString);
        $riTags = $riString;
        $mtpTags = self::getMtpTags($car);
        foreach($mtpTags as $mtpTag){
            if(strpos($riTags, $mtpTag)!==false){
              $score++;  
            }
        }
        $result = floatval($score/sizeof($mtpTags));
        return $result;
        
    }
    
    public static function getMtpTags($car){
        $tags = array();
        for($i=1;$i<=15;$i++){
            if(!empty($car['Tag'.$i])){
                $tags[]=$car['Tag'.$i];
            }
        }
        return $tags;                
    }
    
    public static function getValidVehicles($cars, $riResults){
        $out = array();
        foreach($cars as $car){
            if(self::passFirstSelection($car, $riResults)){
                $out[]=$car;
            }
        }
        return $out;
    }
    
    public static function passFirstSelection($car, $riResults){
        $passed = true;
       // var_dump($riResults);
        if(!self::matchFuel($car, $riResults['fuel'])){return false;}
        if(!self::matchTrans($car, $riResults['transmission'])){return false;}
        if(!self::matchEngine($car, $riResults['engine'])){return false;}
        if(!self::lookupDrive($car, $riResults['model'])){return false;}
        if(!self::matchYear($car, $riResults['year'])){return false;}
        if(!self::matchBody($car, $riResults['body'])){return false;}
        return $passed;
        
    }
    
    public static function matchTags($car, $riResults){
        $score = 0;
        foreach ($riResults as $riKey=>$riVal){
            if(self::matchField($car, $riVal, self::getFieldForRIKey($riKey))){
                $score++;
            }
        }
        return $score;
    }
    
    public static function matchField($car, $tag, $field){
        if(!$field){return false;}//field we don't compare on
        if($car[$field]==$tag){
            return true;
        }else return false;
    }
    
    public static function matchEngine($car, $riValue){
        $riEngineVar = str_replace('L', '', $riValue);
        $riEngineVar = str_replace('l', '', $riEngineVar);
        $riCalValue = floatval($riEngineVar);
        $riCalValue = $riCalValue*1000;
        $mtpCalValue = floatval($car->cc);
        if($mtpCalValue>$riCalValue){
            return false;
        }else {
            $diff = $riCalValue-$mtpCalValue;
            if($diff>90){
                return false;
            }else {return true;}
        }
        
    }
    public static function matchFuel($car, $riValue){
        //echo $riValue.' = '.$car['fuel'];
        if(strtolower($riValue) == 'diesel' && $car['fuel']=='D') return true;
        if(strtolower($riValue) == 'petrol' && $car['fuel']=='P') return true;
        if(strtolower($riValue) == 'electric' && $car['fuel']=='E') return true;
        //echo 'eliminated on Fuel';
        return false;
    }
    
    public static function lookupDrive($car, $riValue){
        //echo '<br>in drive ';
        $modelArray = explode(' ', $riValue);
            if(is_array($modelArray)){
                //echo 'is array ';
                foreach($modelArray as $val){
                    //echo ' val:'.$val;
                    $dict = TagsDict::getValues('Drive', $val);
                    if(!empty($dict)){
                        //echo ' has dict '.$dict->id.' mtpval:'.$dict->mtp_value;
                        return self::matchDrive($car, $dict->mtp_value);
                    }
                }
                //echo ' retuirning true1';
                return true;
            }else { 
                //echo ' retuirning true2';
                return true;
            }
    }
    public static function matchDrive($car, $riValue){
        //echo $riValue.' = '.$car['bod'];       
        
        //if(strtolower($riValue) == strtolower($car['bod'])) return true;
        if(strpos(strtolower($riValue),strtolower($car['drive']))!==false) return true;
        else {
            $dict = TagsDict::getValues('Body', $riValue);
            //var_dump($dict);
            if(is_array($dict)){
                $found = false;
                foreach($dict as $dictRow){
                    if($dictRow->mtp_value == $car[$dictRow->mtp_field]){
                        $found = true;
                    }
                }
//                Echo 'BODY MATCH FOUND:'.$found;
//                exit;
                return $found;
            }else {
            if(!empty($dict)){
                if($dict->mtp_value == $car[$dict->mtp_field]){
                    return true;
                }else return false;
            }
            }
            //echo 'eliminated on Body';      
            return false;
        }
    }
    
    public static function matchBody($car, $riValue){
        //echo $riValue.' = '.$car['bod'];
        
        //if(strtolower($riValue) == strtolower($car['bod'])) return true;
        if(strpos(strtolower($riValue),strtolower($car['bod']))!==false) return true;
        else {
            $dict = TagsDict::getValues('Body', $riValue);
            //var_dump($dict);
            if(is_array($dict)){
                $found = false;
                foreach($dict as $dictRow){
                    if($dictRow->mtp_value == $car[$dictRow->mtp_field]){
                        $found = true;
                    }
                }
//                Echo 'BODY MATCH FOUND:'.$found;
//                exit;
                return $found;
            }else {
//                echo 'not an array';
//                exit;
                if(!empty($dict)){
                    if($dict->mtp_value == $car[$dict->mtp_field]){
                        return true;
                    }else return false;
                }
            }
            //echo 'eliminated on Body';      
            return false;
        }
    }
    
    public static function matchYear($car, $riValue){
        $yearsArr = explode('/', $car->years);
                if(is_array($yearsArr)){
                    if($yearsArr[1]=='-'){
                        $yearsArr[1]=10000;
                    }
                    if($riValue<=$yearsArr[1] && $riValue>=$yearsArr[0]){
                        return true;
                    }else {
                        //echo 'eliminated on Year';      
                        return false;}
                }else {
                   // echo 'eliminated on Year';      
                    return false;}
               // echo 'eliminated on Year';      
        return false;
    }
    
    public static function matchTrans($car, $riValue){
        if(strtolower($riValue) == strtolower($car['transmission'])) return true;
        else {
            $dict = TagsDict::getValues('Transmission', $riValue);
            if(!empty($dict)){
                if($dict->mtp_value == $car[$dict->mtp_field]){
                    return true;
                }else return false;
            }
            ////echo 'eliminated on Trans';      
            return false;
        }
        
    }
    
    public static function getFieldForRIKey($riKey){

        $fields = array('year'=>'', 'make'=>'maker', 'model'=>'range', 'engine'=>'spec', 'fuel'=>'fuel', 'transmission'=>'', 'CO2'=>'', ''=>'', ''=>'', ''=>'', ''=>'', ''=>'');
        if(isset($fields[$riKey])){
            return $fields[$riKey];
        }else {
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
        if(!empty($model) && (isset($vehicleData['code']) && $vehicleData['code'] != ""))
        {
            $vehicleData["make"] = $model['maker'];
            $vehicleData["model"] = $model['vehicle'];
        }
        else
        {
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
    public static function isValidYear($vehicleData, $registration=null)
    {
        
        //this function is new - based on the years stired in the XML files rasther than calculations.
        $years = Mobile::getDisplayYears('Yrs2Display_ByReg.xml');
        if(empty($registration)){
           // echo 'empt';
            if($vehicleData['code'] == "")
            {
                return false;
            }
            $intYear = (int)$vehicleData['year'];
          
            
            
            $res = array_search($intYear, $years);
            if($res!=false){
                $out = true;
            }else {
                $out = false;
            }
            
            return $out;
        }else {
           // echo '!empt';
            $intYear = (int)self::getCarYear($registration);
            $res = array_search($intYear, $years);
            if($res!=false){
                $out = true;
            }else {
                $out = false;
            }
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
    
    public static function getCurrentYear() {
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
    
    public static function getCurrentYearPhrase () {
        $currentMonth = date('m');
        
        if ($currentMonth > 6) {
            return 2;
        }
        
        else {
            return 1;
        }
    }
    
    public static function getTopYearConditionLimit() {
        $topYearLimit = self::getCurrentYear() - 1;
        $currentYearPhrase = self::getCurrentYearPhrase();
        
        return $topYearLimit . $currentYearPhrase;
    }
    
    public static function getBottomYearConditionLimit() {
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
                $key = preg_replace("/[^0-9]/","",$key);
                return $fieldName.$key;
            }
        }
    }
    
    public static function getFieldValueForYear($fieldName, $lvVehicleYear, $carModel)
    {
    //var_dump($carModel);
    //exit;
       if(!empty($carModel)){
        if(!empty($carModel->attributes)){
           // echo 'object';
        }else {
          //  var_dump($carModel);
           // echo 'array';
        }
        foreach ($carModel as $key => $value) {
            if ($value == $lvVehicleYear) {
                $prefix = substr($key, 0, 2);
                
                if($prefix != 'yr'){
                    continue;
                }
//                echo $orgKeyBeforeChanges = $key;
//                echo "<< ".$value." fieldName=".$fieldName." key=[".$key." ";
                $key = preg_replace("/[^0-9]/","",$key);
//                echo $key."] ";
                
//                if($fieldName.$key == $orgKeyBeforeChanges)
//                {
//                    echo "fieldName+key=".$fieldName.$key."<br />";
                    if(isset($carModel[$fieldName.$key])) {
//                        echo $carModel[$fieldName.$key];
                        return $carModel[$fieldName.$key];
                    }
//                }
                
//                echo "<br />";
                //echo 'year='.$lvVehicleYear.' carModel['.$fieldName.$key.'] return='.$carModel[$fieldName.$key].'<br />';
                
//                return "";
//                return $carModel[$fieldName.$key];
            }
        }
    }else return null;
    
    }
    
    
    public static function multiplyUserKm($userKm)
    {
        return $userKm*1000;
    }
    
    public static function getRiDataByRegLookUp($lvVehicleRegNumber)
    {
        $lvRIVehicleData = new RIVehicleData();
        return $lvRIVehicleData->vehicleFreeReport($lvVehicleRegNumber);// change this method
    }
    

    public static function getCarCommModel($selectModel, $codeNumber, $arch=null)
    {
        //tu
        $model = "";
        if($selectModel == "UsedCarsModel") {
            $orderField = 'id_used_cars';
            $joinCondition = 'used_cars.id = used_cars_model.id_used_cars';
        }else {
            $orderField = 'id_used_com_cars';
            $joinCondition = 'used_com_cars.id = used_com_cars_model.id_used_com_cars';
            
        }
        // SELECT * FROM `used_cars_model` `t` WHERE codenumber = '3002400265' ORDER BY `id_used_cars` DESC LIMIT 1
        if(!empty($arch)){
            $query = "SELECT * FROM ".(($selectModel == "UsedCarsModel") ? "`used_cars_model`, `used_cars`" : "`used_com_cars_model`, `used_com_cars`");
            $query .= " WHERE ".(($selectModel == "UsedCarsModel") ? "`used_cars`" : "`used_com_cars`").".id_import=".$arch; 
            $query .= " AND `codenumber` = '".$codeNumber."'";
            $query .= " AND ".$joinCondition;
            //$query .= " OR `corecode` = '".$carCodenumber."')";
           // echo $query;
        }else {
            $query = "SELECT * FROM ".(($selectModel == "UsedCarsModel") ? "`used_cars_model`" : "`used_com_cars_model`");
            //$query .= " WHERE ".(($selectModel == "UsedCarsModel") ? "`id_used_cars`" : "`id_used_com_cars`")."='".$idUsedCars."'"; 
            $query .= " WHERE `codenumber` = '".$codeNumber."' ORDER BY `".$orderField."` DESC ";
            //$query .= " OR `corecode` = '".$carCodenumber."')";
        }
        
//        $criteria=new CDbCriteria;
//        $criteria->compare('t.codenumber', $codeNumber);
//        
////        if(!empty($arch)){
////            $criteria->with = 'used_cars_cars_model';
////            $criteria->compare('used_cars_cars_model.id_import', $arch);
////        }
//        $criteria->limit = '1';
        
        if($selectModel == "UsedCarsModel")
        {
            $model = UsedCarsModel::model()->findBySql($query);
//            if(!empty($arch)){
//                $criteria->with = 'used_cars_cars_model';
//                $criteria->compare('used_cars_cars_model.id_import', $arch);
//            }
//            $criteria->order = 'id_used_cars DESC';
//            $model = UsedCarsModel::model()->find($criteria);
        }
        else 
        {
//            if(!empty($arch)){
//                $criteria->with = 'used_cars_com_model';
//                $criteria->compare('used_cars_com_model.id_import', $arch);
//            }
//            $criteria->order = 't.id_used_com_cars DESC';
//            $model = UsedComCarsModel::model()->find($criteria);
            $model = UsedComCarsModel::model()->findBySql($query);
        }
        if(!empty($arch)){
           // var_dump($model);
        }
        return $model;
//        //var_dump($model);
//        if(!empty($model[0])) {
//            //echo 'm:'.$model[0]->id;
//            return $model[0];
//        }
//        else {return null;}
        
    }

    public static function getMain_AllCoreWithAssociatedCarsModel($selectModel, $model, $arch=null)
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
        if(!empty($arch)){
            if($selectModel == "UsedCarsModel"){
                $tablename = 'used_cars_model';
                $idName = 'id_used_cars';
                $fieldList = 'id_used_cars, drs, bod, transmission, badgetype, codenumber, corecode, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, mdl,linkas, rge';
            }else {
                $fieldList = 'id_used_com_cars, drs, bod, transmission, badgetype, codenumber, corecode, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, mdl,linkas, rge';
                $tablename = 'used_com_cars_model';
                $idName = 'id_used_com_cars';
            }
            
            
            $query = "SELECT DISTINCT(`".$tablename."`.id), ".$fieldList." FROM ".(($selectModel == "UsedCarsModel") ? "`used_cars_model`, `used_cars`" : "`used_com_cars_model`, `used_com_cars`");
            $query .= " WHERE ".(($selectModel == "UsedCarsModel") ? "`id_used_cars`" : "`id_used_com_cars`")."='".$idUsedCars."' AND ".(($selectModel == "UsedCarsModel") ? "`used_cars`" : "`used_com_cars`").".id_import=".$arch; 
            $query .= " AND (`codenumber` = '".$carCodenumber."'";
            $query .= " OR `corecode` = '".$carCodenumber."')";
            
           // echo $query;
        }else {
            $query = "SELECT * FROM ".(($selectModel == "UsedCarsModel") ? "`used_cars_model`" : "`used_com_cars_model`");
            $query .= " WHERE ".(($selectModel == "UsedCarsModel") ? "`id_used_cars`" : "`id_used_com_cars`")."='".$idUsedCars."'"; 
            $query .= " AND (`codenumber` = '".$carCodenumber."'";
            $query .= " OR `corecode` = '".$carCodenumber."')";
        }
        
        //TODO MW swiched of by body filter / search for associated cars. Aiden requested that on feedback sent to Alan by Nicola on the Thu 04/02/2016 16:23
        //$query .= " AND `bod` = '".$carBod."'";

        if($selectModel == "UsedCarsModel")
            $result = UsedCarsModel::model()->findAllBySql($query);
        else 
            $result = UsedComCarsModel::model()->findAllBySql($query);

        return $result;
    }  
    
    public static function getRest_AllCoreWithAssociatedCarsModel($selectModel, $model, $arch=null)
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
            
        if(!empty($arch)){
            if($selectModel == "UsedCarsModel"){
                $tablename = 'used_cars_model';
                $idName = 'id_used_cars';
                $fieldList = 'id_used_cars, drs, bod, transmission, badgetype, codenumber, corecode, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, mdl,linkas';
            }else {
                $fieldList = 'id_used_com_cars, drs, bod, transmission, badgetype, codenumber, corecode, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, mdl,linkas';
                $tablename = 'used_com_cars_model';
                $idName = 'id_used_com_cars';
            }
        
            $query = "SELECT DISTINCT(`".$tablename."`.id), ".$fieldList." FROM ".(($selectModel == "UsedCarsModel") ? "`used_cars_model`, `used_cars`" : "`used_com_cars_model`, `used_com_cars`");
            $query .= " WHERE ".(($selectModel == "UsedCarsModel") ? "`id_used_cars`" : "`id_used_com_cars`")."='".$idUsedCars."' AND ".(($selectModel == "UsedCarsModel") ? "`used_cars`" : "`used_com_cars`").".id_import=".$arch; 
            $query .= " AND `rge` = '".$carRge."'";
            //TODO MW swiched of by body filter / search for associated cars. Aiden requested that on feedback sent to Alan by Nicola on the Thu 04/02/2016 16:23
            //$query .= " AND `bod` = '".$carBod."'";
            $query .= " AND `codenumber` <> '".$mainCoreCar."'";
            //$query .= " AND ".RegistrationService::getAllMdl($carMdl);
            $query .= " ORDER BY `mdl`";
        }else {
            $query = "SELECT * FROM ".(($selectModel == "UsedCarsModel") ? "`used_cars_model`" : "`used_com_cars_model`");
            $query .= " WHERE ".(($selectModel == "UsedCarsModel") ? "`id_used_cars`" : "`id_used_com_cars`")."='".$idUsedCars."'"; 
            $query .= " AND `rge` = '".$carRge."'";
            //TODO MW swiched of by body filter / search for associated cars. Aiden requested that on feedback sent to Alan by Nicola on the Thu 04/02/2016 16:23
            //$query .= " AND `bod` = '".$carBod."'";
            $query .= " AND `codenumber` <> '".$mainCoreCar."'";
            //$query .= " AND ".RegistrationService::getAllMdl($carMdl);
            $query .= " ORDER BY `mdl`";
        }
        

        if($selectModel == "UsedCarsModel")
            $result = UsedCarsModel::model()->findAllBySql($query);
        else 
            $result = UsedComCarsModel::model()->findAllBySql($query);

        return $result;
    }  
    
    public static function odometerCalculationByRegLookUp($coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc, $arch=null)
    {
        /*
         * return array('codenumber' => 'calculatedValue');
         */
        $calculatedCars = array();
        
        if($skipCalc)
            return array();
        
        foreach($coreWithAssociatedCarsModel as $item)
        {
            if(empty($arch)){
                $import = Import::getLastImportData();
            }else {
                $import = Import::model()->with('usedCars')->find('t.id='.$arch);
            }
            
            $data = array(
                "km" => $userGuideKm,
                "year" => $vehicleYear,
                "fuel" => $item['fuel'],
                "guide" => RegistrationService::getFieldValueForYear('GRP', $vehicleYear, $item),
                "guideKm" => RegistrationService::getFieldValueForYear('kms', $vehicleYear, $item)*1000,
                "import" => $import->id,
            );

            $adjustedValue = RegistrationService::getAdjustedValue($data);
            
            $itemCalculatedCars = array($item['codenumber'] => $adjustedValue);
            $calculatedCars = $calculatedCars + $itemCalculatedCars;
        }
        return $calculatedCars;
    }
    
    public static function odometerCalculationByRegLookUpCustomValue($customValue, $userGuideKm, $vehicleYear, $selectModel, $codeNumber, $arch=null)
    {
       // echo 'selected values:'.$selectModel.'-->'.$codeNumber;
       // exit;
        $model = RegistrationService::getCarCommModel($selectModel, $codeNumber, $arch);
        if(empty($model)){
         //   echo 'empty';
           // exit;
        }
        if(empty($arch)){
            $import = Import::getLastImportData();
        }else {
            $import = Import::model()->with('usedCars')->find('t.id='.$arch);
        }
        $data = array(
            "km" => $userGuideKm,
            "year" => $vehicleYear,
            "fuel" => $model['fuel'],
            "guide" => $customValue,
            "guideKm" => RegistrationService::getFieldValueForYear('kms', $vehicleYear, $model)*1000,
            "import" => $import->id,
        );
        return RegistrationService::getAdjustedValue($data);
    }
    
    public static function getCalculatedValueByCodeNumber($carsArray, $codenumber)
    {
        if(!empty($carsArray)){
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
        if( !empty($data) ){
            $km = $data['km'];
            $year = $data['year'];
            $fuel = $data['fuel'];            
            $guide = $data['guide']; // ze znakiem euro
            $guide = substr((string)$guide,3); // wycina 1 znak euro
            $guideKm = $data['guideKm']; // km z tabeli
//            $carOrCom = $data['carOrCom'];
//            $codenumber = $data['codenumber'];
            $id_import = $data['import'];

            $adjustedValue = '-';
            if($fuel == 'P') {
                $adjustedValue = XmlPetrolBandsModel::countPetrol($km, $year, $guide, $guideKm, $id_import);
            } else if($fuel == 'D') {
                $adjustedValue = XmlDieselBandsModel::countDiesel($km, $year, $guide, $guideKm, $id_import);
            } else {
//                $adjustedValue = '-'; //'Valuation cannot be provided now.';
            }
        }
        else
        {
            echo 'DATA is empty';
//            return null;
        }
        return $adjustedValue;
    }

}
