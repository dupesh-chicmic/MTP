<?php $this->pageTitle=Yii::app()->name; ?>

<?php
/* Layout strony - home
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */

$this->beginContent('//layouts/main'); // dla mainApp


echo '<div style="float:left; width:93%; text-align:justify; padding:5px;">';
echo '<h4>SZABLON strony z home (startowa)</h4>';
    echo '<h3>'.$page->header.'</h3>';
    echo $page->txt;

                echo '<div class="slideshowBanner" style="width: 750px; height: 150px; margin-top: 10px; position: relative;">';
                    echo QPageDisplayer::getBannerTop();
                echo '</div>';

echo '</div>';

$this->endContent();
?>
