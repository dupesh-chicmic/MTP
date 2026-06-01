<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'uzytkownik-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'haslo'); ?>
		<?php echo $form->textField($model,'haslo',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'haslo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ostatnie_nieudane_logowanie'); ?>
		<?php echo $form->textField($model,'ostatnie_nieudane_logowanie'); ?>
		<?php echo $form->error($model,'ostatnie_nieudane_logowanie'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'typ_uzytkownika'); ?>
		<?php echo $form->textField($model,'typ_uzytkownika',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'typ_uzytkownika'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status_uzytkownika'); ?>
		<?php echo $form->textField($model,'status_uzytkownika',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'status_uzytkownika'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'imie'); ?>
		<?php echo $form->textField($model,'imie',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'imie'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nazwisko'); ?>
		<?php echo $form->textField($model,'nazwisko',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'nazwisko'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sid'); ?>
		<?php echo $form->textField($model,'sid',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'sid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lic_start'); ?>
		<?php echo $form->textField($model,'lic_start'); ?>
		<?php echo $form->error($model,'lic_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lic_exp_date'); ?>
		<?php echo $form->textField($model,'lic_exp_date'); ?>
		<?php echo $form->error($model,'lic_exp_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile_on'); ?>
		<?php echo $form->dropDownList($model,'mobile_on',array(0=>'Off',1=>'On')); ?>
		<?php echo $form->error($model,'mobile_on'); ?>
	</div>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->