<?php
$this->breadcrumbs=array(
        'Panel zarządzania',
	'Klienci',
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
        array('label'=>'Aktualne zamówienia', 'url'=>array('/zamowienie')),
        array('label'=>'Zarządzaj wysyłką', 'url'=>array('/wysylkaZamowienia/admin')),

));
?>

<h1>Lista klientów</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_viewCustomer',
)); ?>
