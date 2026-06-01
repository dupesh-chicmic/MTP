<?php
            if( (Yii::app()->getUser()->getName() == 'admin') ){ //jest adminem
                $this->beginContent('/layouts/main');
            }else if( (Yii::app()->getUser()->getName() == 'su') ){
                $this->beginContent('/layouts/main');
            }else{
                $this->beginContent('//layouts/mainFront');
            }
?>
<div id="container">
<?php
    if( (Yii::app()->getUser()->getName() == 'su') ||   (Yii::app()->getUser()->getName() == 'admin')  ){
?>    
	<div class="operations">
<div class="boxNewPage"><img alt="arrow" src="<?php echo $this->module->assetsUrl; ?>/images/admin/img/arrow.png"><div class="text"><?php echo Yii::t(Yii::app()->language.'_YiiTranslation', 'Options'); ?></div></div>            
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				//'title'=>$dict_operations,
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'boxBackground'),
			));
			$this->endWidget();
		?>		
	</div>
<?php
    }
?>
    
    <div class="content">
			<?php echo $content; ?>
    </div>
   

</div>
<?php $this->endContent(); ?>