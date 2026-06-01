<?php if(empty($hideFields['nazwa'])) { ?>
        <div class="registerField">
		<?php echo $form->labelEx($model,'nazwa'); ?>
		<?php echo $form->textField($model,'nazwa',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nazwa'); ?>
	</div>
<?php } ?>
	<div class="registerField">
		<?php echo $form->labelEx($model,'ulica_i_nr_lokalu'); ?>
		<?php echo $form->textField($model,'ulica_i_nr_lokalu',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'ulica_i_nr_lokalu'); ?>
	</div>

	<div class="registerField">
		<?php echo $form->labelEx($model,'kod_pocztowy'); ?>
		<?php echo $form->textField($model,'kod_pocztowy',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'kod_pocztowy'); ?>
	</div>

	<div class="registerField">
		<?php echo $form->labelEx($model,'miejscowosc'); ?>
		<?php echo $form->textField($model,'miejscowosc',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'miejscowosc'); ?>
	</div>

	<div class="registerField">
		<?php echo $form->labelEx($model,'kraj'); ?>
		<?php echo $form->textField($model,'kraj',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'kraj'); ?>
	</div>