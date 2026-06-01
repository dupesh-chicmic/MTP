<?php
$this->breadcrumbs=array(
	'Klienci'=>array('indexCustomer'),
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
	$.fn.yiiGridView.update('klient-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Wyszukiwanie klienta</h1>

<p>
Opcjonalnie możesz użyć operatorów porównania (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
lub <b>=</b>) na początku każdego ciągu poszukiwania.
</p>

<?php echo CHtml::link('Zaawansowane wyszukiwanie','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_searchCustomer',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'klient-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'id_uzytkownika',
		'uzytkownik.login',
		'uzytkownik.nazwisko',
		'uzytkownik.imie',
		'tel',		
		array(
                    'class'=>'CButtonColumn',
                    'viewButtonUrl'=>'Yii::app()->createUrl("/employee/viewCustomer", array("id" => $data->id_uzytkownika))',
                    'deleteButtonUrl'=>'Yii::app()->createUrl("/employee/deleteCustomer", array("id" => $data->id_uzytkownika))',
                    'updateButtonUrl'=>'Yii::app()->createUrl("/employee/updateCustomer", array("id" => $data->id_uzytkownika))',
                    'deleteButtonOptions'=>array('style'=>'display:none')
		),
	),
)); ?>
