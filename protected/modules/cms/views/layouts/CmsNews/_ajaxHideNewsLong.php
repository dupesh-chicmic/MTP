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
                'url'=>$this->createUrl('//site/viewNewsAjax',array('id'=>$item->id)),
                'update'=>'.short_'.$item->id
        ))
            )
        );                        
                        ?></div>
                        <img class="right" src="./pictures/news/<?php echo $item['folder'];?>/<?php echo $item['image']; ?>" alt="" />
                       <div class="clear"></div>
                    </div>