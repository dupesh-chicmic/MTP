<?php
/*
 * Widok wyboru cars albo commercial
 */
?>
<?php if(Yii::app()->user->hasFlash('mobileError')): ?>
    <div class="flash-error"><?php echo Yii::app()->user->getFlash('mobileError'); ?></div>
<?php else: ?>

        <ul id="nav">
            <?php if(Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_CARS) && $userModel->used_cars == 1): ?>
                <a href="<?php echo Yii::app()->createUrl('mobile/selectCars'); ?>" data-role="button" data-theme="b" data-corners="false">Cars</a>
            <?php endif; ?>
            <?php if(Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL) && $userModel->used_com_cars == 1): ?>
                <a href="<?php echo Yii::app()->createUrl('mobile/selectCommercials'); ?>" data-role="button" data-theme="b" data-corners="false">Commercials & 4WDs</a>
            <?php endif; ?>
        </ul>

<?php endif; ?>
