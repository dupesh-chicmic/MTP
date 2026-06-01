<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cms-universal-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><span class="requiredText"><?php echo Yii::t(Yii::app()->language.'_YiiTranslation', 'Fields with * are required'); ?></span></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'table_name'); ?>
		<?php echo $form->textField($model,'table_name',array('size'=>60,'maxlength'=>100)); ?>
            
            <?php 
                //if($model->isNewRecord){
                    echo '<br /><a href="index.php?r=gii" target="_blank" style="font-weight:bolder; color:#4E9258;">'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Generate model in Gii').'</a>';
                //}
            ?>
		<?php echo $form->error($model,'table_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menu_top_label_pl'); ?>
		<?php echo $form->textField($model,'menu_top_label_pl',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'menu_top_label_pl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menu_top_label_en'); ?>
		<?php echo $form->textField($model,'menu_top_label_en',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'menu_top_label_en'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'field_to_display'); ?>
		<?php echo $form->textField($model,'field_to_display',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'field_to_display'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group'); ?>
		<?php echo $form->textField($model,'group'); ?>
		<?php echo $form->error($model,'group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_label'); ?>
		<?php echo $form->textField($model,'group_label',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'group_label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'label_replace'); ?>
		<?php echo $form->textField($model,'label_replace',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'label_replace'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'layout'); ?>
            <!--
		<?php echo $form->textField($model,'layout',array('size'=>60,'maxlength'=>100)); ?>
            -->
                <?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`name`';
                    //public static string dropDownList(string $name, string $select, array $data, array $htmlOptions=array ( ))                    
                    echo $form->dropDownList($model,'layout', array('list'=>'List', 'list_wide'=>'List wide', 'detail'=>'Detail', 'detail_wide'=>'Detail wide', 'mini_list'=>'Mini list') );
                ?>

		<?php echo $form->error($model,'layout'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'display'); ?>
		<?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`txt`';
                    echo $form->dropDownList($model,'display',array(Yii::t(Yii::app()->language.'_YiiTranslation', 'Yes'),Yii::t(Yii::app()->language.'_YiiTranslation', 'No')));
                ?>
		<?php echo $form->error($model,'display'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'view_list'); ?>
		<?php echo $form->textField($model,'view_list',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'view_list'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'view_details'); ?>
		<?php echo $form->textField($model,'view_details',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'view_details'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'help'); ?>
		<?php echo $form->textField($model,'help'); ?>
		<?php echo $form->error($model,'help'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deletable'); ?>
		<?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`txt`';

                    //W 'select_yes_no' - podajemy grupe , value - przy select z grupy (jesli w select_yes_no value =0 to pole editable = 0) , txt - po czym ma listowac
                    //Value musi byc za kazdym razem inne
                    echo $form->dropDownList($model,'deletable',array(Yii::t(Yii::app()->language.'_YiiTranslation', 'Yes'),Yii::t(Yii::app()->language.'_YiiTranslation', 'No')));
                ?>
		<?php echo $form->error($model,'deletable'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_display'); ?>
		<?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`txt`';

                    //W 'select_yes_no' - podajemy grupe , value - przy select z grupy (jesli w select_yes_no value =0 to pole editable = 0) , txt - po czym ma listowac
                    //Value musi byc za kazdym razem inne
                    echo $form->dropDownList($model,'admin_display',array(Yii::t(Yii::app()->language.'_YiiTranslation', 'Yes'),Yii::t(Yii::app()->language.'_YiiTranslation', 'No')));
                ?>
		<?php echo $form->error($model,'admin_display'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_by'); ?>
		<?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`txt`';

                    //W 'select_yes_no' - podajemy grupe , value - przy select z grupy (jesli w select_yes_no value =0 to pole editable = 0) , txt - po czym ma listowac
                    //Value musi byc za kazdym razem inne
                    echo $form->dropDownList($model,'order_by',array(Yii::t(Yii::app()->language.'_YiiTranslation', 'First'),Yii::t(Yii::app()->language.'_YiiTranslation', 'Last')));
                ?>
		<?php echo $form->error($model,'order_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'db_tbl_name'); ?>
		<?php echo $form->textField($model,'db_tbl_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'db_tbl_name'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'orderable'); ?>
		<?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`txt`';

                    //W 'select_yes_no' - podajemy grupe , value - przy select z grupy (jesli w select_yes_no value =0 to pole editable = 0) , txt - po czym ma listowac
                    //Value musi byc za kazdym razem inne
                    echo $form->dropDownList($model,'orderable',array(Yii::t(Yii::app()->language.'_YiiTranslation', 'Yes'),Yii::t(Yii::app()->language.'_YiiTranslation', 'No')));
                ?>
		<?php echo $form->error($model,'orderable'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t(Yii::app()->language.'_YiiTranslation', 'Create') : Yii::t(Yii::app()->language.'_YiiTranslation', 'Update')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->