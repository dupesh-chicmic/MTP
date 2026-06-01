<?php
echo '<div style="text-align:center;">';
echo '<br />';
echo '<h2>Archives</h2>';

echo '<div class="table-responsive">';
// used cars
$i=0;

echo '<table style="margin:0 auto; width:100%;">';
echo '<thead><tr><th style="text-align:center;">Cars</th><th style="text-align:center;">Commercial</th></tr></thead>';
echo '<tbody>';
$all = count($modelImport);

$carsVisibleLink = Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_CARS);
$commVisibleLink = Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_COMMERCIAL);
        
foreach($modelImport as $item){
    $i++;
    if($i==1 && $all>1){ continue; }
    if($i%2){
        $backgroundColor = 'background-color: #252525;';        
    }else{
        $backgroundColor = '';
    }
    echo '<tr style="'.$backgroundColor.' border-bottom:1px dashed #252525">';
    
        echo '<td style="padding-right:50px; text-align:center;">';
            echo '<span style="color:#f7d702; font-weight:bolder;"><span class="actionLink_text"><a href="'.(($carsVisibleLink) ? Yii::app()->createUrl('mobile/usedCarsArchiveRegLookup',array('arch'=>$item->id)) : '#').'">'.date_format( date_create($item->data),"Y-m").' <text style="'.(($carsVisibleLink) ? 'color:#f7d702;' : 'color:#CCC;').'">Used Cars '.$item->nazwa.'</text></span></a></span></span>';
        echo '</td>';
    //echo '<br />';
    if(!empty($item->usedComCarsCount)){
        echo '<td style="padding-left:50px; text-align:center;">';
            echo '<span style="color:#f7d702; font-weight:bolder;"><span class="actionLink_text"><a href="'.(($commVisibleLink) ? Yii::app()->createUrl('mobile/usedComCarsArchiveRegLookup',array('arch'=>$item->id)) : '#').'">'.date_format( date_create($item->data),"Y-m").' <text style="'.(($commVisibleLink) ? 'color:#f7d702;' : 'color:#CCC;').'">Used Commercial '.$item->nazwa.'</text></span></a></span></span>';
        echo '</td>';
    }
    
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';

echo '</div>';
echo '</div>';
?>