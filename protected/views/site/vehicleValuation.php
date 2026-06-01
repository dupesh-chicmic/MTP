<?php
//load tooltip
//Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl.'/js/tiptip/tip.css');
//Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/js/tiptip/tip.js');
//$script = '
//    $(function($){
//        $(".tiptip").tipTip({defaultPosition: "right", maxWidth: "auto", edgeOffset: 5});
//    });
//';
//Yii::app()->clientScript->registerScript('form',$script);
//Yii::app()->clientScript->reset(); 
//Yii::app()->clientScript->enableJavaScript = false;
//Yii::app()->clientScript->scriptMap=array(
//        'jquery.js'=>false,
//);
//$model->setScenario('withCaptcha');
//var_dump($model->scenario);
?>

<div class="backgroundTextPage">
<div id="contactPage" id="left">

<div class="form">

    <h1>Vehicle Valuation</h1>
    
<?php echo CHtml::beginForm(Yii::app()->createUrl('/site/saveValuation'),'POST'); ?>
 
    <p class="note"><span class="requiredText"><?php echo Yii::t(Yii::app()->language.'_YiiTranslation', 'Please submit information in as many fields below for greater accuracy of valuation. <br />Cost €3. A ‘Paypal’ request will be sent to you following receipt of vehicle details.<br />Fields marked with an * are required.'); ?></span></p>

