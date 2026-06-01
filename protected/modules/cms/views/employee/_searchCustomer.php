<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model->uzytkownik,'id'); ?>
		<?php echo $form->textField($model->uzytkownik,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model->uzytkownik,'login'); ?>
		<?php echo $form->textField($model->uzytkownik,'login',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model->uzytkownik,'imie'); ?>
		<?php echo $form->textField($model->uzytkownik,'imie',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model->uzytkownik,'nazwisko'); ?>
		<?php echo $form->textField($model->uzytkownik,'nazwisko',array('size'=>30,'maxlength'=>30)); ?>
	</div>

    	<div class="row">
		<?php echo $form->label($model,'typ_klienta'); ?>
		<?php echo $form->textField($model,'typ_klienta',array('size'=>30,'maxlength'=>30)); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->