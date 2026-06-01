<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE"/>
	<!-- blueprint CSS framework -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" /> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" /> -->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin_style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-smoothness_css/jquery.ui.all.css" />
        
	<title><?php
            echo Yii::app()->name.' - CMS';
        ?></title>

<?php
/* --------------------- Skrypty dla wszystkich uzytkownikow --------------------- */          
  ?>

<?php /* JQuery */
    Yii::app()->clientScript->registerCoreScript('jquery.ui'); // automatycznie laduje jquery ?>

                    
        <?php /* Sortowanie galerii */
	echo '<style>
                #sortableGallery { list-style-type: none; margin: 0; padding: 0; }
                #sortableGallery li { float: left; width: 150px; height: 130px; font-size: small; text-align: center; border: 3px solid #EEEEEE; display: block; padding: 10px 5px; }
             </style>';
        
        /* TipTip */
        ?>
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/tiptip/tip.js" type="text/javascript"></script>
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/tiptip/tip.css" />
<!--            <script>
                $(function(){
                $(".tip").tipTip();
                });     
            </script>        -->
        <?php    
        
        /* GoogleMaps API */
        ?>
                <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<?php                
//                <style type="text/css">
//                   #container {font-size:15pt;}
//                   .iwstyle {font-size:20pt;}
//                   #map_canvas { height:500px; }
//                </style>
?>
<!--                <script type="text/javascript"
                    src="http://maps.google.com/maps/api/js?sensor=true">
                </script>-->
        <?php
        
        /* Kalendarz (datepicker JQueryUI)*/
        echo '<script src="'.Yii::app()->request->baseUrl.'/js/ui/jquery.ui.datepicker.min.js" type="text/javascript"></script>';        
        ?>
                <script>
                $(function() {
                        $( "#datepicker" ).datepicker({
                            altFormat: 'yy-mm-dd',
                            dateFormat: 'yy-mm-dd'
                        });
                });
                </script>        
        <?php
        
        /* Ustawianie kolejnosci (zakladka order) */
        echo '<style>
                #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
                #sortable li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em; }
                html>body #sortable li { height: 1.5em; line-height: 1.2em; }
                .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
        </style>';
?>

<?php
/* ----------------------------------------------------------------- */
?>

<link rel="Shortcut icon" href="./images/admin/qbix.png" />

</head>

<body onload="initialize();">

<div class="blackStripe"><div class="topBackground"></div> </div>    
    
    
<div id="wholeSite" class="siteWidth">
            <div class="blackStripe2">
                <div class="logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/admin/img/logo.png" alt="logo" /></div>
<?php

//            echo '<div id="languageMenu" class="siteWidth">';
//    echo '<b><i>Editing version</i></b>';
//    
//    if(isset($_GET['url'])){
//        $getLangUrl='index.php?r=cms/cmsPage/displayPage&url='.$_GET['url'].'';
//    }else{
//        $getLangUrl='index.php?r=cms/cmsPage/index';        
//    }              
//                     echo '<ul>';
//                     //Var_dump(Yii::app()->language);
//                        echo '<li>'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Choose language').'</li>';
//                        switch (Yii::app()->language){
//                              case 'pl':
//                                  echo '<li><a href="'.$getLangUrl.'&lang=pl"><img src="'.$this->assetsUrl.'/images/admin/img/icon1.png" alt="PL" /></a></li>';
//                                  echo '<li><a href="'.$getLangUrl.'&lang=en"><img src="'.$this->assetsUrl.'/images/admin/img/icon2.png" alt="GB" style="opacity:0.3;" /></a></li>'; //off
////                                  echo '<li><a href="'.$getLangUrl.'&lang=de"><img src="'.$this->assetsUrl.'/images/admin/img/icon3.png" alt="DE" style="opacity:0.3;" /></a></li>'; //off
//                                  break;
//                              case 'en':
//                                  echo '<li><a href="'.$getLangUrl.'&lang=pl"><img src="'.$this->assetsUrl.'/images/admin/img/icon1.png" alt="PL" style="opacity:0.3;" /></a></li>'; //off
//                                  echo '<li><a href="'.$getLangUrl.'&lang=en"><img src="'.$this->assetsUrl.'/images/admin/img/icon2.png" alt="GB" /></a></li>';
////                                  echo '<li><a href="'.$getLangUrl.'&lang=de"><img src="'.$this->assetsUrl.'/images/admin/img/icon3.png" alt="DE" style="opacity:0.3;" /></a></li>'; //off
//                                  break;
////                              case 'de':
////                                  echo '<li><a href="'.$getLangUrl.'&lang=pl"><img src="'.$this->assetsUrl.'/images/admin/img/icon1.png" alt="PL" style="opacity:0.3;" /></a></li>'; //off
////                                  echo '<li><a href="'.$getLangUrl.'&lang=en"><img src="'.$this->assetsUrl.'/images/admin/img/icon2.png" alt="GB" style="opacity:0.3;" /></a></li>'; //off
////                                  echo '<li><a href="'.$getLangUrl.'&lang=de"><img src="'.$this->assetsUrl.'/images/admin/img/icon3.png" alt="DE" /></a></li>';
////                                  break;                                  
//                              default: //off
//                                  echo '<li><a href="'.$getLangUrl.'&lang=pl"><img src="'.$this->assetsUrl.'/images/admin/img/icon1.png" alt="PL" style="opacity:0.3;" /></a></li>';
//                                  echo '<li><a href="'.$getLangUrl.'&lang=en"><img src="'.$this->assetsUrl.'/images/admin/img/icon2.png" alt="GB" style="opacity:0.3;" /></a></li>';
////                                  echo '<li><a href="'.$getLangUrl.'&lang=de"><img src="'.$this->assetsUrl.'/images/admin/img/icon3.png" alt="DE" style="opacity:0.3;" /></a></li>';
//                                  break;
//                        }                        
//                     echo '</ul>';
//
//                echo '</div>';
?>
        </div>
            
        <div id="header">
           <div class="menu">
               

               
		<?php
                    $criteria=new CDbCriteria;
                    $criteria->compare('parent_id', 3); // compare szuka * dla parent_id=3
                    $strony_z_bazy = CmsPage::model()->findAll($criteria);
                    
                    $menu = array();
                    foreach($strony_z_bazy as $page){
                        //guest
                        $GetUrl = CmsPage::model()->getURL($page['url']);
                        $menu[] = array('label'=>$page['link_name'], 'url'=>array('cmsPage/displayPage', 'url'=>$GetUrl), 'visible'=>Yii::app()->user->isGuest);                        
                    }

                    //uniwersalne elementy
                    $all_universal_element = CmsUniversal::model()->findAll();
