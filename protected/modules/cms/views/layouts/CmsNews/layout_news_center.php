<?php
     /* Dla CMS module */
        $this->beginContent('cms.views.layouts.column1');
     /* --- */

     /* Dla glownej aplikacji */
     //   $this->beginContent('//layouts/main');
?>

<?php
if(isset($_GET['url'])){
    $url = $_GET['url'];
    $home = CmsPage::model()->getRow('CmsPage','url',$url); 
}
?>

		<div class="content">		
                    layout_news_center<p>
<?php        
    $page = $this->pageDisplayer->page;
    echo '<h1>'.$page->header.'</h1>';
    $this->renderPartial('cms.views.layouts.CmsNews._main_news_on_the_left');
?>
		</div>


<?php $this->endContent(); ?>