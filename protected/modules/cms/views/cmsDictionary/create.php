<?php       
$this->breadcrumbs=array(
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Dictionary')=>array('index'),
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Add new element'),
);


$this->menu=array(
	//array('label'=>'List CmsDictionary', 'url'=>array('index')),
	array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage dictionary elements'), 'url'=>array('admin')),
);
?>

<?php echo '<h2>'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Add new element').'</h2>'; ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>