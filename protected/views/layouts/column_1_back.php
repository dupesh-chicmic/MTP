<?php
            if( (Yii::app()->getUser()->getName() == 'admin') ){ //jest adminem
                $this->beginContent('/layouts/mainBack');
            }else if( (Yii::app()->getUser()->getName() == 'su') ){
                $this->beginContent('/layouts/mainBack');
            }else{
                $this->beginContent('//layouts/main');
            }
?>
<div id="container">
		<?php echo $content; ?>
</div>
<?php $this->endContent(); ?>