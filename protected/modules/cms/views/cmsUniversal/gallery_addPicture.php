<?php
/* ADMIN GALLERY */
/* elementy ze slownika */
$dict_dodaj_zdjecie = Yii::t(Yii::app()->language.'_YiiTranslation', 'Add picture');
$dict_zarzadzaj_zdjeciami = Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage picture');
$dict_dodaj_zdjecie_def = Yii::t(Yii::app()->language.'_YiiTranslation', 'Add default picture');
/* */

$this->menu=array(	
        array('label'=>$dict_zarzadzaj_zdjeciami, 'url'=>array('gallery_pictureManage', 'id'=>$model->id, 'delete'=>'0')),
);
?>

<?php

$DBfield ='image';

    if(isset($_GET['def']) && $_GET['def']=='0'){
        echo '<h1>'.$dict_dodaj_zdjecie_def.' dla '.$model->title.'</h1>';
        $action = 'index.php?r=cms/cmsUniversal/gallery_addPicture&id=82&e=CmsGallery&&id='.$model->id.'&def=1';
        $DBfield ='image';
    }else{
        echo '<h1>'.$dict_dodaj_zdjecie.': '.$model->title.'</h1>';
        $DBfield ='image';
        $action = '';
    }

?>



<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>$action,
	'id'=>'cms-gallery-form',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

    

        <?php


                if(isset($_GET['img'])){
                    if($_GET['img'] == 'empty'){ echo '<div class="error_msg">Nie wybrano zdjecia</div>'; }
                }
                
            echo '<fieldset>
            <legend>'.$dict_dodaj_zdjecie.'</legend>';
            ?>
            <?php //echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>
            <?php echo CHtml::activeFileField($model, 'image'); ?>

            <?php echo $form->labelEx($modelGalleryPicture,'link'); ?><?php echo $form->textField($modelGalleryPicture,'link',array('size'=>50,'maxlength'=>500)); ?>
            <?php echo $form->labelEx($modelGalleryPicture,'link_title'); ?><?php echo $form->textField($modelGalleryPicture,'link_title',array('size'=>50,'maxlength'=>500)); ?>
            <?php echo $form->labelEx($modelGalleryPicture,'link_position'); ?><?php echo $form->dropDownList($modelGalleryPicture,'link_position',CHtml::listData(CmsDictionary::model()->dictionaryGetGroup('order_gallery_link_first_last'), 'value', 'txt')); ?>
            <?php echo $form->labelEx($modelGalleryPicture,'text'); ?><?php echo $form->textField($modelGalleryPicture,'text',array('size'=>50,'maxlength'=>500)); ?>


            <?php echo CHtml::submitButton($dict_dodaj_zdjecie); ?>
            <?php echo CHtml::endForm(); ?>

            <?php echo '</fieldset>';        
        ?>

<?php $this->endWidget(); ?>
</div>