<?php
/* Layout strony - mapy
 */

$this->beginContent('//layouts/main'); // dla mainApp
        
/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */
echo '<div class="mapContentPage" style="padding:5px;">';

    $this->renderPartial('cms.views.layouts.CmsMap._'.$page->cmsLayouts->col_center);
    
echo '</div>';

$this->endContent();
?>
