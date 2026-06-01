<?php
$this->breadcrumbs=array(
	'Użytkownicy'=>array('indexEmployee'),
	$model->uzytkownik->login=>array('viewEmployee','id'=>$model->pracownik->id_uzytkownika),
	'Aktualizacja danych',
);
$menu_admin=array();
if(Yii::app()->user->isAdmin)
{
    $menu_admin=array(array('label'=>'Dodaj pracownika', 'url'=>array('createEmployee')),
	array('label'=>'Wyszukaj pracownika', 'url'=>array('adminEmployee')));
}

$this->menu=array_merge($menu_admin, array(
	array('label'=>'Pokaż szczegółowe dane pracownika', 'url'=>array('viewEmployee', 'id'=>$model->pracownik->id_uzytkownika)),
	array('label'=>'Szukaj pracownika', 'url'=>array('adminEmployee')),
));
?>

<h1>Aktualizacja danych pracownika: <?php echo $model->pracownik->getName(); ?></h1>

<?php echo $this->renderPartial('_formEmployee', array('model'=>$model)); ?>