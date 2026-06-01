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
              <?php echo CHtml::hiddenField('isstandalone', '0', array('id'=>'isstandalone')); ?>
            </label>
            <label>
              <?php echo $form->passwordField($model,'password', array('placeholder'=>'Password')); ?>
            </label>
            <div class="btn_centre button-circle login-pge">
				<button class="buttonLogin" onclick="submitForm()" id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none">GO</button>
			</div>
            <!-- <img class="buttonLogin" onclick="submitForm()" id="carGo" 
        data-role="button" src="images/mobile/login.png" data-shadow="false" data-iconpos="notext" data-theme="none" /> -->
            <!--<p><?php echo CHtml::submitButton('Login', array('class'=>'button small dw-yellow', 'role'=>'button' )); ?></p>-->
                       <?php //echo Yii::app()->request->baseUrl ?>
        </div>
        
    </div>
    
</div>
<style>
.error{
    color: #D8000C;
    padding: 0;
    margin: 0;
    font-size: 14px;
}
</style>
<script type="text/javascript">
   // $('#content').trigger('create');
    //isstandalone
    standalone = window.navigator.standalone;
    if(standalone == true){
        $('#isstandalone').val(1);
    }
    //alert(standalone);

function validateEmail( email ) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return email.match( re );
}

function submitForm( ) { 
    $( '.error' ).remove( );
    $email = $( '#LoginForm_login' ).val( ).trim( );
    $password = $( '#LoginForm_password' ).val( );
    if( !$email ) { 
        $( '<p class="error">Please enter email.</p>' ).insertAfter( $( '#LoginForm_login' ).parent() );
    } else if( !validateEmail( $email ) ) { 
        $( '<p class="error">Please enter valid email.</p>' ).insertAfter( $( '#LoginForm_login' ).parent() );
    }

    if( !$password ) { 
        $( '<p class="error">Please enter password.</p>' ).insertAfter( $( '#LoginForm_password' ).parent() );
    }

    if( $( '#login-form' ).find( '.error' ).length > 0 ) return false;
    $('#login-form').submit();
}
</script>

<?php $this->endWidget(); ?>
<!-- <div class="medium-8 medium-centered large-8 large-centered columns">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/FSk2m4boAkg" frameborder="0" allowfullscreen></iframe>
        </div>-->
<!--</div>-->
<!--<script src="<?php echo $baseUrl; ?>/js/vendor/jquery.min.js"></script>
<script src="<?php echo $baseUrl; ?>/js/vendor/what-input.min.js"></script>
<script src="<?php echo $baseUrl; ?>/js/foundation.min.js"></script>
<script src="<?php echo $baseUrl; ?>/js/app.js"></script>-->