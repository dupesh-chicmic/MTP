
<div class="form">
<?php $action=''; ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'klient-klient-form',
	'enableAjaxValidation'=>false,
));
?>

    <div class="admPnlLogRam">

	<p class="note">Pola oznaczone <span class="required">*</span> są wymagane.</p>

	<?php
        
        ?>
        <?php
        if(Yii::app()->params['admin_lang'][1] =='pl'){
            echo $form->errorSummary(array($model->uzytkownik, $model->klient, $model->adres, $model->firma),'Proszę poprawić poniższe błędy ');
        }else{
           echo $form->errorSummary(array($model->uzytkownik, $model->klient, $model->adres, $model->firma)); //eng
        }
        ?>

        <div class="registerField">
            <?php
                    
                    echo '<div>Klient indywidualny';
                    echo CHtml::radioButton('isCompany',true, $htmlOptions=array('value'=>'1', 'onClick'=>'document.getElementById(\'ukryty\').style.display=\'none\';'));
                    echo '</div>';
                    //echo '<p>';                   
//                    echo '<div>Artysta';
//                    echo CHtml::radioButton('isCompany',false, $htmlOptions=array('onClick'=>'document.getElementById(\'ukryty\').style.display=\'block\';'));
//                    echo '</div>';
//
//                    echo CHtml::radioButtonList('isCompany',
//                                              $model->isCompany,
//                                              array('Klient indywidualny', 'Firma', 'Artysta'),
//                                              array('template'=>'{label}{input}', 'style'=>'onclick="view(this)"'));
            ?>
        </div>

	<div class="registerField">
		<?php echo $form->labelEx($model->uzytkownik,'login'); ?>
		<?php echo $form->textField($model->uzytkownik,'login'); ?>
		<?php echo $form->error($model->uzytkownik,'login'); ?>
	</div>

       	<div class="registerField">
		<?php echo $form->labelEx($model->uzytkownik,'haslo'); ?>
		<?php echo $form->passwordField($model->uzytkownik,'haslo'); ?>
		<?php echo $form->error($model->uzytkownik,'haslo'); ?>
	</div>

	<div class="registerField">
		<?php echo $form->labelEx($model->uzytkownik,'imie'); ?>
		<?php echo $form->textField($model->uzytkownik,'imie'); ?>
		<?php echo $form->error($model->uzytkownik,'imie'); ?>
	</div>

	<div class="registerField">
		<?php echo $form->labelEx($model->uzytkownik,'nazwisko'); ?>
		<?php echo $form->textField($model->uzytkownik,'nazwisko'); ?>
		<?php echo $form->error($model->uzytkownik,'nazwisko'); ?>
	</div>

        <div class="registerField">
		<?php echo $form->labelEx($model->klient,'tel'); ?>
		<?php echo $form->textField($model->klient,'tel'); ?>
		<?php echo $form->error($model->klient,'tel'); ?>
	</div>

	<div class="registerField">
		<?php echo $form->labelEx($model->klient,'tel_kom'); ?>
		<?php echo $form->textField($model->klient,'tel_kom'); ?>
		<?php echo $form->error($model->klient,'tel_kom'); ?>
	</div>

        <?php echo $this->renderPartial('/adres/_form', array('model'=>$model->adres, 'form'=>$form, 'hideFields'=>array('nazwa'=>true))); ?>
<!--
        <div class="registerField">
		<?php echo $form->labelEx($model->firma,'nazwa_pelna'); ?>
		<?php echo $form->textField($model->firma,'nazwa_pelna'); ?>
		<?php echo $form->error($model->firma,'nazwa_pelna'); ?>
	</div>
-->
        <div class="registerField">
		<?php //echo $form->labelEx($model->firma,'nazwa_skrocona'); ?>
		<?php //echo $form->textField($model->firma,'nazwa_skrocona'); ?>
		<?php //echo $form->error($model->firma,'nazwa_skrocona'); ?>
	</div>
<!--
	<div class="registerField">
		<?php //echo $form->labelEx($model->firma,'nip'); ?>
		<?php echo $form->textField($model->firma,'nip',array('size'=>10,'maxlength'=>10)); ?>
                (Prosimy podać bez "-").
		<?php echo $form->error($model->firma,'nip'); ?>
	</div>

        <div class="registerField">
		<?php echo $form->labelEx($model->firma,'regon'); ?>
		<?php echo $form->textField($model->firma,'regon'); ?>
		<?php echo $form->error($model->firma,'regon'); ?>
	</div>

        <div class="registerField">
		<?php echo $form->labelEx($model->firma,'telefon'); ?>
		<?php echo $form->textField($model->firma,'telefon'); ?>
		<?php echo $form->error($model->firma,'telefon'); ?>
	</div>

	<div class="registerField">
		<?php echo $form->labelEx($model->firma,'fax'); ?>
		<?php echo $form->textField($model->firma,'fax'); ?>
		<?php echo $form->error($model->firma,'fax'); ?>
	</div>
-->
	<div class="loginRow">
		<?php echo CHtml::submitButton('Zatwierdź', array('class'=>'admFrmInpSub')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>


</div><!-- form -->

</div>
<?php
echo '</div>';
?>
