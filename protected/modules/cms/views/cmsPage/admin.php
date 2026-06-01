<?php
/* elementy ze slownika */
$dict_strony = CmsDictionary::model()->dictionaryGetText('adm_strony');
$dict_zarzadzaj_stronami = Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage pages');
$dict_wyszukiwanie_zaaw = Yii::t(Yii::app()->language.'_YiiTranslation', 'Advanced search');
/* */

$this->breadcrumbs=array(
	$dict_strony=>array('index'),
	$dict_zarzadzaj_stronami,
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cms-page-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php echo '<h1><img class="navImageBig" src="'.$this->module->assetsUrl.'/images/admin/dictionary.png" />'.$dict_zarzadzaj_stronami.'</h1>'; ?>
<!--
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
-->
<?php echo CHtml::link($dict_wyszukiwanie_zaaw,'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php //NOWE ZARZADZANIE STRONAMI ?>

<?php


?>





<?php 

$this->widget('zii.widgets.grid.CGridView', array(

	'id'=>'cms-page-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'summaryText'=>'',
        //'pager'=>'asd',
	'columns'=>array(
		/*'id',*/
                'title',
		/*'parent_id',*/
		'url',
                'layout',
		'name',
                'display',
		/*'header',
		'link_name',
		'keywords',
		'function',		
		'template',
		'seo_visible',
		'seo_unvisible',
		'param_1',
		'param_2',
		'txt',
		'button',
		'order',
		'editable',		
		*/
		array(
			'class'=>'CButtonColumn',
                    
		),
	),
)); 
?>
