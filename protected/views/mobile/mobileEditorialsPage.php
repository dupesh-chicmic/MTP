<?php
/*
 * Widok newsow (editorials)
 */
?>
<?php if(!empty($site)): ?>
    <h1><?php echo $site->header; ?></h1>
    
        <div id="left">     
        <?php foreach($lvNews as $item): ?>
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
                                'id'=>'e_'.$item->id,
                            )
                    );
                    echo '<script type="text/javascript">
                            $(\'#e_'.$item->id.'\').click(function( event ) {
                                jQuery.ajax({\'url\':\'index.php?r=site/viewNewsAjax&id='.$item->id.'\',\'cache\':false,\'success\':function(html){jQuery(".short_'.$item->id.'").html(html)}});
                            });
                         </script>';                        
                    ?></div>
                        <img class="right" src="./pictures/news/<?php echo $item['folder'];?>/<?php echo $item['image']; ?>" alt="" />
                       <div class="clear"></div>
                        <?php 
                        echo '</div>';//short_i
                        ?>
                </div>
        <?php endforeach;?>
        </div>

    <div class="clear"></div>
<?php endif; ?>
