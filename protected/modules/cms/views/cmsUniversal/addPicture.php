<?php
/* elementy ze slownika */
$dict_dodaj_zdjecie = Yii::t(Yii::app()->language.'_YiiTranslation', 'Add picture');
$dict_zarzadzaj_zdjeciami = Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage picture');
$dict_dodaj_zdjecie_def = Yii::t(Yii::app()->language.'_YiiTranslation', 'Add default picture');
$dict_manage_element = Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage elements');
/* */

$this->menu=array(
	array('label'=>$dict_manage_element, 'url'=>array('modelElement&&e='.$_GET['e'].'&&id='.$_GET['id'].'&&edit=1')),
        array('label'=>$dict_zarzadzaj_zdjeciami, 'url'=>array('pictureManage','e'=>$_GET['e'], 'id'=>$_GET['id'], 'delete'=>'0')),
);

if(isset($model->title)){
    $title = $model->title;
}else if(isset($model->name)){
    $title = $model->name;
}else{
    $title = 'brak';
}

if(isset($_GET['def']) && $_GET['def']=='0'){
        echo '<h1>'.$dict_dodaj_zdjecie_def.' '.$title.'</h1>';
        $action = '';
        $DBfield ='image';
}else{
    echo '<h1>'.$dict_dodaj_zdjecie.' : '.$title.'</h1>';
    $DBfield ='image';
    $action = '';
}


if(isset($_GET['img'])){
    echo '<div class="error_msg">Nie wybrano zdjecia</div>';
}
                    $info = Yii::app()->user->getState('infoMsg');
                    if(!empty($info)){
                        echo '<div style="color:red; font-weight:bolder;">'.$info.'</div>';
                        Yii::app()->user->setState('infoMsg', '');//zerowanie msg
                    }

echo '<fieldset>
<legend>'.$dict_dodaj_zdjecie.'</legend>';
?>
<?php echo CHtml::form($action,'post',array('enctype'=>'multipart/form-data')); ?>
<?php echo CHtml::activeFileField($model, 'image'); ?>

<?php echo CHtml::submitButton($dict_dodaj_zdjecie); ?>
<?php echo CHtml::endForm(); ?>

<?php echo '</fieldset>'; ?>

