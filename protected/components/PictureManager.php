<?php

define("NO_IMAGE","NO_IMAGE");
define("ERROR_DELETE","ERROR_DELETE");
define("ERROR_RENAME","ERROR_RENAME");

class PictureManager{    

    public function createMainFolder($path){
        /* tworzy tylko glowny folder */
        try{
            $mainDirectoy = mkdir($path, 0777);
        }catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
        }
    }
    
    public function createMainAndSubFolders($path, $subFolder1, $subFolder2){
        /* tworzy glowny folder oraz np. m i d dla galerii */        
        try{
            $mainDirectoy = mkdir($path, 0777);
            if($mainDirectoy == '1'){
                mkdir($path.'/'.$subFolder1, 0777);
                mkdir($path.'/'.$subFolder2, 0777);
            }                    
        }catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
        }
    }
    
    public function addPicureInMainFolder($model, $path, $picWidth, $picHeight, $formPictureField='image'){
        try{
            
            $image=CUploadedFile::getInstance($model,$formPictureField);
            if(empty($image)){ return NO_IMAGE; }
            else{
                $fileName = $image;
                
                $type = $image->getType();//np. images/jpeg
                $file_extension = substr($type, 6);
                
                /* DLA IE < 9 */
                if($file_extension == 'x-png'){ // only for IE<9
                    $file_extension = 'png';
                }else if($file_extension == 'pjpeg'){
                    $file_extension = 'jpg';
                }
                /* --- */                
                
                //generuje nazwe pliku
                $fileName = time().'_thumb.'.$file_extension;
                
                        if($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif' || $type == 'image/pjpeg' || $type == 'image/x-png'){
                            if(file_exists($path)){
                                $image->saveAs($path.'/'.$fileName); //false = nie usuwa z tempa
                            
                                $fullPathToFile = $path.'/'.$fileName;

                                $imageName = $this->ImgResize($picWidth, $picHeight, $fullPathToFile);
                                //usuwanie thumba
                                if (file_exists($fullPathToFile)){                                
                                    unlink($fullPathToFile);
                                }else{
                                    echo "File doesn't exist"; return NO_IMAGE;
                                }                            
                                return $imageName;
                            }else{ echo "Main folder doesn't exist"; return NO_IMAGE; }
                            
                        }else if($type == 'application/x-shockwave-flash'){ 
                            if(file_exists($path)){//echo 'flash';
                                $file_flash = substr($fileName, 0, -10);//usuwa _thumb.swf
                                $file_flash = $file_flash.'.'.$file_extension;
                        
                                $image->saveAs($path.'/'.$file_flash);   
                                                               
                                $oldDefaultPicDel = $path.'/'.$oldDefaultPic;                                                                
                                                   
                                if ($oldDefaultPic != '' ){
                                    unlink($oldDefaultPicDel);    
                                }
                                
                                return $file_flash;
                            }else{ echo "Main folder doesn't exist"; return NO_IMAGE; }
                        }else{
                            echo "Wrong file"; return NO_IMAGE;
                        }               
            }
            
        }catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
        }
    }
    
    
    //public function addPicureInSubFolders($model, $MainPath, $subFolderName1, $picWidthSubFolder1, $picHeightSubFolder1, $subFolderName2, $picWidthSubFolder2, $picHeightSubFolder2, $formPictureField='image'){
    public function addPicureInSubFolders($model, $MainPath, $foldersList, $formPictureField='image'){
        try{
            
            $image=CUploadedFile::getInstance($model,$formPictureField);
            if(empty($image)){ return NO_IMAGE; }
            else{
                $fileName = $image;
                
                $type = $image->getType();//np. images/jpeg
                $file_extension = substr($type, 6);
                
                /* DLA IE < 9 */
                if($file_extension == 'x-png'){ // only for IE<9
                    $file_extension = 'png';
                }else if($file_extension == 'pjpeg'){
                    $file_extension = 'jpg';
                }
                /* --- */                
                
                //generuje nazwe pliku
                $fileName = time().'_thumb.'.$file_extension;
                
                        if($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif' || $type == 'image/pjpeg' || $type == 'image/x-png'){
                            //zapisuje 2 thumby
                            if(file_exists($MainPath)){
                                foreach ($foldersList as $folders_key=>$folders_val){
                                    $image->saveAs($MainPath.'/'.$folders_key.'/'.$fileName, false); //false = nie usuwa z tempa

                                    $fullPathToFile = $MainPath.'/'.$folders_key.'/'.$fileName;
                                    $returnFileName = $this->ImgResize($folders_val['image_width'], $folders_val['image_height'], $fullPathToFile);
                                    
                                    //usuwanie thumba z subFolderow
                                    if (file_exists($fullPathToFile)){
                                        unlink($fullPathToFile);                                       
                                    }else{
                                        echo "File doesn't exist"; return NO_IMAGE;
                                    }
                                }

                                return $returnFileName;
                            }else{ echo "Main folder doesn't exist"; return NO_IMAGE; }
                            
                        }else if($type == 'application/x-shockwave-flash'){ 
                            if(file_exists($MainPath)){//echo 'flash';
                                $file_flash = substr($fileName, 0, -10);//usuwa _thumb.swf
                                $file_flash = $file_flash.'.'.$file_extension;
                        
                                $image->saveAs($MainPath.'/'.$folders_key.'/'.$file_flash);   
                                                               
                                $oldDefaultPicDel = $MainPath.'/'.$folders_key.'/'.$oldDefaultPic;                                                                
                                                   
                                if ($oldDefaultPic != '' ){
                                    unlink($oldDefaultPicDel);    
                                }
                                
                                return $file_flash;
                            }else{ echo "Main folder doesn't exist"; return NO_IMAGE; }
                        }else{
                            echo "Wrong file"; return NO_IMAGE;
                        }                 
            }
            
        }catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
        }        
    }
    
