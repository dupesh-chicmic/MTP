<?php
?>
<ul data-role="listview">
    <a href="<?php echo Yii::app()->createUrl('mobile/showNewPricesComm'); ?>" data-role="button" data-theme="b" data-corners="false">Switch to Commercial &amp; 4WD</a>
</ul>

<ul data-role="listview" data-inset="false" data-theme="b">
<?php


foreach ($xmlManFileData as $distributor => $file) : ?>
    <li><a href="<?php echo Yii::app()->createUrl('mobile/showNewPricesCarsRanges',array('car'=>$file, 'manufacturer'=>Mobile::getCleanManufacturer($distributor)));?>">
            <h2 style="color:#fff; text-align: center;"><?php echo $distributor; ?></h2>
        </a>
    </li>
<?php endforeach; ?>
</ul>
