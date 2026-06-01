<?php
$this->widget('cms.extensions.elrte.elRTE', array(
    'selector'=>'element',    
    'doctype' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">',
    'cssClass' => 'el-rte',
    'absoluteURLs' => 'false',
    'allowSource' => 'true', //pokaz zrodlo
    'lang' => 'en',
    'styleWithCSS' => 'true',
    'height' => '250',
    'width' => '500px',
    'fmAllow' => 'true',
    'toolbar' => 'tiny',
 ));
?>

<div id="mainContent">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'formField',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><span class="requiredText"><?php echo Yii::t(Yii::app()->language.'_YiiTranslation', 'Fields with * are required'); ?></span></p>

	<?php echo $form->errorSummary($model); ?>


	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'txt'); ?></div>
                <div class="edit">
		<?php echo $form->textArea($model,'txt',array('rows'=>6, 'cols'=>50, 'id'=>'element','class'=>'tinyForm')); ?>
                </div>
		<?php echo $form->error($model,'txt'); ?>
	</div>
        
<?php
    if(Yii::app()->user->isSu() == false){ //jest tylko adminem
?>
        
        <div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'key'); ?></div>
		<?php $style='style="color:#CC3333; background:#DDDDDD;"';
                      echo $form->textField($model,'key',array('size'=>60,'maxlength'=>500, 'readonly'=>"readonly", $style=>'','class'=>'inputField iputBackground'));
                echo $form->error($model,'key'); ?>
	</div>

<?php }// end if
    else{ //jestem SU
?>
        <div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'key'); ?></div>
		<?php echo $form->textField($model,'key',array('size'=>60,'maxlength'=>500,'class'=>'inputField iputBackground')); ?>
		<?php echo $form->error($model,'key'); ?>
	</div>

	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'client_editable'); ?>	</div>	
                <?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`txt`';
                    echo $form->dropDownList($model,'client_editable',array(1=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Yes'),0=>Yii::t(Yii::app()->language.'_YiiTranslation', 'No')), array('class'=>'inputField','style'=>'padding-top:10px;'));
                echo $form->error($model,'client_editable'); ?>
	</div>

	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'value'); ?></div>
		<?php echo $form->textField($model,'value',array('size'=>60,'maxlength'=>500,'class'=>'inputField iputBackground')); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>

	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'group'); ?></div>
		<?php echo $form->textField($model,'group',array('size'=>60,'maxlength'=>500,'class'=>'inputField iputBackground')); ?>
		<?php echo $form->error($model,'group'); ?>
	</div>

	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'actions'); ?></div>
		<?php echo $form->textField($model,'actions',array('size'=>60,'maxlength'=>500,'class'=>'inputField iputBackground')); ?>
		<?php echo $form->error($model,'actions'); ?>
	</div>
<?php } // end else ?>
	<div class="button">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t(Yii::app()->language.'_YiiTranslation', 'Create') : Yii::t(Yii::app()->language.'_YiiTranslation', 'Update'), array('class'=>'buttonClearForm', 'style'=>'padding-top:0px;')); ?>
	</div>

        
<?php $this->endWidget(); ?>

</div><!-- form -->