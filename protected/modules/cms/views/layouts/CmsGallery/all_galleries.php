<?php
/* Layout strony - all_galleries
 */

$this->beginContent('//layouts/main'); // dla mainApp
        
/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */
echo '<div class="galleryContentPage" style="padding:5px;">';

    $this->renderPartial('cms.views.layouts.CmsGallery._'.$page->cmsLayouts->col_center);
    
echo '</div>';

$this->endContent();
?>
