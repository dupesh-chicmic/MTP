<?php
/* @var $this QPayRealexRequestController */
/* @var $model QPayRealexRequest */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'qpay-realex-request-realexForm-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'currency'); ?>
		<?php echo $form->textField($model,'currency'); ?>
		<?php echo $form->error($model,'currency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>
		<?php echo $form->textField($model,'timestamp'); ?>
		<?php echo $form->error($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sha1hash'); ?>
		<?php echo $form->textField($model,'sha1hash'); ?>
		<?php echo $form->error($model,'sha1hash'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment1'); ?>
		<?php echo $form->textField($model,'comment1'); ?>
		<?php echo $form->error($model,'comment1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment2'); ?>
		<?php echo $form->textField($model,'comment2'); ?>
		<?php echo $form->error($model,'comment2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'auto_settle_flag'); ?>
		<?php echo $form->textField($model,'auto_settle_flag'); ?>
		<?php echo $form->error($model,'auto_settle_flag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'return_tss'); ?>
		<?php echo $form->textField($model,'return_tss'); ?>
		<?php echo $form->error($model,'return_tss'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account'); ?>
		<?php echo $form->textField($model,'account'); ?>
		<?php echo $form->error($model,'account'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_code'); ?>
		<?php echo $form->textField($model,'shipping_code'); ?>
		<?php echo $form->error($model,'shipping_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'merchant_response_url'); ?>
		<?php echo $form->textField($model,'merchant_response_url'); ?>
		<?php echo $form->error($model,'merchant_response_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_co'); ?>
		<?php echo $form->textField($model,'shipping_co'); ?>
		<?php echo $form->error($model,'shipping_co'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_cod'); ?>
		<?php echo $form->textField($model,'billing_cod'); ?>
		<?php echo $form->error($model,'billing_cod'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cust_num'); ?>
		<?php echo $form->textField($model,'cust_num'); ?>
		<?php echo $form->error($model,'cust_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'var_ref'); ?>
		<?php echo $form->textField($model,'var_ref'); ?>
		<?php echo $form->error($model,'var_ref'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prod_id'); ?>
		<?php echo $form->textField($model,'prod_id'); ?>
		<?php echo $form->error($model,'prod_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hpp_lang'); ?>
		<?php echo $form->textField($model,'hpp_lang'); ?>
		<?php echo $form->error($model,'hpp_lang'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'card_payment_button'); ?>
		<?php echo $form->textField($model,'card_payment_button'); ?>
		<?php echo $form->error($model,'card_payment_button'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->