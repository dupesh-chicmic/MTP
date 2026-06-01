<?php
/* ADMIN GALLERY */
/*
                    <script src="assets/js/tiptip/jquery.tipTip.minified.js" type="text/javascript"></script>
            <link rel="stylesheet" type="text/css" href="/locations_poland_live_4/assets/js/tiptip/tipTip.css" />
            <script>
                $(function(){
                $(".tip").tipTip();
                });     
            </script>
*/
                    

/* -- sortowanie zdjec -- */
/* aby dzial sortable pod IE9+ */
//Yii::app()->clientScript->registerScript('container','
//    (function($){var a=$.ui.mouse.prototype._mouseMove;$.ui.mouse.prototype._mouseMove=function(b){if($.browser.msie&&document.documentMode>=9){b.button=1};a.apply(this,[b]);}}(jQuery));
//',CClientScript::POS_HEAD);
//
//Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/js/jquery.ui.core.js',CClientScript::POS_HEAD);
//Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/js/jquery.ui.mouse.js',CClientScript::POS_HEAD);
//Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/js/jquery.ui.widget.js',CClientScript::POS_HEAD);
//Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/js/jquery.ui.sortable.js',CClientScript::POS_HEAD);
//
//Yii::app()->clientScript->registerScript('operations','  
//	$(function() {		
//		$(\'#sortableGallery\').sortable({
//			update: function(event, ui) {
//				var elementOrder = $(this).sortable(\'toArray\').toString();                                
//                                document.getElementById(\'order\').value=elementOrder;
//                                //alert(document.getElementById(\'order\').value);
//			}
//		});                
//		//$( "#sortableGallery" ).disableSelection();
//                
//	});
//',CClientScript::POS_HEAD);
 
 
/* ---- */


