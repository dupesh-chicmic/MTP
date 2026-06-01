<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
        <!--<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />-->
        <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE"/>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/js/vendor/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css" />
        
        
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout.css" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/embed.css" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foundation.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/app.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
        
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <script>var activeRowMw="";</script>
<?php
    Yii::app()->clientScript->scriptMap=array(
            'jquery.js'=>false,
            'jquery.min.js'=>false,
    );
?>         
        
        <!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery1.7.1.js" type="text/javascript"></script>-->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookiesdirective.js" type="text/javascript"></script>
        <script type="text/javascript">
//            $(document).ready(function() {
//                $.cookiesDirective({
//                    explicitConsent: true,
//                    //cookieScripts: 'Google Analytics',
//                    linkClass: 'tandc cbox cboxElement',
//                    privacyPolicyUri: '#',
//                    duration: 3600,
//                    fontSize: '15px',
//                    //message: 'Put own text here. ',
//                    linkColor: '#68b5c2',
//                    inputButtonStyle: ''
//                });
//            });
        </script>
  <?php //banner top ?>
        
                           <script language="javascript" src="<?php  echo Yii::app()->request->baseUrl; ?>/js/jquery.cycle.all.min.js"></script>
                           <script language="javascript">
                            $(document).ready(function($) {
                                $('.slideshow').cycle({
                                            fx: 'fade',// shuffle, etc...
                                            timeout: 5000,
                                            speed: 'slow',
//                                            cleartypeNoBg: true,
                                            next:   '#next', 
                                            prev:   '#prev', 
                                            pager:  '#panel' 
                                    });
                            //}
                                    
                            
//                            $(document).ready(function() {
//                                $('#s2').cycle({
//                                        fx:     'fade', 
//                                        speed:  'fast', 
//                                        timeout: 10000, 
//                                        next:   '#next2', 
//                                        prev:   '#prev2' 
//                                    });
                            });

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
            })
        </script>                           
                           
                           
<?php /* COLORBOX */ ?>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/colorbox.css" />
    <!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>-->
		<script language="javascript">
			$(document).ready(function(){						
				//$(".youtube").colorbox({iframe:true, innerWidth:425, innerHeight:344});                                
			});
		</script>
<?php /* --- */ ?>        
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/mtp.js"></script>
	<title><?php 
        if(isset($_GET['url'])){
            $subTitle = CmsPage::model()->getElement('url', $_GET['url'], 'CmsPage', 'title');
            echo Yii::app()->name.' - '.$subTitle;
        }else{
            echo Yii::app()->name;
        }
        ?></title>
 
</head>
<body>   
<script type="text/javascript">
var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33837535-1']);
  _gaq.push(['_trackPageview']);
(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>    
    
        <div id="content">
           <div class="width">
               <?php 
//                        if(Yii::app()->user->hasFlash('showBackButton')){
//                            echo '<a href="'.Yii::app()->createUrl('mobile/mainMenu').'" data-role="button" data-theme="b" data-corners="false">Back to main menu</a>';
//                        }
                    ?>
               <?php echo $content; ?>
           </div><!-- width -->
        </div><!--content -->


<!--<script src="<?php echo Yii::app()->request->baseUrl ?>/js/vendor/jquery.min.js"></script>-->

<script src="<?php echo Yii::app()->request->baseUrl ?>/js/vendor/what-input.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/js/foundation.min.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl ?>/js/app.js"></script>

 <script>
    $(document).ready(function() {

        $("div.ui-collapsible-set").on( "collapsibleexpand", function(e) {
            window.parent.sendHeight();
        });
        $("div.ui-collapsible-set").on( "collapsiblecollapse", function(e) {
            window.parent.sendHeight();
        });
        $(document).click(function(e) {
            window.parent.sendHeight();
        });
        $('select').change(function(e) {
            window.parent.sendHeight();
        });
        $('#ajaxUpdateDiv').bind('DOMSubtreeModified', function() {
            window.parent.sendHeight();
        });
    });
    </script>
</body>
</html>