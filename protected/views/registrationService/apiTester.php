<?php
$style = "";
// DESKTOP version

// echo "<pre>";
// print_r($message);
// die;
echo CHtml::beginForm(Yii::app()->createUrl('registrationService/apiTester'), 'POST', array('style'=>$style,'autocomplete'=>'off' ));
?>
    <div class="checkPlateForm">
        <div class="checkPlateNumber">
            <label>Registration number</label><br/>
            <?php echo CHtml::textField('regnumber', '', array('id'=>'check_ri_field', 'class'=>"reg_field", 'maxlength'=>12)); ?><br>
        </div>
        <div >
            <label>User Kms </label><br/>
            <?php echo CHtml::textField('userkms', '', array('id'=>'userkms', 'class'=>"userkms")); ?><br>
        </div>
        <label>Username</label><br>
        <?php 
        $options = array('testuser'=>'testuser', 'lmopuser'=>'lmopuser (website)', 'lmop01'=>'lmop01 (underwriting)','connollymg01'=>'connollymg01','mtpuserdesktop'=>'mtpuserdesktop');
        $users = CHtml::listData(ApiUsers::model()->findAll(array(
            'condition'=>'status=:status',
            'params'=>array(':status'=>1)
        )), 'username', 'username');
        $options = array_merge($options,$users);
        echo CHtml::dropDownList('username','',$options); ?><br>
        <br>
        <label>Chassis</label><br>
        <?php echo CHtml::dropDownList('chassis','',array('0'=>'No','1'=>'Yes')); ?><br>
        <br>
    </div>
   <?php echo CHtml::submitButton('Check',array('class'=>'button1')); ?>
<?php echo CHtml::endForm(); ?>