/* */
//COLORBOX gallery
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/js/colorbox_admin/jquery.colorbox-min.js',CClientScript::POS_HEAD);
Yii::app()->getClientScript()->registerCssFile($this->module->assetsUrl.'/js/colorbox_admin/colorbox.css');
Yii::app()->clientScript->registerScript('content','
		$(document).ready(function(){			
                        $(".gallery_lp").colorbox({width:"50%", height:"85%", iframe:true});
			//Example of preserving a JavaScript event for inline calls.
			$("#click").click(function(){
				$(\'#click\').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});
		});
',CClientScript::POS_HEAD);


$dict_dodaj_zdjecie = Yii::t(Yii::app()->language.'_YiiTranslation', 'Add picture');
$dict_zarzadzaj_zdjeciami = Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage picture');
$dict_delete_zdjecie = Yii::t(Yii::app()->language.'_YiiTranslation', 'Delete picture');
$dict_na_pewno_usunac = Yii::t(Yii::app()->language.'_YiiTranslation', 'Are you sure you want to delete this item?');
$dict_dodaj_zdjecie_def = Yii::t(Yii::app()->language.'_YiiTranslation', 'Add default picture');
$dict_edit = Yii::t(Yii::app()->language.'_YiiTranslation', 'Edit');
$dict_manage_element = Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage elements');
$dict_order_ustaw = Yii::t(Yii::app()->language.'_YiiTranslation', 'Set the order');


if(isset($model->def_pic) && $model->def_pic != 'NO_IMAGE'){
    $image = $model->def_pic;

}else if(isset($model->image) && $model->image != 'NO_IMAGE'){
    $image = $model->image;
}else{ $image = ''; }

if($image == ''){
    $this->menu=array(
            array('label'=>$dict_manage_element, 'url'=>array('modelElement&&e=CmsGallery&&id='.$model->id.'&&edit=1')),
            array('label'=>$dict_dodaj_zdjecie_def, 'url'=>array('gallery_addPicture', 'id'=>$model->id,'def'=>'0', 'e'=>'CmsGallery')),
            array('label'=>$dict_dodaj_zdjecie, 'url'=>array('gallery_addPicture', 'id'=>$model->id, 'e'=>'CmsGallery')),
    );    
}else{
    $this->menu=array(
            array('label'=>$dict_manage_element, 'url'=>array('modelElement&&e=CmsGallery&&id='.$model->id.'&&edit=1')),
            array('label'=>$dict_dodaj_zdjecie, 'url'=>array('gallery_addPicture', 'id'=>$model->id, 'e'=>'CmsGallery')),
    );
}

if(isset($model->title)){
    $title = $model->title;
}else if(isset($model->name)){
    $title = $model->name;
}else{
    $title = 'brak';
}

 echo '<h1>'.$dict_zarzadzaj_zdjeciami.' '.$title.'</h1>';
// echo '<div style="padding:5px;"><img title="Zdjęcia są dodawane zarówno do wersji polskiej jak i angielskiej" src="./images/admin/informationMark.png" style="width:25px; height:25px; padding-left:5px;" class="tip">'; 
// echo '<span class="orderGalleryAdmin"> Przeciągnij, upuść i </span>';
//
// echo CHtml::beginForm($this->module->assetsUrl.'/index.php?r=cms/cmsUniversal/orderGallery&e=CmsGallery&id='.$model->id.''); // uniwersalne dla kazdej galerii WAZNE dopisz e=MODEL po czym bedzie mozna w kontrolerze odroznic ORAZ ID !
// echo CHtml::submitButton($dict_order_ustaw).'</div>';


echo '<ul id="sortableGallery" unselectable="on" style="-moz-user-select: none;">';
        //$mainFolder = CmsUniversal::model()->getModelNameAndGenerateFolder($_GET['e']);
        $directory = 'pictures/gallery/'.$model->folder.'/d';  //podaje sciezke/nazwa folderu
        
        if(file_exists($directory)){
            $dir = opendir($directory); //otworzenie folderu
        }else{            
            if(isset($_GET['e']) && $_GET['e'] != ''){
                $modelIs = $_GET['e'];
                $inputTypes = InputTypes::model()->getInputTypes('CmsGallery');
                $mainPath = $inputTypes['image']['folder_name'];
              
                $pictureManager = new PictureManager;
                if($inputTypes['image']['folder_structure'] == 'main'){                    
                    $pictureManager->createMainFolder($mainPath.$_GET['id']);                    
                }else if(is_array ($inputTypes['image']['folder_structure']) ){
                    $pictureManager->createMainAndSubFolders($mainPath.$_GET['id'], 'm', 'd');
                }
                $dir = opendir($directory);
            }else{
                echo 'Folder galerii nie został znaleziony.'; return;
            }                            
        }

        $doSortowania = array();
        while($pliki = readdir($dir)){
            $doSortowania[] .= $pliki;
        }     
        
        $i=1;
        asort($doSortowania);
        //while($plik_nazwa = readdir($dir)){ //odczytywanie                                
        foreach ($doSortowania as $plik_nazwa){
            
            if(($plik_nazwa!=".")&&($plik_nazwa!="..")&&($plik_nazwa!=".svn")){                
                    if($image == $plik_nazwa){
                        //zdjecie defaultowe

                        if(Yii::app()->params['universal_gallery_default_picture_delete'][1] == 0){//zmien
                            //echo'<div class="gallery_row_default"><img src="'.$directory.'/'.$plik_nazwa.'" alt="Brak obrazka domyślnego" />Domyślne<a class="gallery_lp" href="index.php?r=cms/cmsUniversal/gallery_updateGalleryPicture&&id='.$model->id.'&&upd='.$plik_nazwa.'&&def=default"><br />'.$dict_edit.'</a></div>';
echo '<div class="gallery_row_default"><div class="cutImage" style="background-image: url('.$directory.'/'.$plik_nazwa.'); background-repeat: no-repeat; background-position: center -10px;">
</div>
Domyślne<a class="gallery_lp" href="index.php?r=cms/cmsUniversal/gallery_updateGalleryPicture&&id='.$model->id.'&&upd='.$plik_nazwa.'&&def=default"><br />'.$dict_edit.'</a>
</div>';                              
                        }else{//zmien i usun
                            //echo'<div class="gallery_row_default"><img src="'.$directory.'/'.$plik_nazwa.'" alt="Brak obrazka domyślnego" />Domyślne<a class="gallery_lp" href="index.php?r=cms/cmsUniversal/gallery_updateGalleryPicture&&id='.$model->id.'&&upd='.$plik_nazwa.'&&def=default"><br />'.$dict_edit.'</a> / <a href="index.php?r=cms/cmsUniversal/gallery_deletePicture&&id='.$model->id.'&&delete='.$plik_nazwa.'" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')">'.$dict_delete_zdjecie.'</a></div>';
echo '<div class="gallery_row_default"><div class="cutImage" style="background-image: url('.$directory.'/'.$plik_nazwa.'); background-repeat: no-repeat; background-position: center -10px;">
</div>
Domyślne<a class="gallery_lp" href="index.php?r=cms/cmsUniversal/gallery_updateGalleryPicture&&id='.$model->id.'&&upd='.$plik_nazwa.'&&def=default"><br />'.$dict_edit.'</a> / <a href="index.php?r=cms/cmsUniversal/gallery_deletePicture&&id='.$model->id.'&&delete='.$plik_nazwa.'" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')">'.$dict_delete_zdjecie.'</a>
</div>';                            
                        }
                    }else{
                        //echo '<li class="ui-state-default" id='.$i.'><img src="'.$directory.'/'.$plik_nazwa.'" /><a class="gallery_lp" href="index.php?r=cms/cmsUniversal/gallery_updateGalleryPicture&&id='.$model->id.'&&upd='.$plik_nazwa.'">Edytuj</a> / <a href="index.php?r=cms/cmsUniversal/gallery_deletePicture&&id='.$model->id.'&&delete='.$plik_nazwa.'" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')"><br />'.$dict_delete_zdjecie.'</a><input type="hidden" id="order" name="order['.$plik_nazwa.']" value="" /></li>';                        
echo '<li class="ui-state-default" id='.$i.'><div class="cutImage" style="background-image: url('.$directory.'/'.$plik_nazwa.'); background-repeat: no-repeat; background-position: center -10px;">
</div>
<a href="index.php?r=cms/cmsUniversal/gallery_deletePicture&&id='.$model->id.'&&delete='.$plik_nazwa.'" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')"><br />'.$dict_delete_zdjecie.'</a><input type="hidden" id="order" name="order['.$plik_nazwa.']" value="" />
</li>';                        
                    }
                    $i++;
                }
        }

        closedir($dir);//zamykam katalog
        
      echo '</ul>'; //sortable  
      echo CHtml::endForm();
?>
