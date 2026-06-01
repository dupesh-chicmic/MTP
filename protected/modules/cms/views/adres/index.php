<?php
$this->breadcrumbs=array(
	'Adres',
);

$this->menu=array(
	array('label'=>'Create Adres', 'url'=>array('create')),
	array('label'=>'Manage Adres', 'url'=>array('admin')),
);
?>

<h1>Adres</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