<?php if(Yii::app()->user->hasFlash('errorValidation')){ ?>
    <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('errorValidation'); ?>
    </div>
<?php } ?>
    
    <div class="row">
        <?php echo CHtml::Label('Make*','make'); ?>
        <?php echo CHtml::textField('make', (empty($_POST['make'])?'':$_POST['make']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g. Ford',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>
    
    <div class="row">
        <?php echo CHtml::Label('Model*','model'); ?>
        <?php echo CHtml::textField('model', (empty($_POST['model'])?'':$_POST['model']),
                array('id'=>'model', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g. Focus',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>    

    <div class="row">
        <?php echo CHtml::Label('Type*','type'); ?>
        <?php echo CHtml::textField('type', (empty($_POST['type'])?'':$_POST['type']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g. ES, SE',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>

    <div class="row">
        <?php echo CHtml::Label('Year*','year'); ?>
        <?php echo CHtml::textField('year', (empty($_POST['year'])?'':$_POST['year']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g. 2010',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>    
    
    <div class="row">
        <?php echo CHtml::Label('Transmission*','transmission'); ?>
        <?php echo CHtml::textField('transmission', (empty($_POST['transmission'])?'':$_POST['transmission']),
                array('id'=>'transmission', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g. Manual or Auto',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>
    
    <div class="row">
        <?php echo CHtml::Label('Doors','doors'); ?>
        <?php echo CHtml::textField('doors', (empty($_POST['doors'])?'':$_POST['doors']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g. 4',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>
    
    <div class="row">
        <?php echo CHtml::Label('Body*','body'); ?>
        <?php echo CHtml::textField('body', (empty($_POST['body'])?'':$_POST['body']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g. Saloon or Hatch etc.',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>
    
    <div class="row">
        <?php echo CHtml::Label('Engine*','engine'); ?>
        <?php echo CHtml::textField('engine', (empty($_POST['engine'])?'':$_POST['engine']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g. 1.4, 1.6',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>
    
    <div class="row">
        <?php echo CHtml::Label('Fuel*','fuel'); ?>
        <?php echo CHtml::textField('fuel', (empty($_POST['fuel'])?'':$_POST['fuel']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g. Petrol',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>    
    
    <div class="row">
        <?php echo CHtml::Label('Odometer Reading*','odometer'); ?>
        <?php echo CHtml::textField('odometer', (empty($_POST['odometer'])?'':$_POST['odometer']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g. 54000',
                      'data-clear-btn'=>'true'
                    ));
        ?>        

    </div>
    
    <div class="row">
        <?php echo CHtml::Label('',''); ?>
        <?php echo CHtml::radioButtonList('odometer_radio','miles' ,array('miles'=>'Miles','kilometers'=>'Kilometres'), array('separator' => "  ")); ?>
    </div>
    
<!--    <div class="row">
        <?php //echo CHtml::Label('Year 1st Registered*','year_registered'); ?>
        <?php 
//            echo CHtml::textField('year_registered', (empty($_POST['year_registered'])?'':$_POST['year_registered']),
//                array('id'=>'make', 
//                      'width'=>100, 
//                      'maxlength'=>100,
//                      'class'=>'input1 tiptip',
//                      'title'=>'e.g. 2006'
//                    ));
        ?>
    </div>
    
    <div class="row">
        <?php //echo CHtml::Label('Month Registered','month_registered'); ?>
        <?php 
//            echo CHtml::textField('month_registered', (empty($_POST['month_registered'])?'':$_POST['month_registered']),
//                array('id'=>'make', 
//                      'width'=>100, 
//                      'maxlength'=>100,
//                      'class'=>'input1 tiptip',
//                      'title'=>'e.g. January'
//                    ));
        ?>
    </div>-->
    
    <div class="row">
        <?php echo CHtml::Label('Country 1st Registered*','country_registered'); ?>
        <?php echo CHtml::textField('country_registered', (empty($_POST['country_registered'])?'':$_POST['country_registered']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g. Ireland, England',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>    

    <div class="row">
        <?php echo CHtml::Label('Extras','extras'); ?>
        <?php echo CHtml::textArea('extras', (empty($_POST['extras'])?'':$_POST['extras']),
                array('id'=>'make', 
                      'rows'=>6, 
                      'cols'=>52,
                      'class'=>'textarea tiptip',
                      'title'=>'e.g. Alloys, Leather seats, Sunroof etc',
                    ));
        ?>
    </div>    
    
    <div class="row">
        <?php echo CHtml::Label('Valuation Date*','valuation_date'); ?>
        <?php echo CHtml::textField('valuation_date', (empty($_POST['valuation_date'])?'':$_POST['valuation_date']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'e.g July 2007 or June 2006 etc for a past valuation or today’s date if you require a current valuation.',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>    
    
    <div class="row">
        <?php echo CHtml::Label('Contact Name','contact_name'); ?>
        <?php echo CHtml::textField('contact_name', (empty($_POST['contact_name'])?'':$_POST['contact_name']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'Your name',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>    
    
    <div class="row">
        <?php echo CHtml::Label('Contact Email*','contact_email'); ?>
        <?php echo CHtml::textField('contact_email', (empty($_POST['contact_email'])?'':$_POST['contact_email']),
                array('id'=>'make', 
                      'width'=>100, 
                      'maxlength'=>100,
                      'class'=>'input1 tiptip',
                      'title'=>'Your email address',
                      'data-clear-btn'=>'true'
                    ));
        ?>
    </div>        

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<div class="verifyCode">
        <?php echo CHtml::Label('Verification Code*','verifyCode'); ?>
		<?php $this->widget('CCaptcha'); ?>
            <br /><br />
        <?php echo CHtml::Label('','verifyCode'); ?>
		<?php echo CHtml::activeTextField($model,'verifyCode', array('class'=>'input1')); ?>
		</div>
		<?php echo CHtml::error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit', array('class'=>'button1')); ?>
	</div>
 
<?php echo CHtml::endForm(); ?>

<?php echo CHtml::beginForm(Yii::app()->createUrl('/site/resetValuation'),'POST'); ?>    
    	<div class="row buttons">
		<?php echo CHtml::submitButton('Reset', array('class'=>'button1')); ?>
	</div>
<?php echo CHtml::endForm(); ?>
    
    
</div><!-- form -->
</div>
</div>
    
<div class="clear"></div>