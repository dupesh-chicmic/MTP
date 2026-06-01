<style>
.form .row .input-group-addon label {
    margin-bottom: 0px;
}
</style>

<?php $checksChecked = ($model->checks == '0') ? false : true; ?>

<br />
<a href="index.php?r=site/users">Back to list</a>
<hr>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>'index.php?r=site/updateUser&update='.$model->id,
	'id'=>'uzytkownik-user-form',
	'enableAjaxValidation'=>true,
//	'clientOptions'=>array(
//            'validateOnSubmit'=>true,
//	),    
)); ?>
    
	<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php
    if(Yii::app()->user->hasFlash('errorMsg')){
        echo '<div class="alert alert-danger" role="alert">';
        echo Yii::app()->user->getFlash('errorMsg');
        echo '</div>';
    }
    if(Yii::app()->user->hasFlash('successMsg')){
        echo '<div class="alert alert alert-success" role="alert">';
        echo Yii::app()->user->getFlash('successMsg');
        echo '</div>';
    }
?>
        
	<?php echo $form->errorSummary($model); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit',array('class'=>'btn btn-primary')); ?>
	</div>
    
<fieldset title="User information">
    <legend>User information</legend>
    <div class="row">    
    <div class="input-group">
      <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'login'); ?></span>
      <?php echo $form->textField($model,'login',array('class'=>'form-control')); ?>
    </div>
    </div>
    
    <div class="row">    
    <div class="input-group">
      <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'email'); ?></span>
      <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
    </div>
    </div>

    <div class="row"> 
    <div class="input-group">
      <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'imie'); ?></span>
      <?php echo $form->textField($model,'imie',array('class'=>'form-control')); ?>
    </div>
    </div>    

    <div class="row"> 
    <div class="input-group">
      <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'nazwisko'); ?></span>
      <?php echo $form->textField($model,'nazwisko',array('class'=>'form-control')); ?>
    </div>
    </div>
        
    <div class="alert alert-info" role="alert">If you leave this field blank password will not be changed.</div>
	<div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'haslo'); ?></span>
		<?php echo $form->textField($model,'haslo',array('value'=>'','class'=>'form-control')); ?>
        </div>
	</div>
    
	<div class="row" id="userDinkey" style="display: <?php echo ($checksChecked) ? "none" : "visible" ?>;">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'dinkey'); ?></span>
		<?php echo $form->dropDownList($model,'dinkey',array(0=>'Off',1=>'On'),array('class'=>'form-control')); ?>
        </div>
	</div> 

        <?php
//            echo '<div class="flash-notice">';
//                echo 'Access from mobiles';
//                echo '</div>';
        ?>    
	<div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'mobile_on'); ?></span>
		<?php echo $form->dropDownList($model,'mobile_on',array(0=>'Off',1=>'On'),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'mobile_on'); ?>
        </div>
	</div>  
    
    	<div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'network_licences_number'); ?></span>
                <?php echo $form->textField($model,'network_licences_number',array('class'=>'form-control')); ?>
		<?php //echo $form->dropDownList($model,'network_licences_number',array(0=>'Off',1=>'On'),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'network_licences_number'); ?>
        </div>
	</div> 

<!--
	<div class="row">
		<?php echo $form->labelEx($model,'pages'); ?>
		<?php echo $form->dropDownList($model,'pages',array(1=>'Show',0=>'Hide')); ?>
		<?php echo $form->error($model,'pages'); ?>
	</div>
-->
<?php
// usunac jak bedzie dinkey dongle
//echo $form->hiddenField($model,'trial',array('value'=>'1'));
//echo $form->hiddenField($model,'used_cars',array('value'=>'1'));
//echo $form->hiddenField($model,'used_com_cars',array('value'=>'1'));
// ---

