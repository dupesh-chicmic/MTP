<?php
    if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){

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

    echo ''.$vehicle['make'].'<br/>';
    echo ''.$vehicle['model'].'<br/>';
    echo ''.$vehicle['colour'].'<br/>';
    echo ''.$vehicle['engine'].'<br/>';
    echo ''.$vehicle['fuel'].'<br/>';
    echo ''.$vehicle['transmission'].'<br/>';
    echo ''.$vehicle['body'].'<br/>';

    if(Yii::app()->params['is_test_version']){

        if(!empty($vehicle['code'])){
            echo ''.$vehicle['code'].'(verisk)<br/>';       
        }
    }

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

    $rawResults = RegistrationService::getScoreForNOTValidVehicles($carResults, $vehicle);
    $results = $rawResults['score'];
    $valuationArray = $rawResults['values'];
}

echo '<br>valuation array';
var_dump($valuationArray);
echo '<br>end valuation array';
var_dump($results);
$skip=0;
if(!empty($results) && is_array($results)){
    
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
}else {    

    if(!empty($carResults) && is_array($carResults)){
        $arrVal = array_values($carResults);
        $car = array_shift($arrVal);
    }else {
        $skip = 1;
    }
}

if($skip==0){
    if(Yii::app()->params['is_test_version']){
		echo ''.$car['bod'].'(MTP)<br/>';
                echo ''.$car['codenumber'].'(MTP)<br/>';
    }else {

	}
    
    
    echo '</div><!-- emp2-->';
}else {
    echo '</div><!-- emp2-->';
    echo '<br><div class="results emphasize2">Reg Lookup facility is undergoing an upgrade. <br>Please use <a href="'.Yii::app()->createUrl('mobile/gSelectMake').'">By Make/Model</a> during this time </div>';

}

