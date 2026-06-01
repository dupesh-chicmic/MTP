<?php
$this->breadcrumbs=array(
	'Pracownicy'=>array('/'),
	'Wyszukiwanie',
);

$menu_admin=array();
if(Yii::app()->user->isAdmin)
{
    $menu_admin=array(array('label'=>'Dodaj pracownika', 'url'=>array('createEmployee')),
	array('label'=>'Wyszukaj pracownika', 'url'=>array('adminEmployee')));
}

$this->menu=array_merge($menu_admin, array(
	
        array('label'=>'Dodaj klienta', 'url'=>array('createCustomer')),
	array('label'=>'Wyszukaj klienta', 'url'=>array('adminCustomer')),
));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pracownik-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Wyszukiwanie pracowników</h1>

<p>
Opcjonalnie możesz użyć operatorów porównania (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
lub <b>=</b>) na początku każdego ciągu poszukiwania.
</p>

<?php echo CHtml::link('Zaawansowane wyszukiwanie','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_searchEmployee',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pracownik-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'cssFile'=> $this->module->assetsUrl.'/css/frontGrid.css',
	'columns'=>array(
		'id_uzytkownika',
                'uzytkownik.login',
                'uzytkownik.nazwisko',
                'uzytkownik.imie',
                'data_zatrudnienia',
                'data_urodzenia',
		array(
      'class'=>'CButtonColumn',
      'viewButtonUrl'=>'Yii::app()->createUrl("/employee/viewEmployee", array("id" => $data->id_uzytkownika))',
      'deleteButtonUrl'=>'Yii::app()->createUrl("/employee/deleteEmployee", array("id" => $data->id_uzytkownika))',
      'updateButtonUrl'=>'Yii::app()->createUrl("/employee/updateEmployee", array("id" => $data->id_uzytkownika))',
    'deleteButtonOptions'=>array('style'=>'display:none')
                    ),

	),
)); ?>
