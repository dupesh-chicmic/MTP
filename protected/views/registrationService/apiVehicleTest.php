<?php /**
 * Widok w ktorym user wpisuje numer tablicy rejestracyjnej - Made for mobile only
 */
$style = "";

//Was in mobile - as a result only first check from RI.

echo CHtml::beginForm(Yii::app()->createUrl('registrationService/apiTester'), 'POST', array('style' =>$style,'autocomplete'=>'off' ));
?>
<div class="checkPlateForm">
    <div class="checkPlateNumber">
        <label>MTP Code number</label><br/>
        <?php echo CHtml::textField('mtp_code', '', array('id'=>'check_ri_field', 'class'=>"reg_field")); ?><br>
    </div>
    <?php echo CHtml::hiddenField('form_type' , 'makemodeltest', array('id' => 'form_type')); ?>
    <div >
        <label>Vehicle Year </label><br/>
        <?php echo CHtml::numberField('year', '', array('id'=>'year', 'class'=>"year", 'min'=> 0)); ?><br>
    </div>
    <div >
        <label>User Kms </label><br/>
        <?php echo CHtml::numberField('userkms', '', array('id'=>'userkms', 'class'=>"userkms", 'min'=> 0)); ?><br>
    </div>
    <label>Username</label><br>
    <?php 
    $options = array('testuser'=>'testuser', 'lmopuser'=>'lmopuser (website)', 'lmop01'=>'lmop01 (underwriting)','connollymg01'=>'connollymg01','mtpuserdesktop'=>'mtpuserdesktop');
    $users = CHtml::listData(ApiUsers::model()->findAll(), 'username', 'username');
    $options = array_merge($options,$users);
    echo CHtml::dropDownList('username','',$options); ?><br><br> 
</div>
<?php echo CHtml::submitButton('Check',array('class'=>'button1')); ?>

<?php echo CHtml::endForm(); ?>
