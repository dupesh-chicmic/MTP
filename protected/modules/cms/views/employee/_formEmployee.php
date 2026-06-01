<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pracownik-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Pola z  <span class="required">*</span> są wymagane.</p>

	<?php echo $form->errorSummary(array($model->pracownik, $model->uzytkownik)); ?>

	<div class="row">
		<?php echo $form->labelEx($model->uzytkownik,'login'); ?>
		<?php echo $form->textField($model->uzytkownik,'login',array('size'=>40,'maxlength'=>100)); ?>
		<?php echo $form->error($model->uzytkownik,'login'); ?>
	</div>

       	<div class="row">
		<?php echo $form->labelEx($model->uzytkownik,'haslo'); ?>
		<?php echo $form->passwordField($model->uzytkownik,'haslo',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model->uzytkownik,'haslo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->uzytkownik,'imie'); ?>
		<?php echo $form->textField($model->uzytkownik,'imie',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model->uzytkownik,'imie'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->uzytkownik,'nazwisko'); ?>
		<?php echo $form->textField($model->uzytkownik,'nazwisko',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model->uzytkownik,'nazwisko'); ?>
	</div>

       	<div class="row">
		<?php echo $form->labelEx($model->pracownik,'data_urodzenia'); ?>
		<?php echo $form->textField($model->pracownik,'data_urodzenia',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model->pracownik,'data_urodzenia'); ?>
	</div>

        	<div class="row">
		<?php echo $form->labelEx($model->pracownik,'data_zatrudnienia'); ?>
		<?php echo $form->textField($model->pracownik,'data_zatrudnienia',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model->pracownik,'data_zatrudnienia'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->pracownik->isNewRecord ? 'Twórz nowe konto pracownika' : 'Aktualizuj dane'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->