//MUSI ROZROZNIAC CZY DISPLAY = 1 czyli find all by display = 1 
                    $menu_universal_element = array();
                    foreach($all_universal_element as $element){
                        $menu_universal_element[] = array( 'label'=>$element['menu_top_label_pl'], 'url'=>array('cmsUniversal/ViewUniversalElement', 'e'=>$element['table_name']) , 'visible'=>Yii::app()->user->isGuest);
                    }

                        // ladowanie pakietu jezykowego 
                        $page = Yii::t(Yii::app()->language.'_YiiTranslation', 'Pages');
                        $univElements = Yii::t(Yii::app()->language.'_YiiTranslation', 'Universal Elements');
                        $elements = Yii::t(Yii::app()->language.'_YiiTranslation', 'Elements');
                        $dictionary = Yii::t(Yii::app()->language.'_YiiTranslation', 'Dictionary');
                        $order = Yii::t(Yii::app()->language.'_YiiTranslation', 'Order');
                        $settings = Yii::t(Yii::app()->language.'_YiiTranslation', 'Settings');
                        $backup = Yii::t(Yii::app()->language.'_YiiTranslation', 'Backup DB');
                        $users = Yii::t(Yii::app()->language.'_YiiTranslation', 'Users');
                        $logout = 'Logout';//Yii::t(Yii::app()->language.'_YiiTranslation', 'Logout');     

                $menu_admin = array(
                                //admin
                                array('label'=>'<img src="/images/admin/img/icon_strony.png" /><br /> '.$page, 'url'=>array('cmsPage/index'), 'visible'=>!Yii::app()->user->isGuest,'icon'=>'/images/admin_ico/page.png' ),
                 //array('label'=>'<img class="navImage" src="./images/admin/addNew.png" /> Ogłoszenie', 'url'=>array('/cmsArticle/create'), 'visible'=>!Yii::app()->user->isGuest), //admin
                                //array('label'=>'Gallery', 'url'=>array('/cmsGallery/index'), 'visible'=>!Yii::app()->user->isGuest), //admin
                                //array('label'=>'Kategoria', 'url'=>array('cmsUniversal/modelElement&&e=CmsCategory&&id=0'), 'visible'=>!Yii::app()->user->isGuest), //su                                
                                array('label'=>'<img src="/images/admin/img/icon_elementy.png" /><br /> '.$elements, 'url'=>array('cmsUniversal/elements'), 'visible'=>!Yii::app()->user->isGuest), //admin
                                array('label'=>'<img src="/images/admin/img/icon_slownik.png" /><br /> '.$dictionary, 'url'=>array('cmsDictionary/index'), 'visible'=>!Yii::app()->user->isGuest), //admin
                                array('label'=>'<img src="/images/admin/img/icon_kolejnosc.png" /><br /> '.$order, 'url'=>array('cmsUniversal/order&&ord=CmsPage&&id=1'), 'visible'=>!Yii::app()->user->isGuest), //admin
                                array('label'=>'<img src="/images/admin/img/icon_universal_element.png" /><br /> '.$univElements, 'url'=>array('cmsUniversal/admin'), 'visible'=>Yii::app()->getUser()->getName() == 'su'), //su
                                array('label'=>'<img src="/images/admin/img/icon_users.png" /><br /> '.$users, 'url'=>'index.php?r=site/users', 'visible'=>!Yii::app()->user->isGuest),
                                //array('label'=>'<img src="'.$this->assetsUrl.'/images/admin/img/icon_kopia_bd.png" /><br /> '.$backup, 'url'=>array('cmsPage/backup'), 'visible'=>Yii::app()->getUser()->getName() == 'su'),
                                array('label'=>'<img src="/images/admin/img/settings.png" /><br /> '.$settings, 'url'=>array('site/settings'), 'visible'=>Yii::app()->getUser()->getName() == 'su'),
                                //all 
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'<img src="/images/admin/img/icon_wyloguj.png" /><br /> '.$logout, 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)                    
			);

                $menu = array_merge($menu, $menu_universal_element, $menu_admin);
                $this->widget('zii.widgets.CMenu',array(
			'items'=>$menu,
                        'encodeLabel'=>false,
		)); ?>               
               
            </div>
        </div>
    
                    
                    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                            'links'=>$this->breadcrumbs,
                    )); ?>       
                
    
<?php echo $content; ?>

            <div class="stripe"><span class="copyright">Copyright © <?php echo date('Y'); ?> by Qbix-Soft</span><span class="info"> Powered by Yii Framework.</span></div>         
        </div>


<div class="pageBackground"></div>


</body>
</html>