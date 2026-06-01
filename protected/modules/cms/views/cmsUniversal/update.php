<?php
$this->breadcrumbs=array(
	'Cms Universals'=>array('index'),
	$model->table_name=>array('view','id'=>$model->id),
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Update'),
);

$this->menu=array(
	//array('label'=>'List CmsUniversal', 'url'=>array('index')),
	array('label'=>'Create CmsUniversal', 'url'=>array('create')),
	array('label'=>'View CmsUniversal', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CmsUniversal', 'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t(Yii::app()->language.'_YiiTranslation', 'Update'); ?> element <?php echo $model->table_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>