?>
    
    <div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'checks'); ?></span>
        <div class="form-control"><?php echo $form->checkBox($model,'checks', array('id'=>'checkCheckbox')); ?></div>
        </div>
    </div>

    <div id="checksFields" style="display: <?php echo ($checksChecked) ? "visible" : "none" ?>;">
        <div class="row"> 
        <div class="input-group">
          <span class="input-group-addon" style="min-width: 180px;"><label for="paidTokens">Paid tokens</label></span>
          <input type="text" value="" name="paidTokens" id="paidTokens" class="form-control">
        </div>
        </div>

        <div class="row"> 
        <div class="input-group">
          <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'free_tokens'); ?></span>
          <?php echo $form->textField($model,'free_tokens',array('value'=>$model->free_tokens,'class'=>'form-control')); ?>
        </div>
        </div>
    </div>    
</fieldset>    

<fieldset id="trialOnOff" title="Trial On/Off" style="display: <?php echo ($checksChecked) ? "none" : "visible" ?>;">
    <legend>Trial On/Off</legend>
	<div class="row" id="userTrial">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'trial'); ?></span>
		<?php echo $form->dropDownList($model,'trial',array(1=>'On',0=>'Off'),array('class'=>'form-control')); ?>
        </div>
	</div>  
</fieldset>

<fieldset title="archive-sub-menu">
    <div class="alert alert alert-info" role="alert">
        <ul>
            <li>If trial is <b>On</b>, Cars/Commercial selected to <i>Show</i> will be visible on the main site (as sub-menu of Used Cars).</li>
            <li>If below options are selected to <i>Show</i>, Cars/Commercial will be visible in archive section.</li>
        </ul>
    </div>    
    <legend>Archive and sub-menu of Used Cars</legend>    
    <div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'used_cars'); ?></span>
        <?php echo $form->dropDownList($model,'used_cars',array(1=>'Show',0=>'Hide'),array('class'=>'form-control')); ?>
        </div>
    </div>

    <div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo $form->labelEx($model,'used_com_cars'); ?></span>
        <?php echo $form->dropDownList($model,'used_com_cars',array(1=>'Show',0=>'Hide'),array('class'=>'form-control')); ?>
        </div>
    </div>
</fieldset>    
    
<fieldset title="Licence for Used Cars - Desktop version">
    <legend>Licence for Used Cars - <span style="color: #337ab7;">Desktop</span> version</legend>
	<div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 300px;"><?php echo $form->labelEx($model,'lic_start_cars'); ?></span>
		<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'Uzytkownik[lic_start_cars]',
    // additional javascript options for the date picker plugin
    'value'=>$model->lic_start_cars,
    'language'=>Yii::app()->language,
    'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',        
    ),
    'htmlOptions'=>array(
        'class'=>'form-control'
    ),
));                
                ?>
        </div>
	</div>

	<div class="row" id="userLicExpDateCars" style="display: visible;">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 300px;"><?php echo $form->labelEx($model,'lic_exp_cars'); ?></span>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'Uzytkownik[lic_exp_cars]',
    'value'=>$model->lic_exp_cars,
    // additional javascript options for the date picker plugin
    'language'=>Yii::app()->language,
    'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',
    ),
    'htmlOptions'=>array(
         'class'=>'form-control'
    ),
));                
?>
        </div>
    </div>

</fieldset>

<fieldset title="Licence for Used Commercial - Desktop version">
    <legend>Licence for Used Commercial - <span style="color: #337ab7;">Desktop</span> version</legend>
	<div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 300px;"><?php echo $form->labelEx($model,'lic_start_comm'); ?></span>
		<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'Uzytkownik[lic_start_comm]',
    'value'=>$model->lic_start_comm,
    'language'=>Yii::app()->language,
    'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',        
    ),
    'htmlOptions'=>array(
        'class'=>'form-control'
    ),
));                
                ?>
        </div>
	</div>

	<div class="row" id="userLicExpDateComm" style="display: visible;">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 300px;"><?php echo $form->labelEx($model,'lic_exp_comm'); ?></span>
<?php //echo $form->textField($model,'lic_exp_date',array('id'=>'datepicker','class'=>'inputField iputBackground')); 
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'Uzytkownik[lic_exp_comm]',
    'value'=>$model->lic_exp_comm,
    'language'=>Yii::app()->language,
    'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',        
    ),
    'htmlOptions'=>array(
        'class'=>'form-control'
    ),
));                
?>
        </div>
	</div>
    
