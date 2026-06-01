<?php
$this->breadcrumbs=array(
	'Pracownicy'=>array('/'),
	'Tworzenie konta klienta',
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
?>

<?php echo $this->renderPartial('/site/newCustomer', array('model'=>$model)); ?>