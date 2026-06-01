<?php
$this->breadcrumbs=array(
	'Cms Universals'=>array('index'),
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage'),
);

$this->menu=array(
	//array('label'=>'List CmsUniversal', 'url'=>array('index')),
	array('label'=>'Create CmsUniversal', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cms-universal-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage universal elements'); ?></h1>


<?php
echo '<div id="sideContent">';
echo '<div class="boxNewPage"><a href="index.php?r=cms/cmsPage/create"><img alt="arrow" src="'.$this->module->assetsUrl.'/images/admin/img/arrow.png"></a><div class="text"><a href="index.php?r=cms/cmsUniversal/create">'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Add new element').'</a></div></div>';
echo '</div><br />';

echo '<p>';
    echo Yii::t(Yii::app()->language.'_YiiTranslation', 'You may optionally enter a comparison operator (<, <=, >, >=, <> or =).');
echo '</p>';

echo CHtml::link(Yii::t(Yii::app()->language.'_YiiTranslation', 'Advanced search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cms-universal-grid',
	'dataProvider'=>$model->search(),
        'summaryText'=>'',
        'cssFile'=> $this->module->assetsUrl.'/css/gridViewStyle/backGrid.css',
	'filter'=>$model,
	'columns'=>array(
		'id',
		'table_name',
		'menu_top_label_pl',
		'menu_top_label_en',
		'field_to_display',
		'group',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
