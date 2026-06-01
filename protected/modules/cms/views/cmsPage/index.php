<?php
$this->breadcrumbs=array(
	'Strony',
);

//$this->menu=array(
//	array('label'=>'Stwórz nową stronę', 'url'=>array('create')),
//	array('label'=>'Zarządzaj stronami', 'url'=>array('admin')),
//);
?>

<h1>Strony</h1>

<?php
/*
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
*/
$this->redirect(array('cmsPage/create'));
?>
