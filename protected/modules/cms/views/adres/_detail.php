<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
                'adres.nazwa:text:Odbiorca',
		'adres.ulica_i_nr_lokalu:text:Ulica',
		'adres.kod_pocztowy:text:Kod pocztowy',
		'adres.miejscowosc:text:Miejscowość',
                'adres.kraj:text:Kraj',
                array('name'=>'domyslny', 'label'=>'Domyślny', 'value'=>$model->domyslny==1?'tak':'nie'),
	),
));
?>