<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nazwa_pelna')); ?>:</b>
	<?php echo CHtml::encode($data->nazwa_pelna); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nazwa_skrocona')); ?>:</b>
	<?php echo CHtml::encode($data->nazwa_skrocona); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nip')); ?>:</b>
	<?php echo CHtml::encode($data->nip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('regon')); ?>:</b>
	<?php echo CHtml::encode($data->regon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefon')); ?>:</b>
	<?php echo CHtml::encode($data->telefon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fax')); ?>:</b>
	<?php echo CHtml::encode($data->fax); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('typ_firmy')); ?>:</b>
	<?php echo CHtml::encode($data->typ_firmy); ?>
	<br />

	*/ ?>

</div>