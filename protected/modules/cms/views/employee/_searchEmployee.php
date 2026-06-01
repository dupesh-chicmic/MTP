<div class="wide form">

<?php 
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model->uzytkownik,'login'); ?>
		<?php echo $form->textField($model->uzytkownik,'login',array('size'=>60,'maxlength'=>100)); ?>
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
		<?php echo $form->label($model,'data_zatrudnienia'); ?>
		<?php echo $form->textField($model,'data_zatrudnienia'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Szukaj'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->