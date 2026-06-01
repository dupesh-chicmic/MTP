<?php 
$modelContact = new ContactForm;

if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
        'action'=>'index.php?r=cms/cmsPage/contact&url='.$_GET['url'],
	'enableClientValidation'=>true,
	'clientOptions'=>array(
            'validateOnSubmit'=>true,
	),
)); ?>

        <p class="note"><span class="requiredText"><?php echo Yii::t(Yii::app()->language.'_YiiTranslation', 'Fields with * are required'); ?></span></p>

	<?php echo $form->errorSummary($modelContact); ?>

	<div class="row">
		<?php echo $form->labelEx($modelContact,'name'); ?>
		<?php echo $form->textField($modelContact,'name', array('class'=>'input1')); ?>
		<?php echo $form->error($modelContact,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContact,'email'); ?>
		<?php echo $form->textField($modelContact,'email', array('class'=>'input1'), array('class'=>'input1')); ?>
		<?php echo $form->error($modelContact,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContact,'subject'); ?>
		<?php echo $form->textField($modelContact,'subject', array('class'=>'input1','size'=>50,'maxlength'=>128, 'style'=>'width: 310pt;')); ?>
		<?php echo $form->error($modelContact,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelContact,'body'); ?>
		<?php echo $form->textArea($modelContact,'body',array('rows'=>6, 'cols'=>52, 'class'=>'textarea')); ?>
		<?php echo $form->error($modelContact,'body'); ?>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		
		<div class="verifyCode">
                    <?php echo $form->labelEx($modelContact,'verifyCode'); ?>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($modelContact,'verifyCode', array('class'=>'input1')); ?>
		</div>
<!--		<div class="hint">Prosze przepisać litery z obrazka poniżej.-->
<!--		<br/>Wielkość liter nie ma znaczenia</div>-->
		<?php echo $form->error($modelContact,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit', array('class'=>'button1')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>