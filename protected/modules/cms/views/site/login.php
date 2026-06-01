<?php
/* !! dlatego ze nie ma podanych w mainFront.php styli teraz je dodaje - QBIX !! */
Yii::app()->getClientScript()->registerCssFile($this->module->assetsUrl.'/css/login.css');

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>



<div class="content">						

<?php
    echo '<div class="bckLogin">';
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'LoginForm',
	'enableAjaxValidation'=>false,
)); ?>
<?php    
    //<h3 style="margin-bottom: 10px;">'.$dict_info_text.'</h3>
?>
    <div class="qbixLogo"><img src="<?php echo $this->module->assetsUrl; ?>/images/qbix.png" /></div>

<div class="admPnlLogRam">


<?php
    echo $form->errorSummary($model);
?>

<div class="loginRow">
		<?php echo $form->labelEx($model,'login'); ?>
           
		<?php echo $form->textField($model,'login'); ?>
		<?php //echo $form->error($model,'login'); ?>
</div>

<div class="loginRow">
		<?php echo $form->labelEx($model,Yii::t(Yii::app()->language.'_YiiTranslation', 'Password')); ?>
           
		<?php echo $form->passwordField($model,'password'); ?>
		<?php //echo $form->error($model,'password'); ?>
</div>
            <br />
<div class="loginRow">
		<?php echo CHtml::submitButton(Yii::t(Yii::app()->language.'_YiiTranslation', 'Login'), array('class'=>'admFrmInpSub')); ?>
</div>


<?php $this->endWidget(); ?>           
</div>
<?php
     $urlHome = CmsPage::model()->getElement('id', 4, 'CmsPage', 'url');
     echo '<a style="margin-left:15px;" href="index.php?r=cms/cmsPage/displayPage&url='.$urlHome.'">'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Back to front page').'</a>';     
?>
</div>

<p class="note"><?php //echo Yii::t(Yii::app()->language.'_YiiTranslation', 'If you are not our client yet, please'); echo ' '; echo CHtml::link(Yii::t(Yii::app()->language.'_YiiTranslation', 'Register'), Yii::app()->createUrl("/site/chooseRegisterUser"), array('style'=>'color:#FF9933;') ); ?></p>
<?php
echo '</div>';
?>
</div>

