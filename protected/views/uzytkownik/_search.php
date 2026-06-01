<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'login'); ?>
		<?php echo $form->textField($model,'login',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'haslo'); ?>
		<?php echo $form->textField($model,'haslo',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ostatnie_nieudane_logowanie'); ?>
		<?php echo $form->textField($model,'ostatnie_nieudane_logowanie'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'typ_uzytkownika'); ?>
		<?php echo $form->textField($model,'typ_uzytkownika',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status_uzytkownika'); ?>
		<?php echo $form->textField($model,'status_uzytkownika',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'imie'); ?>
		<?php echo $form->textField($model,'imie',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nazwisko'); ?>
		<?php echo $form->textField($model,'nazwisko',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sid'); ?>
		<?php echo $form->textField($model,'sid',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lic_start_cars'); ?>
		<?php echo $form->textField($model,'lic_start_cars'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lic_exp_cars'); ?>
		<?php echo $form->textField($model,'lic_exp_cars'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->label($model,'lic_start_comm'); ?>
		<?php echo $form->textField($model,'lic_start_comm'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lic_exp_comm'); ?>
		<?php echo $form->textField($model,'lic_exp_comm'); ?>
	</div>    

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->