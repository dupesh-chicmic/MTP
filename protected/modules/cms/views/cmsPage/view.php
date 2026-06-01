<?php
$this->redirect(array('/cms/cmsPage/update','id'=>$model->id));


$this->breadcrumbs=array(
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Pages')=>array('index'),
	$model->name,
);

//$this->menu=array(
//	//array('label'=>'List CmsPage', 'url'=>array('index')),
//	array('label'=>$dict_dodaj_nowa, 'url'=>array('create')),
//	array('label'=>$dict_update_strony, 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>$dict_delete_strony, 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>$dict_zarzadzaj_stronami, 'url'=>array('admin')),
//);
?>

<h1><?php echo $model->title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent_id',
		'url',
		'name',
		'title',
		'header',
		'link_name',
		'keywords',
		'function',
		'layout',
		'template',
		'seo_visible',
		'seo_unvisible',
		'param_1',
		'param_2',
		'txt',
		'button',
		'order',
		'editable',
		'display',
	),
)); ?>
