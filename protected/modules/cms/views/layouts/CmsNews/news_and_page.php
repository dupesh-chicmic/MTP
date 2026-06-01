<?php
/* Layout strony - news and page
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */

$this->beginContent('//layouts/main'); // dla mainApp


echo '<div class="colLeft" style="float:left; width:20%; text-align:justify; padding:5px;">';
    $this->renderPartial('cms.views.layouts.CmsNews._'.$page->cmsLayouts->col_left);
echo '</div>';
    
echo '<p>';


echo '<div class="colRight" style="float:left; width:75%;">';    
    echo '<h3>'.$page->header.'</h3>';
    echo $page->txt;    
echo '</div>';

$this->endContent();


?>