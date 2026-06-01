<?php


abstract class CmsActiveRecord extends CActiveRecord {
    
        public function init(){
            $this->refreshMetaData();
        }

	protected function prefixTableName($tableName)
	{          
            $tableName = substr($tableName, 2);
            if(isset($_SESSION['lang'])){ 
                return $_SESSION['lang'].$tableName;
            }else{
                return Yii::app()->language.$tableName; //pierwsze uruchomienie
            }
	}    
    
    
}


?>
