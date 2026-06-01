<?php
echo '<div style="text-align:center;">';
echo '<br />';
echo '<h2>Archives</h2>';

// used cars
$i=0;

echo '<table style="margin:0 auto; width:100%; border:1px solid #BBBBBB;">';
echo '<thead><tr><th style="text-align:center; background-color:#BBBBBB;">Cars</th><th style="text-align:center; background-color:#BBBBBB;">Commercial</th></tr></thead>';
echo '<tbody>';
$all = count($modelImport);

$carsVisibleLink = Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_CARS);
$commVisibleLink = Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_COMMERCIAL);
        
foreach($modelImport as $item){
    $i++;
    if($i==1 && $all>1){ continue; }
    if($i%2){
        $backgroundColor = 'background-color: #F4F4F4;';        
    }else{
        $backgroundColor = '';
    }
    echo '<tr style="'.$backgroundColor.' border-bottom:1px dashed #CCCCCC">';
    
        echo '<td style="padding-right:50px; text-align:center;">';
            echo '<span style="color:#2D8296; font-weight:bolder;"><span class="actionLink_text"><a href="'.(($carsVisibleLink) ? Yii::app()->createUrl('registrationService/usedCarsArchiveRegLookup',array('arch'=>$item->id)) : '#').'">'.$item->data.' <text style="'.(($carsVisibleLink) ? 'color:#2D8296;' : 'color:#CCC;').'">Used Cars '.$item->nazwa.'</text></span></a></span></span>';
        echo '</td>';
    //echo '<br />';
    if(!empty($item->usedComCarsCount)){
        echo '<td style="padding-left:50px; text-align:center;">';
            echo '<span style="color:#2D8296; font-weight:bolder;"><span class="actionLink_text"><a href="'.(($commVisibleLink) ? Yii::app()->createUrl('registrationService/usedComCarsArchiveRegLookup',array('arch'=>$item->id)) : '#').'">'.$item->data.' <text style="'.(($commVisibleLink) ? 'color:#2D8296;' : 'color:#CCC;').'">Used Commercial '.$item->nazwa.'</text></span></a></span></span>';
        echo '</td>';
    }
    
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';

echo '</div>';
?>