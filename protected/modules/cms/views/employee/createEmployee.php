<?php
/*
$this->breadcrumbs=array(
        'Panel zarządzania'=>array('/'),
	'Pracownicy'=>array('indexEmployee'),
	'Dodawanie nowego pracownika',
);

$menu_admin=array();
if(Yii::app()->user->isAdmin)
{
    $menu_admin=array(array('label'=>'Dodaj pracownika', 'url'=>array('createEmployee')),
	array('label'=>'Wyszukaj pracownika', 'url'=>array('adminEmployee')));
}

$this->menu=array_merge($menu_admin, array(
        array('label'=>'Dodaj klienta', 'url'=>array('createCustomer')),
	array('label'=>'Wyszukaj klienta', 'url'=>array('adminCustomer')),

));
?>

<h1>Dodaj konto pracownika</h1>

<?php echo $this->renderPartial('_formEmployee', array('model'=>$model));

*/
?>

<?php
    $this->beginContent('//layouts/main');
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pracownik-form',
	'enableAjaxValidation'=>false,
)); ?>

    <div class="admPnlLogRam">
        
	<p class="note">Pola z <span class="required">*</span> są wymagane.</p>

         <?php
        if(Yii::app()->params['admin_lang'][1] =='pl'){
            echo $form->errorSummary(array($model->pracownik, $model->uzytkownik),'Proszę poprawić poniższe błędy ');
        }else{
           echo $form->errorSummary(array($model->pracownik, $model->uzytkownik));
        }
        ?>

        <div class="registerField">
            <?php
                        echo '<div>Artysta';
                        echo CHtml::radioButton('isCompany',true, $htmlOptions=array('value'=>'2', 'onClick'=>'document.getElementById(\'ukryty\').style.display=\'none\';'));
                        echo '</div>';
            ?>
        </div>

	<div class="registerField">
		<?php echo $form->labelEx($model->uzytkownik,'login'); ?>
		<?php echo $form->textField($model->uzytkownik,'login',array('size'=>40,'maxlength'=>100)); ?>
		<?php echo $form->error($model->uzytkownik,'login'); ?>
	</div>

       	<div class="registerField">
		<?php echo $form->labelEx($model->uzytkownik,'haslo'); ?>
		<?php echo $form->passwordField($model->uzytkownik,'haslo',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model->uzytkownik,'haslo'); ?>
	</div>

	<div class="registerField">
		<?php echo $form->labelEx($model->uzytkownik,'imie'); ?>
		<?php echo $form->textField($model->uzytkownik,'imie',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model->uzytkownik,'imie'); ?>
	</div>

	<div class="registerField">
		<?php echo $form->labelEx($model->uzytkownik,'nazwisko'); ?>
		<?php echo $form->textField($model->uzytkownik,'nazwisko',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model->uzytkownik,'nazwisko'); ?>
	</div>

       	<div class="registerField">
		<?php echo $form->labelEx($model->pracownik,'data_urodzenia'); ?>
		<?php echo $form->textField($model->pracownik,'data_urodzenia',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model->pracownik,'data_urodzenia'); ?>
	</div>
<!--
        <div class="registerField">
		<?php //echo $form->labelEx($model->pracownik,'data_zatrudnienia'); ?>
		<?php //echo $form->textField($model->pracownik,'data_zatrudnienia',array('size'=>50,'maxlength'=>50)); ?>
		<?php //echo $form->error($model->pracownik,'data_zatrudnienia'); ?>
	</div>
-->
	<div class="loginRow">
		<?php echo CHtml::submitButton('Zatwierdź', array('class'=>'admFrmInpSub')); ?>
	</div>


    </div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
    $this->endContent();
?>