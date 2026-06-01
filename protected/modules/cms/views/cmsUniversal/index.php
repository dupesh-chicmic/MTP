<?php
$this->breadcrumbs=array(
	'Cms Universals',
);

$this->menu=array(
	array('label'=>'Create CmsUniversal', 'url'=>array('create')),
	array('label'=>'Manage CmsUniversal', 'url'=>array('admin')),
);
?>

<h1>Elementy uniwersalne</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
