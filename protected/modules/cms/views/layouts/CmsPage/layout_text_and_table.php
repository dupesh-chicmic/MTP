<?php
/* Layout strony - 2 page txt
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */

//$this->beginContent('//layouts/mainSubPage'); // dla mainApp
$this->beginContent('//layouts/iframeFoundation'); // dla mainApp


//echo '<div class="colCenter" style="float:left; width:98%; text-align:justify; padding:5px;">';
// echo'<div id="appStore" style=" top: -80px">';
//                    echo Uzytkownik::model()->getVideo();
//                    echo '<a class="store" href="#"></a>';
//                echo '</div>';  
 echo '    <div id="left">';
               echo'     <h1>'.$page->header.'</h1>';
              
  echo $page->txt;
                

  
//  echo $this->renderPartial('//services/_new_rates'); 
   echo'</div>';
 
echo'   <div class="clear"></div>';

//echo '</div>';

$this->endContent();
?>
