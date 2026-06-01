<?php
/* Layout strony - 2 kolumny
 * po lewej txt, po prawej menu
<div class="colLeft">TXT</div> <div class="colRight">MENU</div>
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */

$this->beginContent('//layouts/main'); // dla mainApp

 echo'  <div id="appStore">';
                    echo Uzytkownik::model()->getVideo();
                    echo '<a class="store" href="#"></a>';                    
                echo '</div>';
//echo '<div class="colLeft" style="float:left; width:75%; text-align:justify; padding:5px;">';
//echo '<h4>SZABLON strony z menu</h4>';
    echo '<h3>'.$page->header.'</h3>';
    echo $page->txt;
    
//echo '</div>';
    
//echo '<p>';
//
//
//echo '<div class="colRight" style="float:left; width:20%;">';
//    echo 'Sub menu<hr>';
//    $this->renderPartial('cms.views.layouts.CmsPage._'.$page->cmsLayouts->col_right);
//echo '</div>';

$this->endContent();
?>
