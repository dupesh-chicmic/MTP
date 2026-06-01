<?php
$this->breadcrumbs=array(
	'Firmas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Firma', 'url'=>array('index')),
	array('label'=>'Manage Firma', 'url'=>array('admin')),
);
?>

<h1>Create Firma</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>