/* --- */
    /* funkcje defaultowe dodatkowo usuwaja stary defaultowy obrazek z dysku */
    public function add_Default_PicureInSubFolders($oldDefaultPic, $model, $MainPath, $foldersList, $formPictureField='image'){
        try{
            
            $image=CUploadedFile::getInstance($model,$formPictureField);
            if(empty($image)){ return NO_IMAGE; }
            else{
                $fileName = $image;
                
                $type = $image->getType();//np. images/jpeg
                $file_extension = substr($type, 6);
                
                /* DLA IE < 9 */
                if($file_extension == 'x-png'){ // only for IE<9
                    $file_extension = 'png';
                }else if($file_extension == 'pjpeg'){
                    $file_extension = 'jpg';
                }
                /* --- */
                
                //generuje nazwe pliku
                $fileName = time().'_thumb.'.$file_extension;
                
                        if($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif' || $type == 'image/pjpeg' || $type == 'image/x-png'){
                            if(file_exists($MainPath)){
                                foreach ($foldersList as $folders_key=>$folders_val){
                                    $image->saveAs($MainPath.'/'.$folders_key.'/'.$fileName, false); //false = nie usuwa z tempa

                                    $fullPathToFile = $MainPath.'/'.$folders_key.'/'.$fileName;
                                    $returnFileName = $this->ImgResize($folders_val['image_width'], $folders_val['image_height'], $fullPathToFile);
                                    
                                    $pathToOldDefaultPic = $MainPath.'/'.$folders_key.'/'.$oldDefaultPic;
                                    //usuwanie thumba z subFolderow
                                    if (file_exists($fullPathToFile)){
                                        unlink($fullPathToFile);                                       
                                    }else{
                                        echo "File doesn't exist"; return NO_IMAGE;
                                    }
                                    
                                    if ($oldDefaultPic != '' ){
                                        unlink($pathToOldDefaultPic);                             
                                    }                      
                                }

                                return $returnFileName;                          
                            }else{ echo "Main folder doesn't exist"; return NO_IMAGE; }
                            
                        }else if($type == 'application/x-shockwave-flash'){ 
                            if(file_exists($MainPath)){//echo 'flash';
                                $file_flash = substr($fileName, 0, -10);//usuwa _thumb.swf
                                $file_flash = $file_flash.'.'.$file_extension;
                        
                                $image->saveAs($MainPath.'/'.$folders_key.'/'.$file_flash);   
                                                               
                                $oldDefaultPicDel = $MainPath.'/'.$folders_key.'/'.$oldDefaultPic;                                                                
                                                   
                                if ($oldDefaultPic != '' ){
                                    unlink($oldDefaultPicDel);    
                                }
                                
                                return $file_flash;
                            }else{ echo "Main folder doesn't exist"; return NO_IMAGE; }
                        }else{
                            echo "Wrong file"; return NO_IMAGE;
                        }              
            }
            
        }catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
        }        
    }
    
    
    public function add_Default_PicureInMainFolder($oldDefaultPic, $model, $path, $picWidth, $picHeight, $formPictureField='image'){
        try{
            
            $image=CUploadedFile::getInstance($model,$formPictureField);
            if(empty($image)){ return NO_IMAGE; }
            else{
                $fileName = $image;

                //$file_extension = substr($fileName, -3);//zostawia tylko jpg/png/gif
                $type = $image->getType();//np. images/jpeg
                $file_extension = substr($type, 6);
                
                /* DLA IE < 9 */
                if($file_extension == 'x-png'){ // only for IE<9
                    $file_extension = 'png';
                }else if($file_extension == 'pjpeg'){
                    $file_extension = 'jpg';
                }
                /* --- */                
                
                //generuje nazwe pliku
                $fileName = time().'_thumb.'.$file_extension;
                
                        if($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif' || $type == 'image/pjpeg' || $type == 'image/x-png'){             
                            if(file_exists($path)){
                                $image->saveAs($path.'/'.$fileName); //false = nie usuwa z tempa
                            
                                $fullPathToFile = $path.'/'.$fileName;
                                $oldDefaultPicDel = $path.'/'.$oldDefaultPic;
                                
                                $imageName = $this->ImgResize($picWidth, $picHeight, $fullPathToFile);
                                //usuwanie thumba
                                if (file_exists($fullPathToFile)){                                
                                    unlink($fullPathToFile);                                                                                                        
                                }else{
                                    echo "File doesn't exist"; return NO_IMAGE;
                                }                           
                                if ($oldDefaultPic != '' ){
                                    unlink($oldDefaultPicDel);    
                                }
                                return $imageName;
                            }else{ echo "Main folder doesn't exist"; return NO_IMAGE; }
                            
                        }else if($type == 'application/x-shockwave-flash'){ 
                            if(file_exists($path)){//echo 'flash';
                                $file_flash = substr($fileName, 0, -10);//usuwa _thumb.swf
                                $file_flash = $file_flash.'.'.$file_extension;
                        
                                $image->saveAs($path.'/'.$file_flash);   
                                                               
                                $oldDefaultPicDel = $path.'/'.$oldDefaultPic;                                                                
                                                   
                                if ($oldDefaultPic != '' ){
                                    unlink($oldDefaultPicDel);    
                                }
                                
                                return $file_flash;
                            }else{ echo "Main folder doesn't exist"; return NO_IMAGE; }
                        }else{
                            echo "Zły typ pliku. Spróbuj dodać obraz formatu .png .jpg .gif"; return NO_IMAGE;
                        }
            }
            
        }catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
        }
    }    
    
