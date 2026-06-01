<?php
/*
 * Widok wyboru NEW PRICES : cars / commercial
 */
?>

<ul id="nav">
    <a href="<?php echo Yii::app()->createUrl('mobile/showNewPricesCars'); ?>" data-role="button" data-theme="b" data-corners="false">Cars</a>
    <a href="<?php echo Yii::app()->createUrl('mobile/showNewPricesComm'); ?>" data-role="button" data-theme="b" data-corners="false">Commercials & 4WDs</a>
</ul>
