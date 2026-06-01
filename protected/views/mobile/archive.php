<?php 
echo '<div style="text-align:center;">';
/*echo '<br />';*/
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
        if(!empty($item->usedComCarsCount)){
            echo '<td style="text-align:center;">';
                echo '<span style="color:#ffd800; font-weight:bolder;"><span class="actionLink_text"><a href="'.(($carsVisibleLink) ? Yii::app()->createUrl('mobile/usedPassengerComercialArchive',array('arch'=>$item->id,'com_arch'=>$item->id, 'page'=>'cars')) : '#').'">'.date_format( date_create($item->data),"Y-m").' <text style="'.(($carsVisibleLink) ? 'color:#ffd800;' : 'color:#CCC;').'">Used Cars '.$item->nazwa.'</text></span></a></span></span>';
            echo '</td>';
            echo '<td style="text-align:center;">';
                echo '<span style="color:#ffd800; font-weight:bolder;"><span class="actionLink_text"><a href="'.(($commVisibleLink) ? Yii::app()->createUrl('mobile/usedPassengerComercialArchive',array('arch'=>$item->id,'com_arch'=>$item->id, 'page'=>'commercial')) : '#').'">'.date_format( date_create($item->data),"Y-m").' <text style="'.(($commVisibleLink) ? 'color:#ffd800;' : 'color:#CCC;').'">Used Commercial '.$item->nazwa.'</text></span></a></span></span>';
            echo '</td>';
        } else { 
            echo '<td style="text-align:center;">';
                echo '<span style="color:#ffd800; font-weight:bolder;"><span class="actionLink_text"><a href="'.(($carsVisibleLink) ? Yii::app()->createUrl('mobile/usedPassengerComercialArchive',array('arch'=>$item->id,'com_arch'=>$carComIds[ $item->nazwa ], 'page'=>'cars')) : '#').'">'.date_format( date_create($item->data),"Y-m").' <text style="'.(($carsVisibleLink) ? 'color:#ffd800;' : 'color:#CCC;').'">Used Cars '.$item->nazwa.'</text></span></a></span></span>';
            echo '</td>';
        }
        
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';

echo '</div>';
echo '</div>';
?>