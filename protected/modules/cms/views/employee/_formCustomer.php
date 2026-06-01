<div class="form">

    <h1>Rejestracja nowego klienta</h1>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'new-customer-form-newCustomer-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Pola oznaczone <span class="required">*</span> są wymagane.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'imie'); ?>
		<?php echo $form->textField($model,'imie'); ?>
		<?php echo $form->error($model,'imie'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nazwisko'); ?>
		<?php echo $form->textField($model,'nazwisko'); ?>
		<?php echo $form->error($model,'nazwisko'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pelna_nazwa_firmy'); ?>
		<?php echo $form->textField($model,'pelna_nazwa_firmy'); ?>
		<?php echo $form->error($model,'pelna_nazwa_firmy'); ?>
	</div>


      	<div class="row">
		<?php echo $form->labelEx($model,'nip'); ?>
		<?php echo $form->textField($model,'nip'); ?>
		<?php echo $form->error($model,'nip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'regon'); ?>
		<?php echo $form->textField($model,'regon'); ?>
		<?php echo $form->error($model,'regon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nr_telefonu'); ?>
		<?php echo $form->textField($model,'nr_telefonu'); ?>
		<?php echo $form->error($model,'nr_telefonu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nr_tel_kom'); ?>
		<?php echo $form->textField($model,'nr_tel_kom'); ?>
		<?php echo $form->error($model,'nr_tel_kom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fax'); ?>
		<?php echo $form->textField($model,'fax'); ?>
		<?php echo $form->error($model,'fax'); ?>
	</div>

        	<div class="row">
		<?php echo $form->labelEx($model,'ulica_i_nr_lokalu'); ?>
		<?php echo $form->textField($model,'ulica_i_nr_lokalu'); ?>
		<?php echo $form->error($model,'ulica_i_nr_lokalu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kod_pocztowy'); ?>
		<?php echo $form->textField($model,'kod_pocztowy'); ?>
		<?php echo $form->error($model,'kod_pocztowy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'miejscowosc'); ?>
		<?php echo $form->textField($model,'miejscowosc'); ?>
		<?php echo $form->error($model,'miejscowosc'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->