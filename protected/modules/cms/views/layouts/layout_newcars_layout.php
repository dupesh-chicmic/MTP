<?php
/* Layout strony - 2 page txt
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */

$this->beginContent('//layouts/mainSubPage'); // dla mainApp


//echo '<div class="colCenter" style="float:left; width:98%; text-align:justify; padding:5px;">';
 echo'<div id="appStore" style=" top: -80px">';
                    echo Uzytkownik::model()->getVideo();
                    echo '<a class="store" href="#"></a>';
                echo '</div>';  
 echo '    <div id="left">';
               echo'     <h1>New prices</h1>';
 // echo $page->txt;
//include 'example.php';
//echo 'test';

$cars_file = file_get_contents('./data/car/Alfa Romeo120.xml');
$cars = simplexml_load_string(html_entity_decode($cars_file), 'SimpleXMLElement', LIBXML_NOCDATA);
//$cars = new SimpleXMLElement('');
foreach ($cars->row as $row){
    echo 'row:'.$row->cell;
}
echo $cars;
               

  
  echo $this->renderPartial('//services/_new_rates'); 
   echo'</div>';
 
echo'   <div class="clear"></div>';

//echo '</div>';

$this->endContent();
?>
