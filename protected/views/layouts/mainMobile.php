<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){ ?>

    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/newPricesCss.css" />
    <script type="text/javascript">var activeRowMw="";</script>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />     
<?php
    Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl.'/js/jquery-mobile/jquery.mobile-1.4.5.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-mobile/jquery.mobile-1.4.5.min.js',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerCoreScript('yiiactiveform');
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
   
    $(function() {
    // WARNING: Extremely hacky code ahead. jQuery mobile automatically
    // sets the current \"page\" height on page resize. We need to unbind the
    // resize function ONLY and reset all pages back to auto min-height.
    // This is specific to jquery 1.8

    // First reset all pages to normal
    $('[data-role=\"page\"]').css('min-height', 'auto');

    // Is this the function we want to unbind?
    var check = function(func) {
        var f = func.toLocaleString ? func.toLocaleString() : func.toString();
        // func.name will catch unminified jquery mobile. otherwise see if
        // the function body contains two very suspect strings
        if(func.name === 'resetActivePageHeight' || (f.indexOf('padding-top') > -1 && f.indexOf('min-height'))) {
            return true;
        }
    };

    // First try to unbind the document pageshow event
    try {
        // This is a hack in jquery 1.8 to get events bound to a specific node
        var dHandlers = $._data(document).events.pageshow;

        for(x = 0; x < dHandlers.length; x++) {
            if(check(dHandlers[x].handler)) {
                $(document).unbind('pageshow', dHandlers[x]);
                break;
            }
        }
    } catch(e) {}

    // Then try to unbind the window handler
    try {
        var wHandlers = $._data(window).events.throttledresize;

        for(x = 0; x < wHandlers.length; x++) {
            if(check(wHandlers[x].handler)) {
                $(window).unbind('throttledresize', wHandlers[x]);
                break;
            }
        }
    } catch(e) {}
});
    $.mobile.resetActivePageHeight();
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
        ?>
    </title>
 
</head>
<body>
    <div id="content">
        <div class="width">
            <?php if(Yii::app()->user->hasFlash('mobileError')): ?>                    
                <div class="flash-error"><?php echo Yii::app()->user->getFlash('mobileError'); ?></div>
            <?php endif; ?>

                <?php 
                    if(Yii::app()->user->hasFlash('showBackButton')){
                        echo '<a href="'.Yii::app()->createUrl('mobile/mainMenu').'" data-role="button" data-theme="b" data-corners="false">Back to login menu</a>';
                    }
                ?>
                
            <?php echo $content; ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
           
            $("div.ui-collapsible-set").on( "collapsibleexpand", function(e) {
                calculateHeightOnAjax();
            });
            $("div.ui-collapsible-set").on( "collapsiblecollapse", function(e) {
                 
                 calculateHeightOnAjax();
            });
            $("a.ui-collapsible-heading-toggle").on( "click", function(e) {
               calculateHeightOnAjax();
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
        
        $(document).on('pagechange', function(){
            console.log('Page loaded');
           
            $('.ui-page').each(function(){
                if ($( this ).is(":visible") === true) { 
                    
                    visble_height = $( this ).find('#content').height()+30;
                    
                    console.log('class visible'+visble_height);
                    window.parent.setHeight(visble_height);
                }else {
                    un_visble_height = $( this ).height();
                }    
            });
           
            $("div.ui-collapsible-set").on( "collapsibleexpand", function(e) {
                window.parent.sendHeight();
            });
            $("div.ui-collapsible-set").on( "collapsiblecollapse", function(e) {
               
                window.parent.sendHeight();
            });
            
        });
        
        
        function calculateHeightOnAjax(){       
            console.log('Ajax action');
            console.log($(document).height());
           
            
            $('.ui-page').each(function(){
             
                if ($( this ).is(":visible") === true) { 
                    
                   
                    visble_height = $( this ).find('#content').height()+30;
                    
                    console.log('class visible'+visble_height);
                  
                    window.parent.setHeight(visble_height);
                }else {
                    un_visble_height = $( this ).height();
              
                }    
            });
            
        };
        
        function calculateHeightOnAjaxAddMore(addMore){       
            console.log('Ajax action add more');
            console.log($(document).height());
           
            
            $('.ui-page').each(function(){
             
                if ($( this ).is(":visible") === true) { 
                    
                   
                    visble_height = $( this ).find('#content').height()+30+addMore;
                    
                    console.log('class visible'+visble_height);
                  
                    window.parent.setHeight(visble_height);
                }else {
                    un_visble_height = $( this ).height();
              
                }    
            });            
        };
    
    </script>
</body>
<?php }else{ //website_type check end here ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="The Guide">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/newPricesCss.css" />
    <script type="text/javascript">var activeRowMw="";</script>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />     
        
    <link href="images/mobile/apple-touch-icon.png" rel="apple-touch-icon" />
    <link href="images/mobile/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
    <link href="images/mobile/apple-touch-icon-167x167.png" rel="apple-touch-icon" sizes="167x167" />
    <link href="images/mobile/apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="images/mobile/ic_192x192.png" rel="icon" sizes="192x192" />
    <link href="images/mobile/ic_128x128.png" rel="icon" sizes="128x128" />
        
<?php

    Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl.'/css/themes/yel_amended.css');

    Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl.'/css/themes/jquery.mobile.icons.min.css');

    Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl.'/css/themes/jquery.mobile.structure-1.4.5.min.css');

    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-mobile/jquery.mobile-1.4.5.min.js',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerCoreScript('yiiactiveform');

    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/add-to-homescreen-master/src/addtohomescreen.min.js',CClientScript::POS_HEAD);
    Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl.'/js/add-to-homescreen-master/style/addtohomescreen.css');
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl.'/css/themes/custom_app.css');

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
                /*
                $.cookiesDirective({
                    explicitConsent: true,
                    linkClass: 'tandc cbox cboxElement',
                    privacyPolicyUri: '#',
                    duration: 3600,
                    fontSize: '15px',
                    fontColor: '#68b5c2',
                    linkColor: '#3388cc'
                });   
   */

            })"
    ,CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.cookiesdirective.js',CClientScript::POS_HEAD);
