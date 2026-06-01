<?php
/* 
    Wybieramy czy osoba rejstrowana bedzie klientem / pracownikiem*
 */
?>
<div class="form">
<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pracownik-form',
	'enableAjaxValidation'=>false,
));

?>
<div class="admPnlLogRam">
	<p class="note">Wybierz typ użytkownika</p>

    <div class="loginRow">
                    <?php echo CHtml::submitButton('Klient', array('class'=>'admFrmInpSub','name'=>'klient')); ?>
                    <?php echo CHtml::submitButton('Artysta', array('class'=>'admFrmInpSub','name'=>'artysta')); ?>
    </div>
</div>

</div>

<?php $this->endWidget(); ?>