</fieldset>

<fieldset title="Licence for Used Cars - Mobile version">
    <legend>Licence for Used Cars - <span style="color: #67b168;">Mobile</span> version</legend>
	<div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 300px;"><?php echo $form->labelEx($model,'lic_start_cars_mob'); ?></span>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'Uzytkownik[lic_start_cars_mob]',
    'value'=>$model->lic_start_cars_mob,
    'language'=>Yii::app()->language,
    'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',        
    ),
    'htmlOptions'=>array(
        'class'=>'form-control'
    ),
));                
?>
        </div>
	</div>

	<div class="row" id="userLicExpDateCarsMobile" style="display: visible;">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 300px;"><?php echo $form->labelEx($model,'lic_exp_cars_mob'); ?></span>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'Uzytkownik[lic_exp_cars_mob]',
    'value'=>$model->lic_exp_cars_mob,
    'language'=>Yii::app()->language,
    'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',        
    ),
    'htmlOptions'=>array(
        'class'=>'form-control'
    ),
));                
?>
        </div>
	</div>
    
</fieldset>

<fieldset title="Licence for Used Commercial - Mobile version">
    <legend>Licence for Used Commercial - <span style="color: #67b168;">Mobile</span> version</legend>
	<div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 300px;"><?php echo $form->labelEx($model,'lic_start_comm_mob'); ?></span>
		<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'Uzytkownik[lic_start_comm_mob]',
    'value'=>$model->lic_start_comm_mob,
    'language'=>Yii::app()->language,
    'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',        
    ),
    'htmlOptions'=>array(
        'class'=>'form-control'
    ),
));                
                ?>
        </div>
	</div>

	<div class="row" id="userLicExpDateCommMobile" style="display: visible;">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 300px;"><?php echo $form->labelEx($model,'lic_exp_comm_mob'); ?></span>
<?php //echo $form->textField($model,'lic_exp_date',array('id'=>'datepicker','class'=>'inputField iputBackground')); 
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'Uzytkownik[lic_exp_comm_mob]',
    'value'=>$model->lic_exp_comm_mob,
    'language'=>Yii::app()->language,
    'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',        
    ),
    'htmlOptions'=>array(
        'class'=>'form-control'
    ),
));                
?>
        </div>
	</div>
    
</fieldset>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    showHideElements(document.getElementById("checkCheckbox").checked);    
    $('#checkCheckbox').bind('change',function() {
            var isChecked = document.getElementById("checkCheckbox").checked;
            showHideElements(isChecked);
        }
    );
    function showHideElements(isChecked)
    {
        if(isChecked){
            // hide expiry date, trial and dinkey
            document.getElementById("userLicExpDateCars").setAttribute('style', 'display:none;');
            document.getElementById("userLicExpDateComm").setAttribute('style', 'display:none;');
            document.getElementById("userLicExpDateCarsMobile").setAttribute('style', 'display:none;');
            document.getElementById("userLicExpDateCommMobile").setAttribute('style', 'display:none;');
            //document.getElementById("userTrial").setAttribute('style', 'display:none;');
            document.getElementById("trialOnOff").setAttribute('style', 'display:none;');
            document.getElementById("userDinkey").setAttribute('style', 'display:none;');
            document.getElementById("checksFields").setAttribute('style', 'display:visible;');
        } else {
            document.getElementById("userLicExpDateCars").setAttribute('style', 'display:visible;');
            document.getElementById("userLicExpDateComm").setAttribute('style', 'display:visible;');
            document.getElementById("userLicExpDateCarsMobile").setAttribute('style', 'display:visible;');
            document.getElementById("userLicExpDateCommMobile").setAttribute('style', 'display:visible;');
            //document.getElementById("userTrial").setAttribute('style', 'display:visible;');
            document.getElementById("trialOnOff").setAttribute('style', 'display:visible;');
            document.getElementById("userDinkey").setAttribute('style', 'display:visible;');
            document.getElementById("checksFields").setAttribute('style', 'display:none;');
        }        
    }
</script>
