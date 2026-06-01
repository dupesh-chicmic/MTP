<?php
/* elementy ze slownika */
$dict_dodaj_zdjecie = Yii::t(Yii::app()->language.'_YiiTranslation', 'Add picture');
$dict_zarzadzaj_zdjeciami = Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage picture');
$dict_dodaj_zdjecie_def = Yii::t(Yii::app()->language.'_YiiTranslation', 'Add default picture');
$dict_delete_zdjecie = Yii::t(Yii::app()->language.'_YiiTranslation', 'Delete picture');
$dict_na_pewno_usunac = Yii::t(Yii::app()->language.'_YiiTranslation', 'Are you sure you want to delete this item?');

$dict_manage_element = Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage element');

/* */

if(isset($model->def_pic) && $model->def_pic != 'NO_IMAGE'){
    $image = $model->def_pic;

}else if(isset($model->image) && $model->image != 'NO_IMAGE'){
    $image = $model->image;
}else{ $image = ''; }

if($image == ''){
    $this->menu=array(
            array('label'=>$dict_manage_element, 'url'=>array('modelElement&&e='.$_GET['e'].'&&id='.$model->id.'&&edit=1')),
            array('label'=>$dict_dodaj_zdjecie_def, 'url'=>array('addPicture', 'id'=>$model->id,'def'=>'0', 'e'=>$_GET['e'])),
            array('label'=>$dict_dodaj_zdjecie, 'url'=>array('addPicture', 'id'=>$model->id, 'e'=>$_GET['e'])),
    );    
}else{
    $this->menu=array(
            array('label'=>$dict_manage_element, 'url'=>array('modelElement&&e='.$_GET['e'].'&&id='.$model->id.'&&edit=1')),
            array('label'=>$dict_dodaj_zdjecie, 'url'=>array('addPicture', 'id'=>$model->id, 'e'=>$_GET['e'])),
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


        $mainFolder = CmsUniversal::model()->getModelNameAndGenerateFolder($_GET['e']);
/*        
        $directory = 'pictures/'.$mainFolder.'/'.$model->folder.'/m';  //podaje sciezke/nazwa folderu
        
        if(file_exists($directory)){
            $dir = opendir($directory); //otworzenie folderu
        }else{ echo "Nie znalazłem folderu"; return; }
*/
        if(isset($_GET['e']) && $_GET['e'] == 'ProductGroup'){
            $mainFolder = 'product_group';
        }
        $directory = 'pictures/'.$mainFolder.'/'.$model->id.'/m';  //podaje sciezke/nazwa folderu
        
        if(file_exists($directory)){
            $dir = opendir($directory); //otworzenie folderu
        }else{            
            if(isset($_GET['e']) && $_GET['e'] != ''){
                $modelIs = $_GET['e'];
                $inputTypes = CActiveRecord::model($modelIs)->inputTypes();
                $mainPath = $inputTypes['image']['folder_name'];
              
                $pictureManager = new PictureManager;
                if($inputTypes['image']['folder_structure'] == 'main'){                    
                    $pictureManager->createMainFolder($mainPath.$_GET['id']);                    
                }else if(is_array ($inputTypes['image']['folder_structure']) ){
                    $pictureManager->createMainAndSubFolders($mainPath.$_GET['id'], 'm', 'd');
                }
                $dir = opendir($directory); //otworzenie folderu
            }else{
                echo 'Folder nie został znaleziony.'; return;
            }                            
        }        
        
        while($plik_nazwa = readdir($dir))  //odczytywanie
        {
            if(($plik_nazwa!=".")&&($plik_nazwa!="..")) //jesli element != "." i ".."   sprawdze prawidlowo folder w przeciwnym wypadku wyklucza elementy "." i ".."
                {                
                    if($image == $plik_nazwa){
                        //zdjecie defaultowe
//                        if(Yii::app()->params['universal_default_picture_delete'][1] == 0){//zmien
//                            echo'<div class="gallery_row_default"><img src="'.$directory.'/'.$plik_nazwa.'" alt="Brak obrazka domyślnego" />Domyślne<br /><a href="index.php?r=cms/cmsUniversal/addPicture&&id='.$model->id.'&&e='.$_GET['e'].'&&upd='.$plik_nazwa.'&&def=0">'.$dict_edit.'</a></div>';
//                        }else{//zmien i usun
//                            echo'<div class="gallery_row_default"><img src="'.$directory.'/'.$plik_nazwa.'" alt="Brak obrazka domyślnego" />Domyślne<br /><a href="index.php?r=cms/cmsUniversal/addPicture&&id='.$model->id.'&&e='.$_GET['e'].'&&upd='.$plik_nazwa.'&&def=0">'.$dict_edit.'</a> / <a href="index.php?r=cms/cmsUniversal/deletePicture&&e='.$_GET['e'].'&&id='.$model->id.'&&delete='.$plik_nazwa.'" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')">'.$dict_delete_zdjecie.'</a></div>';
//                        }
                        echo'<div class="gallery_row_default"><img src="'.$directory.'/'.$plik_nazwa.'" alt="Brak obrazka domyślnego" />Domyślne<br /><a href="index.php?r=cms/cmsUniversal/deletePicture&&e='.$_GET['e'].'&&id='.$model->id.'&&delete='.$plik_nazwa.'" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')">'.$dict_delete_zdjecie.'</a></div>';
                    }else{
                        echo '<div class="gallery_row_default"><img src="'.$directory.'/'.$plik_nazwa.'" /><br /><a href="index.php?r=cms/cmsUniversal/deletePicture&&e='.$_GET['e'].'&&id='.$model->id.'&&delete='.$plik_nazwa.'" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')"><br />'.$dict_delete_zdjecie.'</a></div>';
                    }
                }
                
//                
//                    if($model->image == $plik_nazwa){
//                        //zdjecie defaultowe
//                        echo '<div class="gallery_row"><img src="'.$directory.'/'.$plik_nazwa.'" /><a href="index.php?r=cms/cmsUniversal/deletePicture&&e='.$_GET['e'].'&&id='.$model->id.'&&delete='.$plik_nazwa.'"><br />'.$dict_delete_zdjecie.' (defaultowe)</a></div>';                        
//                    }else{
//                        echo '<div class="gallery_row"><img src="'.$directory.'/'.$plik_nazwa.'" /><a href="index.php?r=cms/cmsUniversal/deletePicture&&e='.$_GET['e'].'&&id='.$model->id.'&&delete='.$plik_nazwa.'"><br />'.$dict_delete_zdjecie.'</a></div>';
//                    }
//                
        }
        
        closedir($dir);//zamykam katalog
        
?>
