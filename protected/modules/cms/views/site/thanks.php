<?php $this->pageTitle=Yii::app()->name; ?>

<h4>Gratulacje! Twoje konto zostało pomyślnie utworzone.</h4>

<p style="color: #858585; padding-top: 15px;">Możesz teraz zalogować się do systemu

    <div style="font-weight: bold; font-size: 13px; color: #5A5A5A;">
        <?php echo CHtml::link(CHtml::encode("tutaj"),array('site/login'));?>
    </div>
</p>
