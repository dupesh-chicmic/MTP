<?php
/* Dane startowe */
$listaNewsow = $this->pageDisplayer->newsList;
/* --- */

echo '<b>Pozostałe newsy:</b>';

echo '<ul>';
foreach($listaNewsow as $item){
    echo '<li style="padding:5px;"><a href="index.php?r=cms/cmsPage/showDetailsNews&url='.$_GET['url'].'&nid='.$item->id.'">'.$item->title.'</a></li>';
}
echo '</ul>';

?>