if($skip==0){
if(empty($_POST['userGuideKm'])){
    $info = $car->getValueAndKmsForYear($vehicle['year']);    
}else {
    $info = $car->getValueAndKmsForYear($vehicle['year']);
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

?>
<br/>

<?php

    $kmsforthis = ( Mobile::isNumber($info['value']) ) ? '&euro;'.Mobile::displayValue($info['value']) : 'NA' ;

    $valueString = '<div class="results emphasize4" style="text-align:center; margin-bottom: -15px;">GUIDE Price:&nbsp '.$kmsforthis.'</div>';

    echo $valueString;

    $kmsString = '<div class="results emphasize2">With&nbsp: '.Mobile::displayKms($info['kms']).'&nbsp;Kms</div>';
    
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


}else{
    //website_type check    
    echo '<div class="ui-body ui-body-a ui-corner-all" data-theme="a" data-form="ui-body-a">';
    echo '<!--<div class="emphasize2">Your Vehicle</div>-->';

    echo '<div class="emphasize4" style="text-align:center;">'.strtoupper($_POST['VehicleRegNumber']).'</div>';

?>
<div class="emphasize2" style="text-align:center;">
<?php 
if(is_numeric($vehicle['year'])){
    if(strlen((String)$vehicle['year'])>2){
        echo Mobile::displayFullYearForRegYear($vehicle['year']).' ('.$vehicle['year'].')<br/>';// convert
    }else {
        echo Mobile::displayFullYearForRegYear($vehicle['year']).' <br/>';// convert
    }
}
$carTooOldOrYoung=false;
$skip=0;
if(!RegistrationService::isValidYear($vehicle, $_POST['VehicleRegNumber'])){

    $carTooOldOrYoung = true;
        $skip = 3;
    
}else {
    //echo 'V '.$vehicle['code'];
    if(empty($vehicle['code'])){

        $skip = 5;
    }
}
echo ''.$vehicle['make'].'<br/>';
echo ''.$vehicle['model'].'<br/>';
echo ''.$vehicle['colour'].'<br/>';
echo ''.$vehicle['engine'].'<br/>';
echo ''.$vehicle['fuel'].'<br/>';
echo ''.$vehicle['transmission'].'<br/>';


if(strpos(strtolower($vehicle['model']), 'golf') !== false && strpos(strtolower($vehicle['body']), 'estate') !== false){
    echo 'ESTATE/HATCH<br/>';
}else {
    echo ''.$vehicle['body'].'<br/>';
}
echo '<br/>';
echo 'Co2: '.(($vehicle['CO2']) ? $vehicle['CO2'] : "--").'<br/>';

if( $vehicle['previous_reg'] ){
    echo 'Previous Registration: '. $vehicle['previous_reg']. '<br/>';
}

if( !empty($vehicle['import_outside']) && ($vehicle['import_outside'] != 'false') ){
    echo 'Import outside of UK/Ire: '. $vehicle['import_outside']. '<br/>';
}

echo 'Tax Cost: '.(($vehicle['roadTax']) ? '€'.$vehicle['roadTax'] : "--").'<br/>';

if(strpos(strtolower($vehicle['model']), 'velar') !== false){
    $skip=4;
}

if( $vehicle['previous_reg'] ){
    // print_r($_POST);
    ?>
    <!-- <u><a href="" id="check_history">History Check</a></u> -->
    <form id="regFormMobile_history" style="" autocomplete="off" action="/index.php?r=registrationService/gCheckPlateNumberByRegLookUpMobile" method="POST"><div class="checkPlateForm">
        <div class="checkPlateNumber">
            <input id="check_ri_field" type="hidden" value="<?=$vehicle['previous_reg']?>" name="VehicleRegNumber" />
            <input id="user_kms" type="hidden" value="" name="userGuideKm" />    
        </div>
        <input type="hidden" value="<?=$_POST['usedCarComModel']?>" name="usedCarComModel" id="usedCarComModel" />    
        <input maxlength="12" type="hidden" value="<?=$_POST['importId']?>" name="importId" id="importId" />        
        <input type="hidden" value="<?=$_POST['useAjax']?>" name="useAjax" id="useAjax" /></div>        
    </form>
    <?php
}

$RiRetrunedCode=null;
if(!empty($vehicle['code'])){
    $RiRetrunedCode = $vehicle['code'];
    $used_or_new = substr($vehicle['code'], 3,2);
        //echo "code:".$used_or_new;
    if($used_or_new=='12'){
        //echo "skip =4";
        $skip=4;
        //echo "the 12 number";
    }
}
if(Yii::app()->params['is_test_version']){

    if(!empty($vehicle['code'])){
	//echo ''.$vehicle['body'].'(verisk)<br/>';
    
        echo ''.$vehicle['code'].'(verisk)<br/>';       
    }
}else {
	if(!empty($vehicle['code'])){
	//echo ''.$vehicle['body'].'(verisk)<br/>';
    
        echo '<!--'.$vehicle['code'].'(verisk)-->';       
    }
}
  
?>

     
<?php
$carResults = array_merge($main_coreWithAssociatedCarsModel,$rest_coreWithAssociatedCarsModel);
$calculatedArray = $calculatedMain_coreWithAssociatedCars+$calculatedRest_coreWithAssociatedCars;
$textQuerriedUCars = array();

//adding cars found by text

if(empty($carResults) || RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])){    
if(empty($carResults)){
    
    //try to get range by teh first part of teh Versik make:
    $temp = explode(' ', $vehicle['model']);
    if(isset($temp[0])){
        $rangeVeriskCandidate = $temp[0];        
    }else {
        $rangeVeriskCandidate = $vehicle['model'];
    }
    //echo "range candidate:".$rangeVeriskCandidate;
    if(!empty($rangeVeriskCandidate)){
        $range = UsedCarsRanges::model()->find('rangedesc=:range_desc ORDER BY id desc', array('range_desc'=>$rangeVeriskCandidate));
        //echo ' range CARS=>'.$range.'<= ';
        if(empty($range)){
            if(!RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])){
                $range = UsedCommsRanges::model()->find('rangedesc=:range_desc ORDER BY id desc', array('range_desc'=>$rangeVeriskCandidate));
            }else $range=null;
        }
        
        //echo "RANGE after by description".var_dump($range);
        if(empty($range)){
            $skip = 6;// no cars in that range
        }
    }
}else {
    $rangeVeriskCandidate = $carResults[0]['rangecode'];
   // echo "range candidate(range code):".$rangeVeriskCandidate;
    //get range of found car and apply to search
    $range = UsedCarsRanges::model()->find('rangecode=:range_code ORDER BY id desc', array('range_code'=>$rangeVeriskCandidate));
     //echo ' range2 CARS=>'.$range.'<= ';
        if(empty($range)){
			if(!RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])){
                //$range = UsedCommsRanges::model()->find('rangedesc=:range_desc ORDER BY id desc', array('range_desc'=>$rangeVeriskCandidate));
				$range = UsedCommsRanges::model()->find('rangecode=:range_code ORDER BY id desc', array('range_code'=>$rangeVeriskCandidate));
            }else $range=null;
        }
    // when MPV is returned we have wrong range returned from comercials but we want to look in the cars as well so we try the by name approach again (like above)
        if(empty($range)){
                $temp = explode(' ', $vehicle['model']);
                if(isset($temp[0])){
                    $rangeVeriskCandidate = $temp[0];        
                }else {
                    $rangeVeriskCandidate = $vehicle['model'];
                }
                if(!empty($rangeVeriskCandidate)){
                   // echo "RANGE TO LOOK FOR:".$rangeVeriskCandidate;
                    $range = UsedCarsRanges::model()->find('rangedesc=:range_desc ORDER BY id desc', array('range_desc'=>$rangeVeriskCandidate));
                    //echo ' range CARS=>'.$range.'<= ';
                    if(empty($range)){
                        if(!RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])){
                            $range = UsedCommsRanges::model()->find('rangedesc=:range_desc ORDER BY id desc', array('range_desc'=>$rangeVeriskCandidate));
                        }else $range=null;
                    }              
                }
    }
    if(empty($range)){
        $skip = 6;// no cars in that range
    }
}
    $textQuerriedUCars = RegistrationService::getCarsByTextValuesFromVerisk($vehicle, 'UsedCarsModel', $range);

	if(!RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])){

        $textQuerriedUComms = RegistrationService::getCarsByTextValuesFromVerisk($vehicle, 'UsedComCarsModel', $range);
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
$scoringLog = array();

if(!empty($filteredCars)){
    $rawResults = RegistrationService::getScoreForValidVehicles($filteredCars, $vehicle);
    $results = $rawResults['score'];
    $valuationArray = $rawResults['values'];
    $scoringLog = $rawResults['scoreLog'];
}else {
    $rawResults = RegistrationService::getScoreForNOTValidVehicles($carResults, $vehicle);
    $results = $rawResults['score'];
    $valuationArray = $rawResults['values'];
    $scoringLog = $rawResults['scoreLog'];
}

if(!empty($results) && is_array($results)){

	if(RegistrationService::isMPVorOtherNonCommercialBody($vehicle['body'])){
        $bestCarId = RegistrationService::getFirstValuedVehicle($results, $valuationArray, null);
    }else {
        $bestCarId = RegistrationService::getFirstValuedVehicle($results, $valuationArray, $RiRetrunedCode);
    }
    if(empty($bestCarId)){
        $arrVal = array_keys($results);
        $bestCarId = array_shift($arrVal);
    }
    
    $car = UsedComCarsModel::model()->findByPk($bestCarId);
    if(empty($car)){
        $arrVal = array_keys($results);
        $car = UsedCarsModel::model()->findByPk($bestCarId);
    }
}else {
    if(!empty($carResults) && is_array($carResults)){
        $arrVal = array_values($carResults);
        $car = array_shift($arrVal);
    }else {
        //car has no valuation in teh system
        if(!$carTooOldOrYoung){
            $skip = 1;
        }        
    }
}
$regTemp = strtoupper(trim($_POST['VehicleRegNumber']));
if($regTemp=='161WH6' || $regTemp=='161WH112'){
	$car = UsedCarsModel::model()->find('codenumber=:codenumber ORDER BY ID DESC', array('codenumber'=>'8002400474'));
}

if($skip==0){
    if(Yii::app()->params['is_test_version']){
		echo ''.$car['bod'].'(MTP)<br/>';
        echo ''.$car['codenumber'].'(MTP)<br/>';
    }else {
		echo '<!--'.$car['codenumber'].'(MTP)-->';    
	}
    
    
    echo '</div><!-- emp2-->';
}else if($skip==3){
    //outside of Valid years
    echo '</div><!-- emp2-->';
    echo '<br><div class="results emphasize2">This vehicle is outside of our app valuation range because of age.<br> But give us a call on <a href="tel:018775460">018775460</a> and we will help you out</div>';

}else if($skip==4){
    //velar and "12" codes - car too new
    echo '</div><!-- emp2-->';
    echo '<br><div class="results emphasize2">This vehicle is too new to have a value on our app right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out</div>';
}else {
    //skip = 5 as well
    echo '</div><!-- emp2-->';
    echo '<br><div class="results emphasize2">This vehicle doesn’t have an app valuation right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out</div>';
}

if($skip==0){
if(empty($_POST['userGuideKm'])){
    $info = $car->getValueAndKmsForYear($vehicle['year']);    
}else {
    $info = $car->getValueAndKmsForYear($vehicle['year']);  

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

?>
<br/>

<?php
    // if( $archMonth ){
    //     $archMonth = '( '.$archMonth.' )';
    // }

    $kmsforthis = ( Mobile::isNumber($info['value']) ) ? '&euro;'.Mobile::displayValue($info['value']) : 'NA' ;

    $valueString = '<div class="results emphasize4" style="text-align:center; margin-bottom: -10px;">GUIDE Price:&nbsp '.$kmsforthis.'</div>';

    echo $valueString;

    $kmsString = '<div class="results emphasize2" style="text-align:center; margin-bottom: -10px;">With&nbsp: '.Mobile::displayKms($info['kms']).'&nbsp;Kms</div>';

echo $kmsString;
echo '<div class="results emphasize2" >' . $archMonth . '</div>';
}//end skip 0
?>


<br/>

<style>
   .button-back {background: #ffd800; color: #000; width: 140px; text-align: center; cursor: pointer;
    padding: 15px;  border-radius: 45px; margin: 15px auto; font-size: 15px; font-weight: 500; }
  .button-back:focus, .button-back:hover {background: #d0b629; box-shadow: inset 0 3px 5px rgba(0, 0, 0, .8);}
.button-back svg {width: 17px; display: inline-block; vertical-align: middle; position: relative; top: -2px; margin-right: 10px;}
</style>

</div>

 <div class="btn_back btn_centre button-square">
		  <button class="buttonBack" onclick="goBack()"  id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none">
			<span><img src="images/mobile/previous.svg" class="img-fluid"/></span>
		  </button>
		</div> 
		
<!-- <div class="button-back" onclick="goBack()"  id="carGo" data-role="button">
       
    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
         viewBox="0 0 477.175 477.175" style="enable-background:new 0 0 477.175 477.175;" xml:space="preserve">
    <g> <path d="M145.188,238.575l215.5-215.5c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-225.1,225.1c-5.3,5.3-5.3,13.8,0,19.1l225.1,225
            c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1L145.188,238.575z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g>
    </g></svg>
    Go Back
 </div> -->

</div>

    <script type="text/javascript">
    function goBack(){
        window.location.href='<?php echo Yii::app()->createUrl('mobile/gSelectReg', array('regNumber'=>$_POST['VehicleRegNumber']));?>';
        //parent.history.back();
    }
    </script>



<?php

	$log = ""."\r\n";
    $log.= 'All cars found:'.sizeof($carResults)."\r\n";

    $log.= '<br>'."\r\n";
    $log.= 'Filtered to:'.sizeof($filteredCars)."\r\n";
    $log.= '<br>';
    //$displayResults = $filteredCars;
    if(sizeof($filteredCars)==0){
        //$displayResults = $filteredCars;
        $log.= " UN filtered cars scores:"."\r\n";
    }
    $log.= '<br>'."\r\n";    
    
    foreach($scoringLog as $key=>$val){
        $veh = UsedComCarsModel::model()->findByPk($key);
        if(empty($veh)){
            $veh = UsedCarsModel::model()->findByPk($key);
        }
        if(array_key_exists($veh->id, $valuationArray)){
            $log.= 'veh code:'.$veh->codenumber. ' score LOG:'.$val.' ID:'.$veh->id.' valuation for year:'.$valuationArray[$veh->id].'<BR>'."\r\n";
        }else {
            $log.= 'veh code:'.$veh->codenumber. ' score: LOG:'.$val.' ID:'.$veh->id.' <BR>'."\r\n";
        }
        
        
    }
    $log.= '<br>'."\r\n";
    foreach($results as $key=>$val){
        $veh = UsedComCarsModel::model()->findByPk($key);
        if(empty($veh)){
            $veh = UsedCarsModel::model()->findByPk($key);
        }
        if(array_key_exists($veh->id, $valuationArray)){
            $log.= 'veh code:'.$veh->codenumber. ' score:'.$val.' ID:'.$veh->id.' valuation for year:'.$valuationArray[$veh->id].'<BR>'."\r\n";
        }else {
            $log.= 'veh code:'.$veh->codenumber. ' score:'.$val.' ID:'.$veh->id.' <BR>'."\r\n";
        }
        
        
    }
    $log.= '<br>';
    $log.= 'Unfitered cars:'."\r\n";
if(Yii::app()->params['is_test_version']){
	echo $log;
    highlight_string("<?php\n\$data =\n" . var_export($carResults, true) . ";\n?>");
    //var_dump($carResults);
    
}else {
	file_put_contents('./protected/runtime/'.$_POST['VehicleRegNumber'].'_log'.time().'.log', "\r\n".date('Y-m-d H:i:s').' REG-->'.$_POST['VehicleRegNumber'].':'.$log,FILE_APPEND);
}
/*
"We cannot find a match to that registration plate at this time. Please search By Make/Model or contact us at info@mtp.ie and our research team will assist you. 
*/
} //Webiste_type_check
?>


<script type="text/javascript">
    $('#check_history').click(function(){
        $('#regFormMobile_history').submit();
    });
</script>