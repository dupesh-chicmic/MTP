<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'form-Company-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Pola oznaczone <span class="required">*</span> są wymagane.</p>

	<?php echo $form->errorSummary($model); ?>

        <div class="row">
		<?php echo $form->labelEx($model,'typ_firmy'); ?>
		<?php echo $form->dropDownList($model,'typ_firmy', CHtml::listData(Slownik::getGroup('typ firmy'), 'wartosc', 'nazwa'), array('name'=>'Firma[typ_firmy]')); ?>
		<?php echo $form->error($model,'typ_firmy'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Aktualizuj'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->