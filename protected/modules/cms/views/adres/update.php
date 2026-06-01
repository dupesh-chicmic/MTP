<?php
$this->breadcrumbs=array(
	'Adres'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Adres', 'url'=>array('index')),
	array('label'=>'Create Adres', 'url'=>array('create')),
	array('label'=>'View Adres', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Adres', 'url'=>array('admin')),
);
?>

<h1>Update Adres <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>