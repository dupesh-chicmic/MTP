<?php
if(Yii::app()->user->isSu() == false){ //jest tylko adminem
    if ( CHtml::encode($data->client_editable) == 1){    
?>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->key), array('update', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('txt')); ?>:</b>
	<?php echo CHtml::encode($data->txt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actions')); ?>:</b>
	<?php echo CHtml::encode($data->actions); ?>
	<br />

</div>
<?php
    }//end if client_editable = 1
}else{ // jestem SU
?>
    <div class="view">


<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('key')); ?>:</b>
	<?php echo CHtml::encode($data->key); ?>
	<br />
-->
<!-- key link -->
	<b><?php echo CHtml::encode($data->getAttributeLabel('key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->key), array('update', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($data->id); ?>
	<br />
  
	<b><?php echo CHtml::encode($data->getAttributeLabel('txt')); ?>:</b>
	<?php echo CHtml::encode($data->txt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_editable')); ?>:</b>
	<?php echo CHtml::encode($data->client_editable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
	<?php echo CHtml::encode($data->value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group')); ?>:</b>
	<?php echo CHtml::encode($data->group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actions')); ?>:</b>
	<?php echo CHtml::encode($data->actions); ?>
	<br />

</div>
<?php
}// end else SU
?>