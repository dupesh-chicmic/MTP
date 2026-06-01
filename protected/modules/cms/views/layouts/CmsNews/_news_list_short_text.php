<?php
/* Dane startowe */
$listaNewsow = $this->pageDisplayer->newsList;
/* --- */

echo '<b>Pozostałe newsy:</b>';

echo '<ul>';

$first = 0;
foreach($listaNewsow as $item){
    if($first == 0){
        echo '<li style="padding:5px;">
            <a href="index.php?r=cms/cmsPage/showDetailsNews&url='.$_GET['url'].'&nid='.$item->id.'">'.$item->title.'</a><br />
                '.$item->short_txt.'
            </li>';
    }else{
        echo '<li style="padding:5px;"><a href="index.php?r=cms/cmsPage/showDetailsNews&url='.$_GET['url'].'&nid='.$item->id.'">'.$item->title.'</a></li>';
    }
    $first++;
}
echo '</ul>';

?>
