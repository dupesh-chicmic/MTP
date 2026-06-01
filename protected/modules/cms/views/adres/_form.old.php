<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'adres-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ulica_i_nr_lokalu'); ?>
		<?php echo $form->textField($model,'ulica_i_nr_lokalu',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'ulica_i_nr_lokalu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kod_pocztowy'); ?>
		<?php echo $form->textField($model,'kod_pocztowy',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'kod_pocztowy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'miejscowosc'); ?>
		<?php echo $form->textField($model,'miejscowosc',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'miejscowosc'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->