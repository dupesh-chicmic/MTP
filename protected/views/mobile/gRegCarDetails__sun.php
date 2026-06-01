<?php
echo '<div class="ui-body ui-body-a ui-corner-all" data-theme="a" data-form="ui-body-a">';
echo '<!--<div class="emphasize2">Your Vehicle</div>-->';


echo '<div class="emphasize4" style="text-align:center;">'.strtoupper($_POST['VehicleRegNumber']).'</div>';

?>
<div class="emphasize2" style="text-align:center;">
<?php 
if(strlen((String)$vehicle['year'])>2){
    echo Mobile::displayFullYearForRegYear($vehicle['year']).' ('.$vehicle['year'].')<br/>';// convert
}else {
    echo Mobile::displayFullYearForRegYear($vehicle['year']).' <br/>';// convert
}
//var_dump($vehicle);
//echo ''.$vehicle['year'].'('.strlen((String)$vehicle['year']).')<br/>';
echo ''.$vehicle['make'].'<br/>';
echo ''.$vehicle['model'].'<br/>';
echo ''.$vehicle['colour'].'<br/>';
echo ''.$vehicle['engine'].'<br/>';
echo ''.$vehicle['fuel'].'<br/>';
echo ''.$vehicle['transmission'].'<br/>';
echo ''.$vehicle['body'].'<br/>';

if(Yii::app()->params['is_test_version']){

    if(!empty($vehicle['code'])){
	//echo ''.$vehicle['body'].'(verisk)<br/>';
    
        echo ''.$vehicle['code'].'(verisk)<br/>';       
    }
    }
  
//echo ''.$vehicle['CO2'].'<br/>';
//echo ''.$vehicle['roadTax'].'<br/>';
?>

     
<?php
$carResults = array_merge($main_coreWithAssociatedCarsModel,$rest_coreWithAssociatedCarsModel);
$calculatedArray = $calculatedMain_coreWithAssociatedCars+$calculatedRest_coreWithAssociatedCars;
$textQuerriedUCars = array();

//adding cars found by text

if(empty($carResults) || $vehicle['body']=='MPV'){    
if(empty($carResults)){
    //try to get range by teh first part of teh Versik make:
    $temp = explode(' ', $vehicle['model']);
    if(isset($temp[0])){
        $rangeVeriskCandidate = $temp[0];        
    }else {
        $rangeVeriskCandidate = $vehicle['model'];
    }
    if(!empty($rangeVeriskCandidate)){
        $range = UsedCarsRanges::model()->find('rangedesc=:range_desc ORDER BY id desc', array('range_desc'=>$rangeVeriskCandidate));
        //echo ' range CARS=>'.$range.'<= ';
        if(empty($range)){
            
             $range = UsedCommsRanges::model()->find('rangedesc=:range_desc ORDER BY id desc', array('range_desc'=>$rangeVeriskCandidate));
             //echo 'range COMMS=>'.$range.'<= ';
        }
        
       // var_dump($range);
    }
}else {
    $rangeVeriskCandidate = $carResults[0]['rangecode'];
    //get range of found car and apply to search
    $range = UsedCarsRanges::model()->find('rangecode=:range_code ORDER BY id desc', array('range_code'=>$rangeVeriskCandidate));
     //echo ' range2 CARS=>'.$range.'<= ';
        if(empty($range)){
             $range = UsedCommsRanges::model()->find('rangecode=:range_code ORDER BY id desc', array('range_code'=>$rangeVeriskCandidate));
              //echo ' range2 CARS=>'.$range.'<= ';
        }
   // var_dump($range);
}
    $textQuerriedUCars = RegistrationService::getCarsByTextValuesFromVerisk($vehicle, 'UsedCarsModel', $range);
    echo ' cars size:=>'.sizeof($textQuerriedUCars).'<=';
    if($vehicle['body']!='MPV'){
        $textQuerriedUComms = RegistrationService::getCarsByTextValuesFromVerisk($vehicle, 'UsedComCarsModel', $range);
        //var_dump($textQuerriedUComms);
        echo ' COMMS size:=>'.sizeof($textQuerriedUComms).'<=';
    }
    if(!empty($textQuerriedUComms)){
        if(is_array($textQuerriedUCars)){
            $carResultsText = array_merge($textQuerriedUCars, $textQuerriedUComms);
        }else {
            $carResultsText = $textQuerriedUComms;
        }
    }else {
        $carResultsText = $textQuerriedUCars;
    }
    
    $carResults = array_merge($carResults, $carResultsText);
}else {
    
}


