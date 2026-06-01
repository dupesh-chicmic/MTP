<?php
/*
 * Widok new prices mobile
 */
?>
<ul data-role="listview">
    <a href="<?php echo Yii::app()->createUrl('mobile/chooseNewPrices'); ?>" data-role="button" data-theme="b" data-corners="false">Choose New Prices</a>
</ul>

<ul data-role="listview" data-inset="false" data-theme="b">
<?php
$range_array = UsedCars::newCarsRanges('./data/cars/nCarsRanges.xml');  
$manufacturerKey = str_replace(' ', '_', $manufacturer);
foreach ($range_array[$manufacturerKey] as $key=>$value) : ?>
    <li><a href="<?php echo Yii::app()->createUrl('mobile/carModels',array('car'=>$car, 'rangecode'=>$value));?>">
            <h2 style="color:#fff; text-align: center;"><?php echo $manufacturer.' - '.$key; ?></h2>
        </a>
    </li>
<?php endforeach; ?>
</ul>
