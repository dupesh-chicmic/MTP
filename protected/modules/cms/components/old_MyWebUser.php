<?php
class MyWebUser extends CWebUser
{
    
   public function isSU(){        
        $user = Yii::app()->getUser()->getName();

        if($user == 'su'){
            return true;
        }else{
            return false;
        }

   }

}
?>
