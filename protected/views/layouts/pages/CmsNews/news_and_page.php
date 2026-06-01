<?php
/* Layout strony - news and page
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */

$this->beginContent('//layouts/main'); // dla mainApp
echo '<div id="appStore">';
                    echo Uzytkownik::model()->getVideo();
                    echo '<a class="store" href="#"></a>';
                echo '</div>';

//
//echo '<div id="colLeft"><div id="aside_tresc">';
//    $this->renderPartial('//layouts/CmsNews/_'.$page->cmsLayouts->col_left);
//echo '</div></div>';
//    
//echo '<div id="colRight"><div id="index_content">';    
//    echo '<h3>'.$page->header.'</h3>';
//    echo $page->txt;    
//echo '</div></div>';

$this->endContent();


?>