<?php
$this->breadcrumbs=array(
	'Cms Universals'=>array('index'),
	$model->table_name,
);

$this->menu=array(
	//array('label'=>'List CmsUniversal', 'url'=>array('index')),
	array('label'=>'Create CmsUniversal', 'url'=>array('create')),
	array('label'=>'Update CmsUniversal', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CmsUniversal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CmsUniversal', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->table_name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'table_name',
		'menu_top_label_pl',
		'menu_top_label_en',
		'field_to_display',
		'group',
		'group_label',
		'label_replace',
		'layout',
		'display',
		'view_list',
		'view_details',
		'help',
		'deletable',
		'admin_display',
		'order_by',
	),
)); 
?>



