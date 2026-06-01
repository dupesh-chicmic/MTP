<?php
/* Layout strony - page and galleries (3)
 */

$this->beginContent('//layouts/main'); // dla mainApp
        
/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */
echo '<div class="colLeft" style="float:left; width:75%; text-align:justify; padding:5px;">';
    echo '<h3>'.$page->header.'</h3>';
    echo $page->txt;
echo '</div>';
    
echo '<p>';


echo '<div class="colRight" style="float:left; width:20%;">';    
    $this->renderPartial('cms.views.layouts.CmsGallery._'.$page->cmsLayouts->col_right);
echo '</div>';

$this->endContent();
?>
