<?php
$this->breadcrumbs=array(
	'Adres'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Adres', 'url'=>array('index')),
	array('label'=>'Manage Adres', 'url'=>array('admin')),
);
?>

<h1>Create Adres</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>