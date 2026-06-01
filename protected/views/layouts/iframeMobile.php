<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile.css" />
        <script type="text/javascript">var activeRowMw="";</script>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />     
      
<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl.'/js/jquery-mobile/jquery.mobile-1.4.5.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-mobile/jquery.mobile-1.4.5.min.js',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCoreScript('yiiactiveform');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery1.10.min.js',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCoreScript('jquery');


Yii::app()->clientScript->registerScript('my_script',"
            $(document).ready(function() {
                $('#login').focus(function() {
                    if($(this).val() == '') {
                        $(this).removeClass('login')
                    }
                }).blur(function() {
                      if($(this).val() == '') {
                        $(this).addClass('login')
                    } 
                })
                $('#pwd').focus(function() {
                    if($(this).val() == '') {
                        $(this).removeClass('pwd')
                    }
                }).blur(function() {
                      if($(this).val() == '') {
                        $(this).addClass('pwd')
                    } 
                })
                $.cookiesDirective({
                    explicitConsent: true,
                    linkClass: 'tandc cbox cboxElement',
                    privacyPolicyUri: '#',
                    duration: 3600,
                    fontSize: '15px',
                    fontColor: '#68b5c2',
                    linkColor: '#3388cc'
                });                
            })"
    ,CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.cookiesdirective.js',CClientScript::POS_HEAD);

?>
        
	<title><?php 
        if(isset($_GET['url'])) {
            $subTitle = CmsPage::model()->getElement('url', $_GET['url'], 'CmsPage', 'title');
            echo Yii::app()->name.' - '.$subTitle;//echo CHtml::encode($this->pageTitle);
        }else {
            echo Yii::app()->name;
        }
        ?></title>
 
</head>
<body>
        <!--<div id="header">
            <div class="width">
                <h1><a href="#"></a></h1>
            </div>
        </div>-->
        
         <div id="content">
             <div class="width">
                <?php if(Yii::app()->user->hasFlash('mobileError')): ?>                    
                    <div class="flash-error"><?php echo Yii::app()->user->getFlash('mobileError'); ?></div>
                <?php endif; ?>

                    <?php 
                        if(Yii::app()->user->hasFlash('showBackButton')){
                            echo '<a href="'.Yii::app()->createUrl('mobile/mainMenu').'" data-role="button" data-theme="b" data-corners="false">Back to main menu</a>';
                        }
                    ?>
                    
                <?php echo $content; ?>
             </div>
         </div>
        
    <div data-role="footer" class="ui-bar">    
        <div id="footer">
            <img src="images/logo3.png">
        </div>
        <div class="centered">
            <div class="width">
                <?php echo CmsDictionary::model()->dictionaryGetText('front_footer_address'); ?>
            </div>
            <div class="width" style="padding-left:25px;">
               <?php echo CmsDictionary::model()->dictionaryGetText('front_footer_phone'); ?>   
               <br /><?php echo CmsDictionary::model()->dictionaryGetText('front_footer_email'); ?>    
            </div>
        </div>
    </div>

</body>
</html>