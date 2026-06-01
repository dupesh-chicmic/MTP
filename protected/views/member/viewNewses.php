<?php foreach($listaNewsow as $item): ?>
      <div class="newsShort">
                       <h2><?php echo $item->title; ?></h2>
                      <small>Added <?php echo $item->_date; ?></small>
                        <p class="left newsText"><?php echo $item->txt; ?></p>
                        <img class="right" src="./pictures/news/<?php echo $item['folder'];?>/<?php echo $item['image']; ?>" alt="" />
                       <div class="clear"></div>
                                       </div>
<?php endforeach; ?>
<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)) ?>
                    
