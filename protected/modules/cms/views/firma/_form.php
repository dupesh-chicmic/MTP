<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'firma-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nazwa_pelna'); ?>
		<?php echo $form->textField($model,'nazwa_pelna',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nazwa_pelna'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nazwa_skrocona'); ?>
		<?php echo $form->textField($model,'nazwa_skrocona',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'nazwa_skrocona'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nip'); ?>
		<?php echo $form->textField($model,'nip',array('size'=>13,'maxlength'=>13)); ?>
		<?php echo $form->error($model,'nip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'regon'); ?>
		<?php echo $form->textField($model,'regon'); ?>
		<?php echo $form->error($model,'regon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telefon'); ?>
		<?php echo $form->textField($model,'telefon',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'telefon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fax'); ?>
		<?php echo $form->textField($model,'fax',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'fax'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'typ_firmy'); ?>
		<?php echo $form->textField($model,'typ_firmy'); ?>
		<?php echo $form->error($model,'typ_firmy'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->