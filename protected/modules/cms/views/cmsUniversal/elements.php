<?php
$this->breadcrumbs=array(
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Managed elements'),
);

?>

<?php echo '<h2>'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Elements').'</h2>'; ?>


<?php
echo '<table class="universal_elementTable">';
    $i=1;
    foreach ($model as $item){
        if(Yii::app()->language == 'pl'){
            $elementLabel = $item->menu_top_label_pl;
        }else{
            $elementLabel = $item->menu_top_label_en;
        }

        if($item->admin_display == 1){
            echo  '<tr onMouseover="this.bgColor=\'#DDDDDD\'"onMouseout="this.bgColor=\'#F8F8F8\'"><td><div class="universal_element"><strong>'.$i.'</strong> <a href="index.php?r=cms/cmsUniversal/modelElement&&e='.$item->table_name.'&&id=0">'.$elementLabel.'</a>';
            echo '</td></tr></div>';
            $i++;
        }else
            if(Yii::app()->user->isSu() == true){
                echo '<tr onMouseover="this.bgColor=\'#DDDDDD\'"onMouseout="this.bgColor=\'#F8F8F8\'"><td><div class="universal_element"><strong>'.$i.'</strong> <a href="index.php?r=cms/cmsUniversal/modelElement&&e='.$item->table_name.'&&id=0">'.$elementLabel.' (SU)</a>';
                echo '</td></tr></div>';
                $i++;
            }
    }
echo '</table>';    
?>
