<?php
/*
 * Menu glowne aplikacji
 */
?>

<ul id="nav">
    <a href="<?php echo Yii::app()->createUrl('mobile/logoutwp'); ?>" data-ajax="false" data-role="button" data-theme="b" data-corners="false">Logout</a>
    <?php
        if(!Yii::app()->user->isGuest){
            echo '<a href='.Yii::app()->createUrl('mobile/chooseType').' data-role="button" data-theme="b" data-corners="false">Used Values</a>';
            echo '<a href='.Yii::app()->createUrl('mobile/chooseNewPrices').' data-role="button" data-theme="b" data-corners="false">New Prices</a>';                
        }
    ?>
</ul>
