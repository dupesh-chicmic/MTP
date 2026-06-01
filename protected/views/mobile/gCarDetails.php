<?php

    $car=null;
    if(!empty($data) && is_array($data)){
        if(sizeof($data)==1){
            $car = $data[0];
        }else {
            $car = $data[0];
            //echo 'more than one result';
        }
    }

    echo '<div class="table_ui ui-body ui-body-a ui-corner-all reg_sel" data-theme="a" data-form="ui-body-a">';
    echo '<div class="emphasize4"><span id="titleFieldFromXml">Your Vehicle</span></div>';
?> 
 
    <div class="emphasize2">

<?php 

    echo '<div class="mobile-show">';
    if(sizeof($_POST['year']>2)){
        echo Mobile::displayFullYearForRegYear($_POST['year']).' ('.$_POST['year'].')';// convert
    }else {
        echo Mobile::displayFullYearForRegYear($_POST['year']).' ';// convert
    }
    echo '</div>';
    echo '<div class="mobile-show">'.$car['maker'].'</div>';
    echo '<div>'.$car['vehicle'].'</div>';
    echo '<div class="mobile-show">'.$car['badge'].'</div>';
    echo '<div>'.strtoupper(Mobile::getFuelText($car['fuel'])).'</div>';
    echo '<div>'.strtoupper($car['transmission']).'</div>';
    echo '<div>'.strtoupper($car['bod']).'</div>';
    echo '<div>'.$car['drs'].' doors</div>';

    if(Yii::app()->params['is_test_version']){
        echo $car['codenumber'].' <br/>';
    }

    if(empty($_POST['userKms'])){
        $info = $car->getValueAndKmsForYear($_POST['year']);    
    }else {
        $info = $car->getValueAndKmsForYear($_POST['year']);  
        $input = array();
        $kms =  $_POST['userKms']/1000;
        $input['km']=$kms;
        $input['year']=$_POST['year'];
        $input['fuel']=$car['fuel'];            
        $input['guide']=$info['value']; // ze znakiem euro            
        $input['guideKm']=$info['kms']; // km z tabeli          
        $input['import']=$_POST['import_id'];            
        $input['codenumber']=$car['codenumber'];

        if($_POST['vehicle_type']=='cars'){
            $input['carOrCom']='UsedCarsModel';
            $adjustedValueArray = UsedCars::odometerCalculation($input);
        }else{
            $input['carOrCom']='UsedCarsComModel';
            $adjustedValueArray = UsedCars::odometerCalculation($input);
        }
        $adjustedValue = $adjustedValueArray['adjustedValue'];
        
        //echo 'adjustedValue'.$adjustedValue;
        if(Mobile::isNumber($adjustedValue)){                
            $info['kms']=$kms;
            $info['value']=$adjustedValue;
        }else {
           echo '<br><div class="results emphasize2"><span class=\'emphasize2\'>'.$adjustedValue.'</span></div>';
         }     
    }

	if(Mobile::isNumber($info['value'])){
        $valueString = '<div class="results emphasize4" style="text-align:center; margin-bottom: -15px;">Guide Price <span>&euro;'.Mobile::displayValue($info['value']).'</span></div>';
    }else {
        $valueString = '<div class="results emphasize3">Guide Price <span>NA</span></div>';
    }
    echo $valueString;

?>

</div>
<br/>

<?php

    $kmsString = '<div class="results emphasize2"><div class="res_desc">With&nbsp;</div><div class="res_res"><span class="emphasize2 text-left" style="text-align: left;">'.Mobile::displayKms($info['kms']).'&nbsp;Kms</span></div></div>';

    echo $kmsString;

    //start of the form to resend kms

    echo CHtml::beginForm(Yii::app()->createUrl('mobile/gCarDetails'), 'POST', array('id'=>'carsFormResult','autocomplete'=>'off' ));
    echo CHtml::hiddenField('vehicle_type', 'cars');
    echo CHtml::hiddenField('import_id', $_POST['import_id']);
    echo CHtml::hiddenField('year', $_POST['year']);
    echo CHtml::hiddenField('cars_mark_name', $_POST['cars_mark_name']);
    echo CHtml::hiddenField('cars_ranges', $_POST['cars_ranges']);
    echo CHtml::hiddenField('cars_model', $_POST['cars_model']);
    echo CHtml::hiddenField('cars_fuel', $_POST['cars_fuel']);
    echo CHtml::hiddenField('cars_transmission', $_POST['cars_transmission']);
    echo CHtml::hiddenField('cars_body', $_POST['cars_body']);
    echo CHtml::hiddenField('cars_doors', $_POST['cars_doors']);
    echo CHtml::hiddenField('cars_badge', $_POST['cars_badge']);

?>

	<div class="results emphasize3 dis-blk">
		<div class="res_desc"><?php echo CHtml::textField('userKms', '', array('placeholder'=>'Enter Kms','id'=>'user_kms', 'class'=>"reg_field", 'maxlength'=>12));?></div>
		<div class="res_res"><span class="emphasize3 text-left" style="text-align: left;">
        <a onclick="submitForm()" data-role="button" src="images/mobile/go.png" data-shadow="false" data-iconpos="notext" data-theme="none" >Go again!</a></span></div>
		
		 
	</div>
</div>
<div class="btn_back btn_centre button-square">
	  <button class="buttonBack" onclick="goBack()"  id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none">
		<span><img src="images/mobile/previous.svg" class="img-fluid"/></span>
	  </button>
</div> 
<?php echo CHtml::endForm(); ?>

<script type="text/javascript">
    function submitForm(){
        if(validate()){
            $('#carsFormResult').submit();   
        }else {
            alert('Please select all the fields.');
            return false;
        }
    }

    function validate(){
        if($('#carsFormResult #cars_badge').val()=='') return false;
        if($('#carsFormResult #cars_doors').val()=='') return false;
        if($('#carsFormResult #cars_transmission').val()=='') return false;
        if($('#carsFormResult #cars_fuel').val()=='') return false;
        if($('#carsFormResult #cars_model').val()=='') return false;
        if($('#carsFormResult #cars_ranges').val()=='') return false;
        if($('#carsFormResult #cars_mark_name').val()=='') return false;
        if($('#carsFormResult #year').val()=='') return false;
        return true;
    }

    function goBack(){
        window.location.href='<?php echo Yii::app()->createUrl('mobile/gSelectMake');?>';
    }
</script>
<style>
    .results.emphasize3.dis-blk { display: block; }
    .res_desc { float: left; margin-right: 6px; width: 70%; }
    .res_res { float: left; width: 20%; }
    .buttonBack, .buttonGo { cursor: pointer; left: 0px; margin: 0; }
    @media (max-width:479px){
        .res_desc { float: left; margin-right: 6px; width: 100%; text-align: center; }
        .res_res { float: left; width: 100%; text-align: center; }
        .res_res>span { float: none; }
        .buttonBack, .buttonGo { cursor: pointer; float: none; left: unset; margin: 0; }
        .btn_centre { text-align: center; margin: 10px; width: 100%; clear: both; float: left; }
    }
</style>