<?php
/* elementy ze slownika */

/* */
//            if( (Yii::app()->getUser()->getName() == 'admin') ){ //jest adminem
//                $this->beginContent('//layouts/main');
//            }else if( (Yii::app()->getUser()->getName() == 'su') ){
//                $this->beginContent('//layouts/main');
//            }else{
//                $this->beginContent('//layouts/mainFront');
//            }
            $this->beginContent('/layouts/main');
?>
<div id="container">

    <?php echo $content; ?>

</div>
<?php $this->endContent(); ?>