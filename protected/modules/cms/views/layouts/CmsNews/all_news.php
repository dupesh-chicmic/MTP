<?php
/* Layout strony - news details
 */

/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole

/* --- */

$this->beginContent('//layouts/main'); // dla mainApp



if(isset($_GET['nid']) && $_GET['nid'] != ''){
    // klik z listy newsow    
    $detailsNews = CmsNews::model()->findAll('id=?',array($_GET['nid'])); // konkretny news    
    $tytulNewsa = $detailsNews->title;
    $trescNewsa = $detailsNews->txt;        
}else{
    $tytulNewsa = $page->pageElement->news->title;
    $trescNewsa = $page->pageElement->news->txt;
}

 echo'  <div id="appStore">';
                    echo Uzytkownik::model()->getVideo();
                    echo '<a class="store" href="#"></a>
                </div>';
$this->pageDisplayer->getNewsByOrderByFieldFromCmsUniversal(3);
$listaNewsow = $this->pageDisplayer->newsList;?>
   <div id="left">
        <p class="header1"><?php echo CmsDictionary::model()->dictionaryGetText('front_home_header'); ?>    
        <?php 
//        echo CHtml::link(
//                'Read more news',
//                array('//member/viewNewses') 
//               
//                
//                ); 
        ?></p>
        
<?php 
//$i = 0;
foreach($listaNewsow as $item): ?>
        <?php echo '<div class="short_'.$item->id.'">'; ?>
                    <div class="newsShort">
                       <h2><?php echo $item->title; ?></h2>
                      <small>Added <?php echo $item->_date; ?></small>
                        <div class="left newsText" style="padding:0px;"><?php echo $item->short_txt; 
echo CHtml::link(
        'Read more ',
        '',
            array(
                'class'=>'more',
                'onclick'=>CHtml::ajax(array(
                'url'=>$this->createUrl('//site/viewNewsAjax&id='.$item->id),
                'update'=>'.short_'.$item->id
        ))
            )
        );

//echo CHtml::ajaxLink('Read more',$this->createUrl('//site/viewNewsAjax',array('id'=>$item->id)), 
//        array('type'=>'GET', 
//              'update'=>'.short_'.$item->id.''),
//        array('class'=>'more'));                        
                        ?></div>
                        <?php if(!empty($item['image'])){ ?>
                        <img class="right" src="./pictures/news/<?php echo $item['folder'];?>/<?php echo $item['image']; ?>" alt="" />
                        <?php } ?>
                       <div class="clear"></div>
                        <?php 
//                        echo CHtml::link(
//                                'Read more',
//                                '',
//                                 array(
//                                        'class'=>'more',
//                                        'onclick'=>CHtml::ajax(array(
//                                        'url'=>$this->createUrl('//site/viewNewsAjax',array('id'=>$item->id)),
//                                        'success'=>'function(html){jQuery(event.target).closest(".newsShort").find(".newsText").html(html)}'
//                                ))
//                                    )
//                             );
                        
//echo CHtml::ajaxLink('ReadMore 2',$this->createUrl('//site/viewNewsAjax',array('id'=>$item->id)), 
//        array('type'=>'GET', 'url'=>array("site/registerBySocialServicesAjax"), 
//'update'=>'.newsText'),array('class'=>'more'));
                        //$i++;
                        echo '</div>';//short_i
                        ?>

                    </div>
<?php endforeach;?>
                </div>
    <div id="right">
<!--                    <h3><?php echo $tytulNewsa; ?> </h3>-->
                   <?php echo CmsPage::model()->findByPk(4)->txt;?>

                </div>
                <div class="clear"></div>

<?php $this->endContent(); ?>