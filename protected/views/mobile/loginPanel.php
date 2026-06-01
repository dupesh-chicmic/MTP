<?php
/*
 * Panel logowania
 */
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
    'action'=>Yii::app()->createUrl('mobile/login'),
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div class="admPnlLogRam">
    <div class="loginRow">
		<?php echo CHtml::label("Your login *",'login'); ?>
		<?php echo $form->textField($model,'login'); ?>
	</div>

	<div class="loginRow">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
	</div>

	<div class="loginRow">
		<?php echo CHtml::submitButton(Yii::t(Yii::app()->language.'_YiiTranslation', 'Login'), array('class'=>'','data-theme'=>'b')); ?>
	</div>
</div>
    
<?php $this->endWidget(); ?>
</div><!-- form -->
