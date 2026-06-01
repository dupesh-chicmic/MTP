<?php
echo '<div class="servicesTable">';
echo '<h4>NEW RATES (Passengers Vehicles)</h4>';
$this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>new CArrayDataProvider(array(
            array('id'=>0,'co2'=>'A', 'g'=>'0-120g', 'vrt'=>'14%', 'road'=>'100 euro'),
             array('id'=>0,'co2'=>'B', 'g'=>'121-140g', 'vrt'=>'16%', 'road'=>'150 euro'),
             array('id'=>0,'co2'=>'C', 'g'=>'141-155g', 'vrt'=>'20%', 'road'=>'290 euro'),
             array('id'=>0,'co2'=>'C', 'g'=>'156-170g', 'vrt'=>'20%', 'road'=>'290 euro'),
             array('id'=>0,'co2'=>'D', 'g'=>'171-190g', 'vrt'=>'24%', 'road'=>'430 euro'),
             array('id'=>0,'co2'=>'E', 'g'=>'191-225g', 'vrt'=>'28%', 'road'=>'600 euro'),
             array('id'=>0,'co2'=>'F', 'g'=>'226 and over', 'vrt'=>'32%', 'road'=>'1000 euro'),
                       
        )),
        'summaryText'=>'',
        'cssFile'=> Yii::app()->request->baseUrl.'/css/grid.css',
	'columns'=>array(
            array(
            'name'=>'co2',
            'header'=>'CO2 Emissions Bands',
            'htmlOptions'=>array('class'=>'fontColor')
             ),
             array(
            'name'=>'g',
            'header'=>'gCO2/km'
    ),
             array(
            'name'=>'vrt',
            'header'=>'VRT Rates'
    ),
             array(
            'name'=>'road',
            'header'=>'Road Tax Rates'
    ),
        ),
   
   
        'nullDisplay'=>'<i>nie dotyczy</i>'
));
echo '</div>'
?>
