<?php
    $menuRight = $this->pageDisplayer->menu; 
    echo '<ul>';            
        foreach($menuRight as $item){
            echo '<li>';
            echo '<a href="index.php?r=cms/cmsPage/displayPage&url='.$item->url.'">'.$item->link_name.'</a>';
            echo '</li>';
        }
    echo '</ul>';
?>
