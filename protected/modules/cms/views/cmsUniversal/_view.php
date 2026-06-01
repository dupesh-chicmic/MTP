<div class="view">


	<b><?php echo CHtml::encode($data->getAttributeLabel('table_name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->table_name), array('update', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
        <?php echo CHtml::encode($data->id); ?>
	<br />
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_top_label_pl')); ?>:</b>
	<?php echo CHtml::encode($data->menu_top_label_pl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_top_label_en')); ?>:</b>
	<?php echo CHtml::encode($data->menu_top_label_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('field_to_display')); ?>:</b>
	<?php echo CHtml::encode($data->field_to_display); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group')); ?>:</b>
	<?php echo CHtml::encode($data->group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group_label')); ?>:</b>
	<?php echo CHtml::encode($data->group_label); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('label_replace')); ?>:</b>
	<?php echo CHtml::encode($data->label_replace); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('layout')); ?>:</b>
	<?php echo CHtml::encode($data->layout); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('display')); ?>:</b>
	<?php echo CHtml::encode($data->display); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('view_list')); ?>:</b>
	<?php echo CHtml::encode($data->view_list); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('view_details')); ?>:</b>
	<?php echo CHtml::encode($data->view_details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('help')); ?>:</b>
	<?php echo CHtml::encode($data->help); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deletable')); ?>:</b>
	<?php echo CHtml::encode($data->deletable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_display')); ?>:</b>
	<?php echo CHtml::encode($data->admin_display); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_by')); ?>:</b>
	<?php echo CHtml::encode($data->order_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('db_tbl_name')); ?>:</b>
        <?php echo CHtml::encode($data->db_tbl_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orderable')); ?>:</b>
	<?php echo CHtml::encode($data->orderable); ?>
	<br />
         *
	*/ ?>

</div>