?>
        
	<title>The Guide</title>
 
</head>
<body>
    <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-98339662-1', 'auto');
          ga('send', 'pageview');

    </script>
    
        
         <div id="content">
             <div class="width">
                 
                <?php if(Yii::app()->user->hasFlash('mobileError')): ?>                    
                    <div class="flash-error"><?php echo Yii::app()->user->getFlash('mobileError'); ?></div>
                <?php endif; ?>

                    <?php 
                        if(Yii::app()->user->hasFlash('showBackButton')){
                        }
                    ?>
                 
               <!--header-->
            <div class="topBar">
                <!-- Lead story block -->
                <div class="ui-block-a">
                    <div class="ui-body ui-body-b">
                        <?php if(!Yii::app()->user->isGuest){?>
                        <a href="#leftpanelMenu"><img class="leftIcon" src="images/mobile/menu.png"/></a>
                        <?php }else { ?>
                            <img class="leftIcon" src="images/mobile/empty.png"/>
                        <?php 
                        }
                        ?>
                    </div>
                </div>
                <!-- secondary story block #1 -->
                <div class="ui-block-b">
                    <div class="ui-body ui-body-b">
                        <img class="centerIcon" src="images/mobile/logo.png"/>
                    </div>
                </div>
                <!-- secondary story block #2 -->
                <div class="ui-block-c">
                    <div class="ui-body ui-body-b">
                        <img class="rightIcon" src="images/mobile/guide.png"/>
                    </div>
                </div>
            </div>
            <div data-role="panel" id="leftpanelMenu">
                <ul data-role="listview">
                    <li data-shadow="false" data-icon="false" data-theme="none"><a data-shadow="false" data-icon="false" data-theme="none" href="<?php echo Yii::app()->createUrl('mobile/gSelectReg');?>">Search By REG</a></li>
                    <li data-shadow="false" data-icon="false" data-theme="none"><a data-shadow="false" data-icon="false" data-theme="none" href="<?php echo Yii::app()->createUrl('mobile/gSelectMake');?>">Search By MAKE/MODEL</a></li>
                    <li data-shadow="false" data-icon="false" data-theme="none"><a data-shadow="false" data-icon="false" data-theme="none" href="<?php echo Yii::app()->createUrl('mobile/newPrices');?>">Current NEW Prices</a></li>
                    <li data-shadow="false" data-icon="false" data-theme="none"><a data-shadow="false" data-icon="false" data-theme="none" href="<?php echo Yii::app()->createUrl('mobile/archive');?>">ARCHIVE – By Make/Model</a></li>

                    <li data-shadow="false" data-icon="false" data-theme="none"><a data-shadow="false" data-icon="false" data-theme="none" href="<?=Yii::app()->params['pdf_passenger']?>" target="_blank" >PDF – Passenger</a></li>
                    <li data-shadow="false" data-icon="false" data-theme="none"><a data-shadow="false" data-icon="false" data-theme="none" href="<?=Yii::app()->params['pdf_commercial']?>" target="_blank" >PDF – Light Commercial</a></li>

                    <!-- <li data-shadow="false" data-icon="false" data-theme="none"><a data-shadow="false" data-icon="false" data-theme="none" href="#" onclick="openModal()">Conditions of Supply</a></li> -->
                    <li data-shadow="false" data-icon="false" data-theme="none"><a data-shadow="false" data-icon="false" data-theme="none" href="#" onclick="openCondSuppyDetails('Subscriptions are accepted and access to theguide.ie mobile app is granted under the following conditions:','Use of theguide.ie mobile app is for the sole purpose of the assigned user.<br/>That the proprietors have the right to decline, without explanation of any kind, any application or renewal requests.<br/>New subscriptions and renewals are accepted for a full 12-month period, unless otherwise agreed in writing. No refunds wholly or in part are available for cancellations after the first 90 days.<br/>That, while every care is taken by the proprietors to ensure accuracy of values contained in theguide.ie mobile app, no responsibility of any kind can be accepted for any opinions, errors or omissions.')">Conditions of Supply</a></li>
                    <li data-shadow="false" data-icon="false" data-theme="none"><a data-shadow="false" data-icon="false" data-theme="none" data-rel="close" href="#">Close Menu</a></li>
                </ul>
				
                <?php 
                    $user = Uzytkownik::model()->findbyPk(Yii::app()->user->id);
                    if($user){
                        echo '<div class="left_pannel_email"><br/>Logged in as '.$user->email.'</div>';
                    }
                ?>
            </div><!-- /panel -->
               <!--header-->
            <div class="ui-content">
            <?php echo $content; 
            if (Yii::app()->user->isGuest) {
            
                echo '<div class="guide_footer"><div class="footer_left"><strong>GDPR:</strong> “We may collect and store information that you have provided to us at any stage in the past, which includes but is not limited to your name, address, email address, phone numbers and company VAT number. This information is collected and handled by Motor Trade Publishers (mtp.ie) and is to be governed by Irish Law. We sometimes use your personal information to help with a query you may have with your online account with this site. We provide you with a password to this site and you are responsible for ensuring its confidentiality. The password must not be shared. We store cookies on your computer and/or mobile device for the purpose of recognising you upon logging in and in order to secure our site from unauthorised access. If any subscriber is found to be in contravention of this rule, we withhold the right to deny future access and will close your account. We do not guarantee the security of the email address you provide us with but we take measures to store this information on secure servers and through a recognised internet host and security provider.”</div><div class="footer_right col-4">Powered by Motor Trade Publishers<br/>Contact: <a href="mailto:info@mtp.ie">info@mtp.ie</a></div></div>';
            }else{
                echo '<div class="guide_footer"><div class="footer_right">Powered by Motor Trade Publishers<br/>Contact: <a href="mailto:info@mtp.ie">info@mtp.ie</a></div>';
            }
            ?>
                <br/>
            </div> 
             </div>
         </div>
		 
		 
		<div class="popup_box" id="Modal_box" style="display:none;">
			<div class="popup_dialog">
				<div class="popup_content">
					<span class="close_btn" onclick="closeModal();">×</span>
					<h6>Subscriptions are accepted and access to theguide.ie mobile app is granted under the following conditions:</h6>
					<p>Use of theguide.ie mobile app is for the sole purpose of the assigned user.<br/>
					That the proprietors have the right to decline, without explanation of any kind, any application or renewal requests.<br/>
					New subscriptions and renewals are accepted for a full 12-month period, unless otherwise agreed in writing. No refunds wholly or in part are available for cancellations after the first 90 days.<br/>
					That, while every care is taken by the proprietors to ensure accuracy of values contained in theguide.ie mobile app, no responsibility of any kind can be accepted for any opinions, errors or omissions.</p>
				</div>
			</div>
		</div>
        
    <script>
        $(document).on("pageinit", function () {	
          $("[data-role=panel] a").on("click", function () {
                if($.mobile && $(this).attr("href") == $.mobile.activePage.data('url')) {
                  $("[data-role=panel]").panel("close");
                }
            });
        });
		
		// popup_box Show hide
		function openModal() {
		  var x = document.getElementById("Modal_box");
		  if (x.style.display === "none") {
			x.style.display = "block";
		  } else {
			x.style.display = "none";
		  }
		}
		function closeModal() {
		  var x = document.getElementById("Modal_box");
		  if (x.style.display === "block") {
			x.style.display = "none";
		  }
		}
	</script>
<?php 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/numeric/jquery.numeric-min.js',CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/pages/mobile/common.js',CClientScript::POS_HEAD);
?>
</body>
<?php }//website_type check?>
</html>