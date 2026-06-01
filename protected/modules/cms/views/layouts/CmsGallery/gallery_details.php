<?php
/* Layout strony - all_galleries
 */

$this->beginContent('//layouts/main'); // dla mainApp
        
/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */
if(isset($_GET['gid']) && $_GET['gid'] != ''){
    // klik z listy galerii 
    $detailsGallery = CmsGallery::model()->find('id=?',array($_GET['gid'])); // konkretna galeria
    $tytulGalerii = $detailsGallery->title;
    $trescGalerii = $detailsGallery->text;        
}else{
    $tytulGalerii = $page->pageElement->gallery->title;
    $trescGalerii = $page->pageElement->gallery->text;
}
/* Wyjatek: */
$layoutGalleryDetails = CmsLayouts::model()->find('id=?',array(36)); // 36 gallery_details   
/* --- */

echo '<div class="galleryContentPage" style="padding:5px; width:75%; text-align:justify; padding:5px;">';

    echo '<h4>'.$tytulGalerii.'</h4>';
    echo '<div style="width:100%; height:auto;; float:left; padding:5px;">'.$trescGalerii.'</div>';
    
        $this->renderPartial('cms.views.layouts.CmsGallery._'.$layoutGalleryDetails->col_center);

echo '</div>';

$this->endContent();
?>
