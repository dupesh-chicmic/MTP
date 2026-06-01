<?php
/* Layout strony - news details
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole

/* --- */

$this->beginContent('//layouts/main'); // dla mainApp


if(isset($_GET['nid']) && $_GET['nid'] != ''){
    // klik z listy newsow    
    $detailsNews = CmsNews::model()->find('id=?',array($_GET['nid'])); // konkretny news    
    $tytulNewsa = $detailsNews->title;
    $trescNewsa = $detailsNews->txt;        
}else{
    $tytulNewsa = $page->pageElement->news->title;
    $trescNewsa = $page->pageElement->news->txt;
}
/* Wyjatek: */
$layoutNewsDetails = CmsLayouts::model()->find('id=?',array(31)); // konkretny news    
/* --- */



echo '<div class="colLeft" style="float:left; width:20%; text-align:justify; padding:5px;">';
    $this->renderPartial('cms.views.layouts.CmsNews._'.$layoutNewsDetails->col_left);
echo '</div>';

echo '<p>';


echo '<div class="colRight" style="float:left; width:75%; text-align:justify; padding:5px;">';
    echo '<h4>'.$tytulNewsa.'</h4>';
    echo $trescNewsa;
echo '</div>';

$this->endContent();


?>