$filteredCars = RegistrationService::getValidVehicles($carResults, $vehicle);

$valuationArray = array();

if(!empty($filteredCars)){
  //  echo '->a';
    $rawResults = RegistrationService::getScoreForValidVehicles($filteredCars, $vehicle);
    $results = $rawResults['score'];
    $valuationArray = $rawResults['values'];
}else {
  //  echo '->b';
   
    $rawResults = RegistrationService::getScoreForNOTValidVehicles($carResults, $vehicle);
    $results = $rawResults['score'];
    $valuationArray = $rawResults['values'];
}

//echo '<br>valuation array';
//var_dump($valuationArray);
//echo '<br>end valuation array';
//var_dump($results);
$skip=0;
if(!empty($results) && is_array($results)){
    //echo 'case 1->'.array_shift(array_keys($results)).'<-';
    
    //$arrVal = array_keys($results);
    
    //$forceCoreCode = true;//always force - remove if not nbecesary
    $bestCarId = RegistrationService::getFirstValuedVehicle($results, $valuationArray);
    if(empty($bestCarId)){
        $arrVal = array_keys($results);
        $bestCarId = array_shift($arrVal);
    }
    
    $car = UsedComCarsModel::model()->findByPk($bestCarId);
    if(empty($car)){
        $arrVal = array_keys($results);
        $car = UsedCarsModel::model()->findByPk($bestCarId);
    }
    //var_dump($car);
}else {    
    ///echo 'case 2';
    if(!empty($carResults) && is_array($carResults)){
        $arrVal = array_values($carResults);
        $car = array_shift($arrVal);
    }else {
        //Yii::app()->
        //echo 'Nothing to display';
        $skip = 1;
    }
}
//if(!empty($car)){
//    // also like getFirstValuedVehicle()!!!!!! below
//    
//    if(!empty($car->corecode)){
//       
//            if(isset($car->id_used_cars)){
//                $coreCar = UsedCarsModel::model()->find('codenumber=:codenumber AND id_used_cars=:idUsedCars', array('codenumber'=>$car->corecode, 'idUsedCars'=>$car->id_used_cars));
//            }else {
//                $coreCar = UsedComCarsModel::model()->find('codenumber=:codenumber AND id_used_com_cars=:idUsedCars', array('codenumber'=>$car->corecode, 'idUsedCars'=>$car->id_used_com_cars));
//            }
//            
//            $scoreCoreCar = RegistrationService::scoreTags($coreCar, $vehicle);
//            $arrVal = array_values($results);
//            $topValue = array_shift($arrVal);
//            
//            //var_dump($results);
//            echo '<br>!!!!!!!!! coreCarScore:'.$scoreCoreCar.'>='.$topValue;
//            if($scoreCoreCar>=$topValue){
//                $car = $coreCar;
//            }
//                    
//    }
//}

if($skip==0){
    //echo ''.$car['drs'].' door<br/>';
    
    if(Yii::app()->params['is_test_version']){
		echo ''.$car['bod'].'(MTP)<br/>';
                echo ''.$car['codenumber'].'(MTP)<br/>';
    }else {
		//echo ''.$car['bod'].'<br/>';
	}
    
    
    echo '</div><!-- emp2-->';
}else {
    echo '</div><!-- emp2-->';
    //echo '<br><div class="results emphasize2">We cannot find a match to that registration plate at this time. <br>Please search By <a href="'.Yii::app()->createUrl('mobile/gSelectMake').'">Make/Model</a> or contact us at <a href="mailto:info@mtp.ie">info@mtp.ie</a> and our research team will assist you. </div>';
    echo '<br><div class="results emphasize2">Reg Lookup facility is undergoing an upgrade. <br>Please use <a href="'.Yii::app()->createUrl('mobile/gSelectMake').'">By Make/Model</a> during this time </div>';

}

