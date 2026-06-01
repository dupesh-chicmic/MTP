<?php
$baseUrl=Yii::app()->request->baseUrl;
$user=Yii::app()->user;
?>
<!--<div style="height:400px; display:block;">-->
<!--<link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/foundation.css" />
<link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/app.css" />
<link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/style.css" />-->

<!--uncomment if want to show the logo on the login-->
<div class="row">
    <div class="large-12 columns login-logo">
        <!--<img alt="logo" data-interchange="[<?php //echo $baseUrl; ?>/images/logo_small.png, small], [<?php //echo $baseUrl; ?>/images/logo_large.png, large]">-->
    </div>
</div>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'action'=>Yii::app()->createUrl('site/register'),
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
 )); ?>

<div class="row topPadding">
    <div class="small- 12 medium-6 medium-centered large-4 large-centered columns">
      
        <div class="row column log-in-form">
            <?php if(!empty($msg)){
                    echo $msg;
                }
            ?>
            <label>
              <?php echo $form->textField($model,'login', array('placeholder'=>'Email')); ?>
            </label>
            
            
            <p><?php echo CHtml::submitButton('Register your interest', array('class'=>'button small dw-yellow', 'role'=>'button' )); ?></p>
                       <?php //echo Yii::app()->request->baseUrl ?>
        </div>
        
    </div>
    
</div>


<?php $this->endWidget(); ?>
<!-- <div class="medium-8 medium-centered large-8 large-centered columns">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/FSk2m4boAkg" frameborder="0" allowfullscreen></iframe>
        </div>-->
<!--</div>-->
<!--<script src="<?php echo $baseUrl; ?>/js/vendor/jquery.min.js"></script>
<script src="<?php echo $baseUrl; ?>/js/vendor/what-input.min.js"></script>
<script src="<?php echo $baseUrl; ?>/js/foundation.min.js"></script>
<script src="<?php echo $baseUrl; ?>/js/app.js"></script>-->