<?php
$this->breadcrumbs=array(
	'Cms Universals'=>array('index'),
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Create'),
);

$this->menu=array(
	//array('label'=>'List CmsUniversal', 'url'=>array('index')),
	array('label'=>'Manage CmsUniversal', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t(Yii::app()->language.'_YiiTranslation', 'Create new universal element'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>