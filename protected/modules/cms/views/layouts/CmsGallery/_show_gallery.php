<?php

if(isset($_GET['gid']) && $_GET['gid'] != ''){
    $galleryId = $_GET['gid'];
}else{
    $page = $this->pageDisplayer->page; // wywolanie $page->pole
    $galleryId = $page->pageElement->gallery->id;
}

Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/js/colorbox/jquery.colorbox-min.js',CClientScript::POS_HEAD); //1 .3.19
Yii::app()->getClientScript()->registerCssFile($this->module->assetsUrl.'/js/colorbox/colorbox.css');
Yii::app()->clientScript->registerScript('content','
		$(document).ready(function(){			
                    $(".gallery_qx").colorbox({rel:\'gallery_qx\'});		
		});
',CClientScript::POS_HEAD);

    $directory = InputTypes::model()->getInputTypes('CmsGallery');
    $directory_m = $directory['image']['folder_name'].$galleryId.'/m';
    $directory_d = $directory['image']['folder_name'].$galleryId.'/d';

    try{
        foreach (new DirectoryIterator($directory_m) as $fileInfo) {
            $plik_nazwa = $fileInfo->getFilename();
            
                if(($plik_nazwa!=".")&&($plik_nazwa!="..")&&($plik_nazwa!=".svn")){
                    echo '<div style="width:170px; height:120px; float:left; padding:5px;">';
                        echo '<div class="gallery_pic" style="padding:5px; max-width:165px; float:left;">';
                        echo '<a class="gallery_qx" target="_blank" href="'.$directory_d.'/'.$plik_nazwa.'" ><img alt="" src="'.$directory_m.'/'.$plik_nazwa.'" /></a>';
                        echo '</div>';
                    echo '</div>';
                }

        }
    }catch (Exception $e) {
        throw new CHttpException(404,Yii::t(Yii::app()->language.'_YiiTranslation', 'The requested page does not exist.'));
    }
?>