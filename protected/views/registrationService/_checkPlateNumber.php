<?php
    //inittal declarations
    $arch               = isset($_GET['arch'])?$_GET['arch']:'';
    $VehicleRegNumber   = isset($_GET['VehicleRegNumber'])?$_GET['VehicleRegNumber']:'';
    $style = $regPrefill = $option = "";    $i = 0;

    if(Yii::app()->params['website_type']==Yii::app()->params['website']['MOBILE']){
    echo CHtml::beginForm(Yii::app()->createUrl('registrationService/gCheckPlateNumberByRegLookUpMobile'), 'POST', array('id'=>'regFormMobile', 'style'=>$style,'autocomplete'=>'off' ));
    if(!empty($_GET['regNumber'])){
        $regPrefill = $_GET['regNumber'];
    }elseif(!empty($VehicleRegNumber)){
        $regPrefill = $VehicleRegNumber;
    }
    //archive options format
    $all = count($options);
    
    foreach($options as $item){
        $i++;
        // $month = ($i==1 && $all>1) ? "Current" : $item->nazwa;
        $month = $item->nazwa;
        $selected = isset($arch) && $arch == $item->id ? "selected='selected'":'';
        $option .= "<option value='".$item->id."' ".$selected.">$month</option>";
    }
?>
    <div class="checkPlateForm">
        <div class="checkPlateNumber">
            <select name="arch">
                <?php echo $option; ?>
            </select>
            <?php echo CHtml::textField('VehicleRegNumber', $regPrefill, array('placeholder'=>'Enter Registration', 'id'=>'check_ri_field', 'class'=>"reg_field", 'maxlength'=>12)); ?>
            <?php echo CHtml::textField('userGuideKm', '', array('placeholder'=>'Enter Kms (if known)', 'id'=>'user_kms', 'class'=>"reg_field", 'maxlength'=>12)); ?>
        </div>
        <?php echo CHtml::hiddenField('usedCarComModel', 'UsedComCarsModel', array('maxlength'=>12)); ?>
        <?php echo CHtml::hiddenField('importId', $importId, array('maxlength'=>12)); ?>        
        <?php echo CHtml::hiddenField('useAjax', 1); ?>
    </div>
    <div class="btn_go btn_centre button-circle">
       <button type="button" class="buttonGo" onclick="submitFormReg()" id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none" >Go</button>
    </div>
<br/>
   
<?php 

    echo CHtml::endForm();

    }else{  
    //website_type if check
        echo CHtml::beginForm(Yii::app()->createUrl('registrationService/checkPlateNumberByRegLookUpMobile'), 'POST', array('style'=>$style,'autocomplete'=>'off' ));
?>
<div class="checkPlateForm">
    <div class="checkPlateNumber">
        <?php echo CHtml::textField('VehicleRegNumber', '', array('id'=>'check_ri_field', 'class'=>"reg_field", 'maxlength'=>12)); ?>
    </div>
    <?php 
        echo CHtml::hiddenField('usedCarComModel', $usedCarComModel, array('maxlength'=>12));
        echo CHtml::hiddenField('importId', $importId, array('maxlength'=>12));
        echo CHtml::hiddenField('useAjax', 1); 
    ?>
</div>
    <?php 
        echo CHtml::submitButton('Check',array('class'=>'button1'));
        echo CHtml::endForm(); 
    }
?>