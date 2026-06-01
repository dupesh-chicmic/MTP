<?php
$this->breadcrumbs=array(
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Dictionary')=>array('index'),
	$model->key,
);

    if(Yii::app()->user->isSu() == false){ //jest tylko adminem
        $this->menu=array(
                //array('label'=>$dict_dict_lista, 'url'=>array('index')),
                array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Update'), 'url'=>array('update', 'id'=>$model->id)),
                array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage dictionary elements'), 'url'=>array('admin')),
        );
    }else{ //jestem SU
        $this->menu=array(
                //array('label'=>$dict_dict_lista, 'url'=>array('index')),
                array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Add new element'), 'url'=>array('create')),
                array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Update'), 'url'=>array('update', 'id'=>$model->id)),
                array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Delete element'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
                array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage dictionary elements'), 'url'=>array('admin')),
        );
    }
?>

<?php echo '<h2>'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Update').' '.$model->key.'</h2>'; ?>

<?php $this->widget('zii.widgets.CDetailView', array(
        'cssFile'=>'',
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'key',
		'txt',
		//'client_editable',
		'value',
		'group',
		'actions',
	),
)); ?>