/* --- */    
    
    
    public function deleteFolderOrFile($fullPathWithFileName){
        if (file_exists($fullPathWithFileName)){                                
            unlink($fullPathWithFileName);
        }else{
            echo "File doesn't exist"; 
            return ERROR_DELETE;
        }        
    }
    
    
    public function renameFile($fullPathWithFileName ,$postFix='_postFix'){
        if(file_exists($fullPathWithFileName)){
             $oldname = $fullPathWithFileName;
             $newname = $fullPathWithFileName.$postFix;             
             rename($oldname, $newname);           
        }else{
            echo "File doesn't exist";  return ERROR_RENAME;
        }        
    }  
    
    
    /* korzysta z ImageHelper */
    public function ImgResize($width, $height, $path, $folder=null){
        if($folder == 'm'){
                    //$pathToResizeFile_duzy = './gallery/'.$folder.'/d/'.$file_name;
                    $fileName = Yii::app()->request->baseUrl.ImageHelper::thumb($width,$height,$path, array(
                        'method' => 'resize',
                        'quality' => 90));
            //return $$file_name;
        }else if($folder == 'd'){
                    //$path_d = $path;
                    //$path_d = './gallery/'.$folder.'/d/'.$file_name;
                    $fileName = Yii::app()->request->baseUrl.ImageHelper::thumb($width,$height,$path, array(
                        'method' => 'resize',
                        'quality' => 90));
            //return $$file_name;
        }else if($folder == null){
                    $fileName = Yii::app()->request->baseUrl.ImageHelper::thumb($width,$height,$path, array(
                        'method' => 'resize',
                        'quality' => 90));
        }
        //ostatnie 14 znakow to nazwa pliku
        //$fileExtension = substr($fileName, -4); 

        $path_parts = pathinfo($fileName);
        $fileExtension = $path_parts['extension'];
             
        if($fileExtension == 'jpeg'){
            $fileName = substr($fileName, -15);
        }else if($fileExtension == 'pjpeg'){ // only for IE<9
            $fileName = substr($fileName, -16);//ma pjpeg
            $fileName = substr($fileName, 0,10);//time
            $fileName = $fileName.'.jpg';
        }else if($fileExtension == 'x-png'){ // only for IE<9
            $fileName = substr($fileName, -16);
            $fileName = substr($fileName, 0,10);//time
            $fileName = $fileName.'.png';            
        }else{
            $fileName = substr($fileName, -14);
        }
        
        return $fileName;
    }    
    
}

?>
