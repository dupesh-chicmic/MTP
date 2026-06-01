<?php
/*
 * Strona z tekstem.
 * Dodatkowo jesli strona posiada podstrony to są one generowane.
 */
?>
<?php if(!empty($site)): ?>
    <?php // w pod menu trzeba pokazac link z ktorego sie przyszlo ale musi byc rozny od strony MOBILE_VIEW = 1 i TOP_MENU = 3 ?>
    <?php if($site->parent_id != 1 && $site->parent_id != 3 && $site->parent_id != 65) : //65 = rodzic VRT Tax Rates - nie chce tam sie cofac bo to strona web nie mobile
            $lvPrevPage = CmsPage::model()->findByPk($site->parent_id);
            if(!empty($lvPrevPage))
                echo '<a href="'.Yii::app()->createUrl('mobile/view',array('url'=>$lvPrevPage->url)).'" data-role="button" data-theme="b" data-corners="false">Back to '.$lvPrevPage->link_name.'</a>';
    ?>
        <?php endif; ?>

    <?php 
        $lvSubPages = Mobile::getMobileSites($site->id);
        if(!empty($lvSubPages)) : ?>
            <ul id="nav">
                <?php foreach($lvSubPages as $lvItem) : 
                        if(empty($lvItem->param_1))
                        {
                            $lvUrl = Yii::app()->createUrl('mobile/view',array('url'=>$lvItem->url));
                        }
                        else
                        {
                            $lvUrl = $lvItem->param_1;
                        }
                ?>
                <a href="<?php echo $lvUrl; ?>" data-role="button" data-theme="b" data-corners="false"><?php echo $lvItem->link_name; ?></a>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

<div class="backgroundTextPage">
    <h1><?php echo $site->header; ?></h1>
    <?php echo $site->txt;?>
    <div class="clear"></div>
</div>
<?php endif; ?>
