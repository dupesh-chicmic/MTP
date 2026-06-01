<?php
/* Layout strony - 2 page txt
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */

$this->beginContent('//layouts/main'); // dla mainApp


//echo '<div class="colCenter" style="float:left; width:98%; text-align:justify; padding:5px;">';
    echo '<h3>'.$page->header.'</h3>';
    echo $page->txt;
//echo '</div>';

$this->endContent();
?>
