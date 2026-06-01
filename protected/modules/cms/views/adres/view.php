<?php
$this->breadcrumbs=array(
	'Adres'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Edytuj', 'url'=>array('updateAdress', 'id'=>$model->id)),
	array('label'=>'Usuń', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Czy na pewno usunąć ten adres?')),
);
?>

<h1>View Adres #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
                'nazwa',
		'ulica_i_nr_lokalu',
		'kod_pocztowy',
		'miejscowosc',
                'kraj',
	),
)); ?>
