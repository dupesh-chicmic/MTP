<div class="view_realex-invoiceForm">
<!--<h1>MTP online payment</h1>-->
<div class="form orangeBackground">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoice-realex-form',
	'enableAjaxValidation'=>true,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="medium-8 medium-centered columns">
		<?php echo $form->labelEx($model,'ac', array('class'=>'orange')); ?>
		<?php echo $form->textField($model,'ac', array('class'=>'input1')); ?>
		<?php echo $form->error($model,'ac'); ?>
        </div>
	</div>

	<div class="row">
   		 <div class="medium-8 medium-centered columns">
          	<div class="row">
            <div class="medium-3 columns">
                <?php echo $form->labelEx($model,'invoice1', array('class'=>'orange')); ?>
                <?php echo $form->textField($model,'invoice1', array('class'=>'input1')); ?>
                <?php echo $form->error($model,'invoice1'); ?>
            </div>
            <div class="medium-3  columns">
                <?php echo $form->labelEx($model,'invoice2', array('class'=>'orange')); ?>
                <?php echo $form->textField($model,'invoice2', array('class'=>'input1')); ?>
                <?php echo $form->error($model,'invoice2'); ?>
            </div>
            <div class="medium-3  columns">
                <?php echo $form->labelEx($model,'invoice3', array('class'=>'orange')); ?>
                <?php echo $form->textField($model,'invoice3', array('class'=>'input1')); ?>
                <?php echo $form->error($model,'invoice3'); ?>
            </div>
            <div class="medium-3  columns end">
                <?php echo $form->labelEx($model,'invoice4', array('class'=>'orange')); ?>
                <?php echo $form->textField($model,'invoice4', array('class'=>'input1')); ?>
                <?php echo $form->error($model,'invoice4'); ?>
            </div>
            </div>
    	</div>
    </div>
    
	<div class="row">
    <div class="medium-8 medium-centered columns">
		<?php echo $form->labelEx($model,'totalGrossAmount', array('class'=>'orange')); ?>
		<?php echo $form->textField($model,'totalGrossAmount', array('class'=>'input1','value'=>Yii::app()->numberFormatter->formatDecimal($model->totalGrossAmount))); ?>
		<?php echo $form->error($model,'totalGrossAmount'); ?>
    </div>
	</div>

	<div class="row">
    <div class="medium-8 medium-centered columns">
        <?php echo CHtml::label('Terms & Conditions <span style="color:red;">*</span>','termsAndConditions', array('class'=>'orange')); ?>
		<?php echo CHtml::checkbox('termsAndConditions','',array(''=>'')); ?>
        <?php echo CHtml::link('I have read the <span style="text-decoration:underline;">Terms & Conditions</span>', 'http://mtp.ie/payment-terms-and-conditions/', array('target'=>'_blank', 'id'=>'terms','class'=>'tandc cbox','style'=>'text-decoration:none;')); ?>
    </div>
	</div>
    
	<div class="row buttons">
    <div class="medium-8 medium-centered columns">
		<?php echo CHtml::submitButton('Proceed',array('id'=>'submitButton','class'=>'button1','disabled'=>'disabled;')); ?>
    </div>
	</div>
<?php $this->endWidget(); ?>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</div><!-- form -->
</div>


<?php Yii::app()->clientScript->registerScript('terms', '
jQuery(document).on("change", "#termsAndConditions", function() {
    var termsChecked = $("#termsAndConditions").prop("checked");
    if(termsChecked) {
        $("#submitButton").prop("disabled","");
    } else {
        $("#submitButton").prop("disabled","true");
    }
});
');
