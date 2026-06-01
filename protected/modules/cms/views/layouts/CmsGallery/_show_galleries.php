<?php
/* Dane startowe */
$listaGalerii = $this->pageDisplayer->galleryList;
/* --- */

echo '<h4>Lista galerii:</h4>';

    $directory = InputTypes::model()->getInputTypes('CmsGallery');    
    
foreach($listaGalerii as $item){
    $directory_m = $directory['image']['folder_name'].$item->id.'/m';
       
        echo '<div class="gallery_pic" style="padding:5px; max-width:165px; float:left; text-align:center;">';        
            echo '<a href="index.php?r=cms/cmsPage/showDetailsGallery&url='.$_GET['url'].'&gid='.$item->id.'">'.$item->title.'</a>';        
        echo '<a href="index.php?r=cms/cmsPage/showDetailsGallery&url='.$_GET['url'].'&gid='.$item->id.'"><img alt="" src="'.$directory_m.'/'.$item->image.'" /></a>';
    echo '</div>';

}
?>
