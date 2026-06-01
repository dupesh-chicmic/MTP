<?php
// FRONT dla kazdego usera 

echo '<div id="width" style="padding-top:30px;">';

if(empty($model->imie)){
    $name = Yii::app()->user->getName();
}else{
    $name = $model->imie;
}
    echo '<h1>Welcome <span style="color:#62737B;">'.$name.'</span> </h1>';?>


    <div id="leftSideAccount">
        <?php echo CmsDictionary::model()->dictionaryGetText('userAccount_text'); ?>
        
        <?php
//        echo $this->renderPartial('//registrationService/_checkPlateNumber', 
//                array('model'=>$model,
//                    'usedCarComModel'=>'UsedCarsModel',
//                    'importId'=>1
//                )); 
        ?>
    </div>


    <div id="rightSideAccount">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>'index.php?r=uzytkownik/changeUserDataForm&id='.$model->id,
	'id'=>'uzytkownik-change-form',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
            'validateOnChange'=>true,
            'validateOnSubmit'=>true, // aby nie wyslal pustego !
	),
)); 


    if(Yii::app()->user->hasFlash('accountError')){
        echo '<div class="flash-error">';
        echo Yii::app()->user->getFlash('accountError');
        echo '</div>';
    }
    if(Yii::app()->user->hasFlash('accountSuccess')){
        echo '<div class="flash-success">';
        echo Yii::app()->user->getFlash('accountSuccess');
        echo '</div>';
    }    
?>
        
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login', array('class'=>'input1')); ?>
		<?php //echo $form->error($model,'login'); ?>
	</div>	
        <div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email', array('class'=>'input1')); ?>
		<?php //echo $form->error($model,'login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'imie'); ?>
		<?php echo $form->textField($model,'imie', array('class'=>'input1')); ?>
		<?php //echo $form->error($model,'imie'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nazwisko'); ?>
		<?php echo $form->textField($model,'nazwisko', array('class'=>'input1')); ?>
		<?php //echo $form->error($model,'nazwisko'); ?>
	</div>

       
        <?php
            echo '<div class="flash-notice">';
                echo 'If you leave "<b>old password</b> and <b>new password</b>" fields blank password will not be changed.';
                echo '</div>';
        ?>
	<div class="row">
                <?php echo CHtml::label('Old password','Uzytkownik_old_password'); ?>
		<?php echo CHtml::passwordField('Uzytkownik_old_password', '',array('class'=>'input1')); ?>
	</div>    
    
        <div class="row">
		<?php //echo $form->labelEx($model,'haslo');    
                 echo CHtml::label('New password','haslo');
		 echo $form->passwordField($model,'haslo',array('class'=>'input1','value'=>'')); ?>
		<?php //echo $form->error($model,'haslo'); ?>
	</div>

	<div class="row">
                <?php echo CHtml::label('Confirm new password','confirm_new_password'); ?>
		<?php echo CHtml::passwordField('confirm_new_password', '',array('class'=>'input1')); ?>
	</div>        
    
    
	<div class="row buttons">
		<?php echo CHtml::submitButton('Change',array('class'=>'button1')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
        
        
        <div id="passDiv"></div>
    </div>

<?php echo '</div>';

?>
