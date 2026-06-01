<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'table_name'); ?>
		<?php echo $form->textField($model,'table_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'menu_top_label_pl'); ?>
		<?php echo $form->textField($model,'menu_top_label_pl',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'menu_top_label_en'); ?>
		<?php echo $form->textField($model,'menu_top_label_en',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'field_to_display'); ?>
		<?php echo $form->textField($model,'field_to_display',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'group'); ?>
		<?php echo $form->textField($model,'group'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'group_label'); ?>
		<?php echo $form->textField($model,'group_label',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'label_replace'); ?>
		<?php echo $form->textField($model,'label_replace',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'layout'); ?>
		<?php echo $form->textField($model,'layout',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'display'); ?>
		<?php echo $form->textField($model,'display'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'view_list'); ?>
		<?php echo $form->textField($model,'view_list',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'view_details'); ?>
		<?php echo $form->textField($model,'view_details',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'help'); ?>
		<?php echo $form->textField($model,'help'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deletable'); ?>
		<?php echo $form->textField($model,'deletable'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_display'); ?>
		<?php echo $form->textField($model,'admin_display'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_by'); ?>
		<?php echo $form->textField($model,'order_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'db_tbl_name'); ?>
		<?php echo $form->textField($model,'db_tbl_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orderable'); ?>
		<?php echo $form->textField($model,'orderable'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Szukaj'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->