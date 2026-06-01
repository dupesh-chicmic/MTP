<?php

if(Yii::app()->user->isAdmin || Yii::app()->user->isSu()){
echo '<h1>Import XML Kms Bands</h1>';

echo '<a href="index.php?r=member/importXmlFilesMain">Back</a><hr>';

    if(Yii::app()->user->hasFlash('importXmlError')){
        echo '<div class="flash-error">';
        echo Yii::app()->user->getFlash('importXmlError');
        echo '</div>';
    }
    if(Yii::app()->user->hasFlash('importXmlSuccess')){
        echo '<div class="flash-success">';
        echo Yii::app()->user->getFlash('importXmlSuccess');
        echo '</div>';
    }
    
// form
echo CHtml::form('','POST',array('enctype'=>'multipart/form-data'));
echo CHtml::submitButton('Import XML file');

}else{
    $this->redirect('index.php');
}
?>