if($skip==0){
if(empty($_POST['userGuideKm'])){
    $info = $car->getValueAndKmsForYear($vehicle['year']);    
}else {
    $info = $car->getValueAndKmsForYear($vehicle['year']);  
    //var_dump($info);
    //exit;
    $import = Import::getLastImportData();
        $input = array();
            $kms =  $_POST['userGuideKm']/1000;
            $input['km']=$kms;
            $input['year']=$vehicle['year'];
            $input['fuel']=$car['fuel'];            
            $input['guide']=$info['value']; // ze znakiem euro            
            $input['guideKm']=$info['kms']; // km z tabeli          
            $input['import']=$import->id;
            $input['codenumber']=$car['codenumber'];
                //$input['carOrCom']='UsedCarsComModel';
                $input['carOrCom']='UsedCarsModel';
                //var_dump($input);exit;
                $adjustedValueArray = UsedCars::odometerCalculation($input);
            $adjustedValue = $adjustedValueArray['adjustedValue'];
            if(Mobile::isNumber($adjustedValue)){
                $info['kms']=$kms;
                $info['value']=$adjustedValue;
            }else {
               echo '<br><div class="results emphasize2"><span class=\'emphasize2\'>'.$adjustedValue.'</span></div>';

            }

}
//var_dump($results);



?>
<br/>

<!--<div class="results emphasize2">With&nbsp;<span class='emphasize2'><?php echo Mobile::displayKms($info['kms']); ?>&nbsp;Kms</span></div>-->
<?php
if(Mobile::isNumber($info['value'])){
        $valueString = '<div class="results emphasize3"><div class="res_desc">Guide Price&nbsp;</div><div class="res_res"><span class="emphasize3 text-left" style="text-align: left;">&euro;'.Mobile::displayValue($info['value']).'</span></div></div>';
    }else {
        $valueString = '<div class="results emphasize3"><div class="res_desc">Guide Price&nbsp;</div><div class="res_res"><span class="emphasize3 text-left" style="text-align: left;">NA</span></div></div>';
    }
echo $valueString;

$kmsString = '<div class="results emphasize2"><div class="res_desc">With&nbsp;</div><div class="res_res"><span class="emphasize2 text-left" style="text-align: left;">'.Mobile::displayKms($info['kms']).'&nbsp;Kms</span></div></div>';
//    }else {
//        $kmsString = '<div class="results emphasize2"><div class="res_desc">With&nbsp;</div><div class="res_res"><span class="emphasize2 text-left" style="text-align: left;">NA</span></div></div>';
//    }
echo $kmsString;
}//end skip 0
?>


<br/>
</div>
 <img class="buttonBack" onclick="goBack()" style="height: 100px; width: 100px;" id="carGo" 
     data-role="button" src="images/mobile/back.png" data-shadow="false" data-iconpos="notext" data-theme="none" />

</div>

    <script type="text/javascript">
    function goBack(){
        window.location.href='<?php echo Yii::app()->createUrl('mobile/gSelectReg', array('regNumber'=>$_POST['VehicleRegNumber']));?>';
        //parent.history.back();
    }
    </script>



<?php
if(Yii::app()->params['is_test_version']){
    echo 'All cars found:'.sizeof($carResults);
//    foreach($carResults as $key=>$val){
//        $veh = UsedComCarsModel::model()->findByPk($key);
//        if(empty($veh)){
//            $veh = UsedCarsModel::model()->findByPk($key);
//        }
//        echo 'Unfiterd veh:'.$veh->codenumber. 'score:'.$val.' ID:'.$veh->id.'<BR>';
//    }

    echo '<br>';
    echo 'Filtered to:'.sizeof($filteredCars);
    echo '<br>';
    //$displayResults = $filteredCars;
    if(sizeof($filteredCars)==0){
        //$displayResults = $filteredCars;
        echo " UN filtered cars scores:";
    }
    echo '<br>';
    foreach($results as $key=>$val){
        $veh = UsedComCarsModel::model()->findByPk($key);
        if(empty($veh)){
            $veh = UsedCarsModel::model()->findByPk($key);
        }
        if(array_key_exists($veh->id, $valuationArray)){
            echo 'veh code:'.$veh->codenumber. ' score:'.$val.' ID:'.$veh->id.' valuation for year:'.$valuationArray[$veh->id].'<BR>';
        }else {
            echo 'veh code:'.$veh->codenumber. ' score:'.$val.' ID:'.$veh->id.' <BR>';
        }
        
        
    }
    echo '<br>';
    echo 'Unfitered cars:';
    highlight_string("<?php\n\$data =\n" . var_export($carResults, true) . ";\n?>");
    //var_dump($carResults);
    
}
/*
"We cannot find a match to that registration plate at this time. Please search By Make/Model or contact us at info@mtp.ie and our research team will assist you. 
*/
?>


