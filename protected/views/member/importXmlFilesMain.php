<div class="form">
<br />
<?php
if(Yii::app()->user->isAdmin || Yii::app()->user->isSu()){

    if(Yii::app()->user->hasFlash('importXmlError')){
        echo '<div class="flash-error">';
        echo Yii::app()->user->getFlash('importXmlError');
        echo '</div>';
    }
    if(Yii::app()->user->hasFlash('importXmlSuccess')){
        echo '<div class="flash-success">';
        echo Yii::app()->user->getFlash('importXmlSuccess');
        echo '</div>';
    }

echo CHtml::beginForm(array('member/importXmlFiles'));
?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    
    <fieldset title="Import XML files">
    <legend>Import XML files</legend>    
    <div class="row">    
    <div class="input-group">
      <span class="input-group-addon" style="min-width: 180px;"><?php echo CHtml::Label('Title: * ','my_name'); ?></span>
      
      <?php echo CHtml::textField('my_name', '', array('class'=>'form-control')); ?>
    </div>
    </div>
    
    <div class="row">    
    <div class="input-group">
      <span class="input-group-addon" style="min-width: 180px;"><?php echo CHtml::Label('Date: * ','my_date',array('class'=>'labelMyDate')); ?></span>
      <?php    
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name'=>'my_date',
                'language'=>Yii::app()->language,
                'options'=>array(
                      'showAnim'=>'fold',
                      'dateFormat'=>'yy-mm-dd',        
                ),
                'htmlOptions'=>array(
                    'class'=>'form-control'
                ), 
          )); 
        ?>
    </div>
    </div>
    
    <div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo CHtml::Label('Used Cars - Cars','usedCarsCars'); ?></span>
        <div class="form-control"><?php echo CHtml::CheckBox('usedCarsCars',true, array('value'=>'1','disabled'=>'disabled')); ?></div>
        </div>
    </div>
    <div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo CHtml::Label('Used Cars - Commercial','usedCarsCom'); ?></span>
        <div class="form-control"><?php echo CHtml::CheckBox('usedCarsCom',false); ?></div>
        </div>
    </div>
    
    <div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo CHtml::Label('Kms Bands','kmsBand'); ?></span>
        <div class="form-control"><?php echo CHtml::CheckBox('kmsBand',true, array('disabled'=>'disabled')); ?></div>
        </div>
    </div>
    
    <div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo CHtml::Label('Petrol Bands','petrol'); ?></span>
        <div class="form-control"><?php echo CHtml::CheckBox('petrol',true, array('disabled'=>'disabled')); ?></div>
        </div>
    </div>
    <div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo CHtml::Label('Electric Bands','petrol'); ?></span>
        <div class="form-control"><?php echo CHtml::CheckBox('electric',true, array('disabled'=>'disabled')); ?></div>
        </div>
    </div>
    
    <div class="row">
        <div class="input-group">
        <span class="input-group-addon" style="min-width: 180px;"><?php echo CHtml::Label('Diesel Bands','diesel'); ?></span>
        <div class="form-control"><?php echo CHtml::CheckBox('diesel',true, array('disabled'=>'disabled')); ?></div>
        </div>
    </div>
    
    </fieldset>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton('Import selected',array('class'=>'btn btn-primary')); ?>
	</div>
<?php echo CHtml::endForm(); ?>


<hr>
<a href="<?php echo Yii::app()->createUrl('member/deleteArchive'); ?>"><img src="./images/archive.png" />Delete archives</a>

<?php 
    } else { $this->redirect('index.php'); }   
?>
</div>