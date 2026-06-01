<?php
$this->breadcrumbs=array(
	//$universal_model->menu_top_label_pl,
);




/* Content strony universal Element View jest tworzony na zewnatrz (*.php) */

    $filename = "./protected/views/ViewUniversalElement/".$view_model.".php";

    if(file_exists($filename)){

    //echo '<div class="universalContent">';    
    require './protected/views/ViewUniversalElement/'.$view_model.'.php'; //tresc

    //echo '</div> <!-- end universalContent -->';
    //end content
    }else{
        echo 'Widok nie został znaleziony w systemie'; return;
    }
    
/* */

?>
