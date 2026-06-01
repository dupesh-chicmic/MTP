<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
<!--        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />-->
        <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE"/>
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout.css" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=11; IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
        <script>var activeRowMw="";</script>
<?php
// ponizej laduje najnowsze jquery
    Yii::app()->clientScript->scriptMap=array(
            'jquery.js'=>false,
            'jquery.min.js'=>false,
    );
?>        
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery1.9.1.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.floatThead.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookiesdirective.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $.cookiesDirective({
                    explicitConsent: true,
                    //cookieScripts: 'Google Analytics',
                    linkClass: 'tandc cbox cboxElement',
                    privacyPolicyUri: '#',
                    duration: 3600,
                    fontSize: '15px',
                    //message: 'Put own text here. ',
                    linkColor: '#68b5c2',
                    inputButtonStyle: ''
                });
            });
        </script>        
  <?php //banner top ?>
         <script>
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
        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/colorbox.css" />
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
		<script language="javascript">
			$(document).ready(function(){						
				$(".youtube").colorbox({iframe:true, innerWidth:425, innerHeight:344});
			});
		</script>    
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/mtp.js"></script>
    
	<title><?php 
        if(isset($_GET['url'])){
            $subTitle = CmsPage::model()->getElement('url', $_GET['url'], 'CmsPage', 'title');
            echo Yii::app()->name.' - '.$subTitle;//echo CHtml::encode($this->pageTitle);
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
            <div id="headerContainer">
            <div id="header">
                <div class="width">
                    <h1><a href="index.php">Motor trade publishers</a></h1>
                    <?php $this->renderPartial('//site/_login'); ?>
                </div> <!-- width -->
            </div> <!-- header -->
        </div> <!-- headerContainer -->
        <div id="top" class="<?php echo Yii::app()->user->isGuest?'guest':'not_guest';?>">
        <div class="width">
                <?php $this->renderPartial('//site/_menuTop'); ?>
                <div class="social">
                    Follow us
                    <a target="_blank" href="<?php echo CmsDictionary::model()->dictionaryGetText('front_facebook'); ?>" class="pointer fb">facebook</a>
                    <a target="_blank" href="<?php echo CmsDictionary::model()->dictionaryGetText('front_twitter'); ?>"  class="pointer tw">twitter</a>
                    <a target="_blank" href="<?php echo CmsDictionary::model()->dictionaryGetText('front_linkedin'); ?>" class="pointer other">other</a>
                </div><!-- social -->
            </div> <!-- width -->
        </div><!-- top -->
        <div class="bannerBackground">
            <div class="width" style="*position: static !important;">
                <div class="banner2"></div>
            </div><!-- width -->
        </div><!-- bannerBackground -->
        
         <div id="content">
            <div class="width">
                <?php echo $content; ?>
            </div>
         </div> <!--content -->
            <div id="bottom">
            <div class="width">
                <h4>Contact us 
                    <span style="float:right; width: 188px;">
                        <?php echo CHtml::link('Terms & Conditions', '#', array('class'=>'tandc cbox','style'=>'color:#fff; text-decoration:none;')); ?>
                        <?php if(isset($this->id) && ($this->id=='realex')): ?>tandc cbox
                            <img style="height: 90px;" src="./images/3Dlogo.JPG" />
                        <?php endif; ?>
                    </span>
                </h4>

                <ul class="column">
                    <li>
                       <?php echo CmsDictionary::model()->dictionaryGetText('front_footer_address'); ?>
                    </li>
                    <li>
                      <?php echo CmsDictionary::model()->dictionaryGetText('front_footer_phone'); ?>   
                    </li>
                    <li>
                        <?php echo CmsDictionary::model()->dictionaryGetText('front_footer_email'); ?>    
                    </li>
                </ul>
                <ul class="bottomNav">
                </ul>
            </div> <!-- width -->
        </div><!-- bottom -->
        <div id="footer">
            <div class="width">
                 Copyright © <?php echo date('Y'); ?> Motor Trade Publishers
                <a href="#" class="logo"></a>
            </div><!-- width -->
        </div> <!-- footer -->
    
<?php $this->renderPartial('//realex/tandc'); ?>
</body>
</html>