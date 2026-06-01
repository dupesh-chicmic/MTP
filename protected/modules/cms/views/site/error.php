<?php             
//$this->pageTitle=Yii::app()->name . ' - Error';
//$this->breadcrumbs=array(
//	'Error',
//);                
     Yii::app()->getClientScript()->registerCssFile($this->module->assetsUrl.'/css/style_page.css');

?>

<?php
if(isset($_GET['url'])){
    $url = $_GET['url'];
    $home = CmsPage::model()->getRow('CmsPage','url',$url); 
}
?>

                <div class="banner">
			<div class="banner_main">
                                    <?php CmsUniversal::model()->menuTop_2(); ?>
			</div>

			<div class="path">Jesteś tutaj: Error</div>
		</div>

		<div class="content">		
			<div class="right">
				<div class="right_tresc"></div>
                                    <?php CmsUniversal::model()->redLastProjectList(); ?>

			</div>

			<div class="top"></div>
			<div class="tresc">
				<div class="txt">
					<p class="main_title"><?php echo Yii::t(Yii::app()->language.'_YiiTranslation', 'Ooops! Where is this site?'); ?></p>
					<div class="line"></div>
                                            <div class="text_essential">
                                            <?php 
                                             //ERROR PAGE 
                                                //echo '<h4></h4>';
                                                //<h2>Error echo $code; </h2>

                                                echo '<div class="error">';
                                                echo CHtml::encode($message);
                                                echo '</div>';
                                            ?>
                                            </div>
				</div>
			</div>
			<div class="bottom"></div>
		</div>