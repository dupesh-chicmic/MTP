<?php
$this->breadcrumbs=array(
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Dictionary')=>array('index'),
	$model->key=>array('view','id'=>$model->id),
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Update'),
);

    if(Yii::app()->user->isSu() == false){ //jest tylko adminem
        $this->menu=array(
                //array('label'=>$dict_dict_lista, 'url'=>array('index')),
                array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Element details'), 'url'=>array('view', 'id'=>$model->id)),
                array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage dictionary elements'), 'url'=>array('admin')),
        );
    }else{ //jestem SU
        $this->menu=array(
                //array('label'=>$dict_dict_lista, 'url'=>array('index')),
                array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Add new element'), 'url'=>array('create')),
                array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Element details'), 'url'=>array('view', 'id'=>$model->id)),
                array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage dictionary elements'), 'url'=>array('admin')),
        );
    }
?>

<?php echo '<h2>'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Update').' '.$model->key.'</h2>'; ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>