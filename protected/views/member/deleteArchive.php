<br />
<a href="index.php?r=member/importXmlFilesMain">Back to import files</a>
<hr>
<div style="text-align:center;">
<br />
<h3>Archives</h3>


<?php
// used cars
$i=0;

echo '<table style="margin:0 auto;">';
echo '<thead><tr><th>Action</th><th>Cars</th><th>Commercial</th></tr></thead>';
echo '<tbody>';
$all = count($modelImport);
foreach($modelImport as $item){    
    $i++;
    if($i==1 && $all>1){ continue; }
    echo '<tr>';
    
        echo '<td style="padding-right:50px;">';
           echo '<a href="'.Yii::app()->createUrl('member/deleteImport', array('id' => $item->id)).'"><img src="./images/delete.png" /></a>';
        echo '</td>';
        
        echo '<td style="padding-right:50px;">';
            echo '<span style="color:#2D8296; font-weight:bolder;"><span class="actionLink_text"><a href="'.Yii::app()->createUrl('member/usedCarsArchive',array('arch'=>$item->id)).'">'.$item->data.' <text style="color:#2D8296;">Used Cars '.$item->nazwa.'</text></span></a></span></span>';

        echo '</td>';

    if(!empty($item->usedComCarsCount)){
        echo '<td style="padding-left:50px;">';
            echo '<span style="color:#2D8296; font-weight:bolder;"><span class="actionLink_text"><a href="'.Yii::app()->createUrl('member/usedComCarsArchive',array('arch'=>$item->id)).'">'.$item->data.' <text style="color:#2D8296;">Used Commercial '.$item->nazwa.'</text></span></a></span></span>';
        echo '</td>';
    }
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
?>
</div>