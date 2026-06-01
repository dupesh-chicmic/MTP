<?php
    //nie wyswietlam --main-- , menu_top i normal page
    if($data->id != 1 && $data->id !=2 && $data->id !=3){
?>
<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>
	<br />

    	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($data->id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent_id')); ?>:</b>
	<?php echo CHtml::encode($data->parent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('header')); ?>:</b>
	<?php echo CHtml::encode($data->header); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_name')); ?>:</b>
	<?php echo CHtml::encode($data->link_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('layout')); ?>:</b>
	<?php echo CHtml::encode($data->layout); ?>
	<br />
        
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('keywords')); ?>:</b>
	<?php echo CHtml::encode($data->keywords); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('function')); ?>:</b>
	<?php echo CHtml::encode($data->function); ?>
	<br />



	<b><?php echo CHtml::encode($data->getAttributeLabel('template')); ?>:</b>
	<?php echo CHtml::encode($data->template); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seo_visible')); ?>:</b>
	<?php echo CHtml::encode($data->seo_visible); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seo_unvisible')); ?>:</b>
	<?php echo CHtml::encode($data->seo_unvisible); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('param_1')); ?>:</b>
	<?php echo CHtml::encode($data->param_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('param_2')); ?>:</b>
	<?php echo CHtml::encode($data->param_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('txt')); ?>:</b>
	<?php echo CHtml::encode($data->txt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('button')); ?>:</b>
	<?php echo CHtml::encode($data->button); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order')); ?>:</b>
	<?php echo CHtml::encode($data->order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('editable')); ?>:</b>
	<?php echo CHtml::encode($data->editable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('display')); ?>:</b>
	<?php echo CHtml::encode($data->display); ?>
	<br />

	*/ ?>
              
</div>
<?php
    }
?>