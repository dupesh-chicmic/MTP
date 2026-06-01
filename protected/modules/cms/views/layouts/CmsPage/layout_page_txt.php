<?php
/* Layout strony - 2 page txt
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */

$this->beginContent('//layouts/mainSubPage'); // dla mainApp
?>

<!--    <div id="appStore">';
                    echo Uzytkownik::model()->getVideo();
                    echo '<a class="store" href="#"></a>';
    echo '</div>-->
    <div id="left">
         <h1><?php echo $page->header; ?></h1>
         <?php echo $page->txt;?>
    </div>
  <div class="clear"></div>

<?php $this->endContent(); ?>
