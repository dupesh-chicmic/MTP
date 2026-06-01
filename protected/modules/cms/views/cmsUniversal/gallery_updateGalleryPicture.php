<?php
/* ADMIN */
/*
 * Formularz zmiany danych w tabeli cms_gallery_picture
 */
$dict_update = Yii::t(Yii::app()->language.'_YiiTranslation', 'Update');

Yii::app()->clientScript->registerScript('content','
    $(function() {
      $("#refresh").click(function(evt) {
         $("#form").load("index.php")
         evt.preventDefault();
      })
    })    
',CClientScript::POS_HEAD);    
$this->beginContent('none'); //dla popupow



?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cms-gallery-form',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

    

<?php         
            echo '<fieldset>';
            if(isset($_GET['def'])){
                if($_GET['def']=='default'){
                    echo '<legend>'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Update default picture').'</legend>';
                }
            }else{
                    echo '<legend>'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Update data').'</legend>';
            }
            
        $directory = 'pictures/gallery/'.$_GET['id'].'/m';  //podaje sciezke/nazwa folderu
        if(file_exists($directory)){
            $dir = opendir($directory); //otworzenie folderu
        }else{ echo "Nie znalazłem folderu"; return; }

        while($plik_nazwa = readdir($dir))  //odczytywanie
        {
            if(($plik_nazwa!=".")&&($plik_nazwa!="..")&&($plik_nazwa!=".svn"))
                {                
                    if($_GET['upd'] == $plik_nazwa){
//echo $modelGalleryPicture->id;
                        echo'<div class="gallery_row_default"><img src="'.$directory.'/'.$plik_nazwa.'" /></div><p>';
                    }
                }
        }
        
        closedir($dir);//zamykam katalog            
            
?>            
            <?php //echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); 
          
            if(isset($_GET['def'])){
                if($_GET['def']=='default'){
                    echo CHtml::activeFileField($modelGalleryPicture, 'image');
                }
            }
                
?>
            <?php echo $form->labelEx($modelGalleryPicture,'link'); ?><?php echo $form->textField($modelGalleryPicture,'link',array('size'=>50,'maxlength'=>500)); ?>
            <?php echo $form->labelEx($modelGalleryPicture,'link_title'); ?><?php echo $form->textField($modelGalleryPicture,'link_title',array('size'=>50,'maxlength'=>500)); ?>
            <?php echo $form->labelEx($modelGalleryPicture,'link_position'); ?><?php echo $form->dropDownList($modelGalleryPicture,'link_position',CHtml::listData(CmsDictionary::model()->dictionaryGetGroup('order_gallery_link_first_last'), 'value', 'txt')); ?>
            <?php echo $form->labelEx($modelGalleryPicture,'text'); ?><?php echo $form->textField($modelGalleryPicture,'text',array('size'=>50,'maxlength'=>500)); ?>


            <?php echo CHtml::submitButton($dict_update, array('id'=>'refresh')); ?>
            

            <?php echo '</fieldset>'; ?>
        
   
<?php $this->endWidget(); ?>
</div>
<?php $this->endContent(); ?>