<?php
/* Layout strony - news and page
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */
$this->beginContent('//layouts/mainSubPage'); // dla mainApp
?>

<div id="contactPage" id="left" >
    <?php echo '<h1>'.$page->header.'</h1>'; ?>
    <?php $this->renderPartial('cms.views.layouts.CmsPage._'.$page->cmsLayouts->col_left); ?>
</div>
<!--<div id="right">
   <?php echo $page->txt; ?>
</div>-->
<div class="clear"></div>
<?php $this->endContent();?>