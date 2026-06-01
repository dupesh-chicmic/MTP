<div class="view">

	<b><?php
        echo CHtml::encode($data->getAttributeLabel('id_uzytkownika')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_uzytkownika), array('viewEmployee', 'id'=>$data->id_uzytkownika)); ?>
	<br />

	<b><?php echo CHtml::encode($data->uzytkownik->getAttributeLabel('login')); ?>:</b>
	<?php echo CHtml::encode($data->uzytkownik->login); ?>
	<br />

	<b><?php echo CHtml::encode($data->uzytkownik->getAttributeLabel('imie')); ?>:</b>
	<?php echo CHtml::encode($data->uzytkownik->imie); ?>
	<br />

	<b><?php echo CHtml::encode($data->uzytkownik->getAttributeLabel('nazwisko')); ?>:</b>
	<?php echo CHtml::encode($data->uzytkownik->nazwisko); ?>
	<br />

	<b><?php echo CHtml::encode($data->uzytkownik->getAttributeLabel('ostatnie_nieudane_logowanie')); ?>:</b>
	<?php echo CHtml::encode($data->uzytkownik->ostatnie_nieudane_logowanie); ?>
	<br />

	

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('typ_konta_uzytkownika')); ?>:</b>
	<?php echo CHtml::encode($data->typ_konta_uzytkownika); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pelna_nazwa_firmy')); ?>:</b>
	<?php echo CHtml::encode($data->pelna_nazwa_firmy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ulica_i_nr_lokalu')); ?>:</b>
	<?php echo CHtml::encode($data->ulica_i_nr_lokalu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kod_pocztowy')); ?>:</b>
	<?php echo CHtml::encode($data->kod_pocztowy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('miejscowosc')); ?>:</b>
	<?php echo CHtml::encode($data->miejscowosc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nip')); ?>:</b>
	<?php echo CHtml::encode($data->nip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('regon')); ?>:</b>
	<?php echo CHtml::encode($data->regon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nr_telefonu')); ?>:</b>
	<?php echo CHtml::encode($data->nr_telefonu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nr_tel_kom')); ?>:</b>
	<?php echo CHtml::encode($data->nr_tel_kom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fax')); ?>:</b>
	<?php echo CHtml::encode($data->fax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('typ_klienta')); ?>:</b>
	<?php echo CHtml::encode($data->typ_klienta); ?>
	<br />

	*/ ?>

</div>