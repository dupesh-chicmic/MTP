<?php
$this->breadcrumbs=array(
	'Firmas',
);

$this->menu=array(
	array('label'=>'Create Firma', 'url'=>array('create')),
	array('label'=>'Manage Firma', 'url'=>array('admin')),
);
?>

<h1>Firmas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
