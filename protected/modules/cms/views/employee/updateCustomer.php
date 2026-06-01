<?php
$this->breadcrumbs=array(
	'Klienci'=>array('indexCustomer'),
	$model->uzytkownik->login=>array('viewCustomer','id'=>$model->klient->id_uzytkownika),
	'Aktualizacja danych',
);
$menu_admin=array();
if(Yii::app()->user->isAdmin)
{
    $menu_admin=array(array('label'=>'Dodaj pracownika', 'url'=>array('createEmployee')),
	array('label'=>'Wyszukaj pracownika', 'url'=>array('adminEmployee')));
}

$this->menu=array_merge($menu_admin, array(
	array('label'=>'Pokaż szczegółowe dane klienta', 'url'=>array('viewCustomer', 'id'=>$model->klient->id_uzytkownika)),
	array('label'=>'Szukaj klienta', 'url'=>array('adminCustomer')),
));
?>

<h1>Aktualizacja danych klienta: <?php echo $model->klient->getName(); ?></h1>

<?php echo $this->renderPartial('/customer/_formPersonal', array('model'=>$model)); ?>