<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_uzytkownika')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_uzytkownika), array('viewCustomer', 'id'=>$data->id_uzytkownika)); ?>
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

      	<b><?php echo CHtml::encode($data->getAttributeLabel('tel')); ?>:</b>
	<?php echo CHtml::encode($data->tel); ?>
	<br />

        
<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ulica')); ?>:</b>
	<?php echo CHtml::encode($data->ulica); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nr_lokalu')); ?>:</b>
	<?php echo CHtml::encode($data->nr_lokalu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kod_pocztowy')); ?>:</b>
	<?php echo CHtml::encode($data->kod_pocztowy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('miejscowosc')); ?>:</b>
	<?php echo CHtml::encode($data->miejscowosc); ?>
	<br />

	*/ ?>

</div>