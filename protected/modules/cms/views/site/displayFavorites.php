<?php      

                        
echo '<h3>Favorites locations:</h3>';
echo '<table class="favoriteTable">';

$i=0;
$class = '';
foreach ($model as $item){
    
//    if($i%2){
//        $class='favoriteRow';
//    }else{
//        $class='favoriteRow_mod';
//    }
    
                            $criteria=new CDbCriteria;
                            $criteria->select="*";
                            $criteria->compare('article_id',$item->articles->id);
                            $category = CmsArticleCategories::model()->find($criteria);    
                            
    echo '<tr class="favoriteRow" onMouseover="this.bgColor=\'#AAAAAA\'"onMouseout="this.bgColor=\'#DDDDDD\'"><td><a href="index.php?r=cmsArticle/articleDetailsView&id='.$item->articles->id.'&cat_id='.$category['category_id'].'">'.$item->articles->nazwa.'</a></td> ';
    
    echo '<td class="tdDel"><a href="index.php?r=site/deleteFavorites&id='.$item->articles->id.'">Usuń z ulubionych</a></td></tr>';
    $i++;
}

echo '</table>';


?>




