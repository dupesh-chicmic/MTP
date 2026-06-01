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
        
	<title><?php 
        if(isset($_GET['url'])){
            $subTitle = CmsPage::model()->getElement('url', $_GET['url'], 'CmsPage', 'title');
            echo Yii::app()->name.' - '.$subTitle;//echo CHtml::encode($this->pageTitle);
        }else{
            echo Yii::app()->name;
        }
        ?></title>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js/bootstrap/css/bootstrap.min.css');  
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap/js/bootstrap.min.js');
?>
</head>
<body style="background-color:#ffffff;">  
            <div id="headerContainer">
            <div id="header">
                <div class="width">
                    <h1 style="display: inline;"><a href="index.php">Motor trade publishers</a></h1>
                </div> <!-- width -->
            </div> <!-- header -->
        </div> <!-- headerContainer -->
        <div id="top" class="<?php echo Yii::app()->user->isGuest?'guest':'not_guest';?>">
            <div class="width">
            <ul id="nav">
                <li><a href="<?php echo Yii::app()->createUrl('cms/cmsPage/create'); ?>"><img src="./images/logo.png" style="width:50px; height:30px; margin-right: 5px;" />Manage website</a></li>
            </ul>
            </div> <!-- width -->
        </div><!-- top -->
         <div id="content">
            <div class="width">
                <?php echo $content; ?>
            </div>
         </div> <!--content -->
        <div id="footer">
            <div class="width" style="background: none;">
                 Copyright © <?php echo date('Y'); ?> Motor Trade Publishers
                <a href="#" class="logo"></a>
            </div><!-- width -->
        </div> <!-- footer -->
    
</body>
</html>