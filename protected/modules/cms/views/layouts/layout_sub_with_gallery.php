<?php            
     $this->beginContent('//layouts/mainFront');

     Yii::app()->getClientScript()->registerCssFile($this->module->assetsUrl.'/css/style_page.css');
 
  
if(isset($_GET['url'])){
    $url = $_GET['url'];
    $home = CmsPage::model()->getRow('CmsPage','url',$url); 
}

//COLORBOX gallery
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/js/colorbox/jquery.colorbox-min.js',CClientScript::POS_HEAD);
Yii::app()->getClientScript()->registerCssFile($this->module->assetsUrl.'/js/colorbox/colorbox.css');

$skrypt = '
		$(document).ready(function(){
			$("a[rel=\'gallery_lp\']").colorbox({transition:"fade"});
			$("#click").click(function(){
				$(\'#click\').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});    
    ';
             //$calaGaleria
             $criteria = new CDbCriteria;             
             $criteria->compare('`parent_id`', $home['id_gallery']);//$_GET['id']
             $result = CmsGalleryPicture::model()->findAll($criteria);
            
  foreach($result as $item){
                        $skrypt .= '$(".'.$item['id'].'").colorbox({
                     title: function() {
                     ';
                        if($item['link_position'] == 0){
                               $skrypt .= 'return \'<a id="links" href="'.$item['link'].'" target="_blank">'.$item['link_title'].'<\/a> '.$item['text'].'\';';
                        }else{
                               $skrypt .= 'return \''.$item['text'].' <a id="links" href="'.$item['link'].'" target="_blank">'.$item['link_title'].'<\/a>\';';
                        }
                            $skrypt .= '}
                        });
                        
  ';}
  
$skrypt .= '});';

Yii::app()->clientScript->registerScript('content',$skrypt,CClientScript::POS_HEAD);
/* elementy ze slownika */
//$dict_wiadomosc_dnia = CmsDictionary::model()->dictionaryGetText('front_wiadomosc_dnia');

/* */
?>



                <div class="banner">
			<div class="banner_main">
                                    <?php CmsUniversal::model()->menuTop_2(); ?>
			</div>
<?php
    $page = CmsPage::model()->findByPk(CmsPage::model()->getId_ByUrl($_GET['url']));    
    $menuPath = $page->getMenuActivePath('CmsPage', 'parent_id', $page->id);
    $menuPath = array_reverse($menuPath);
    $breadcrumbs ='';
    foreach ($menuPath as $pathItem){
        $tmpPage = CmsPage::model()->findByPk($pathItem);
        if (isset($tmpPage) && $tmpPage->display==1){
            //$breadcrumbs .= '<a href="index.php?r=cms/cmsPage/displayPage&url='.$tmpPage->url.'">'.$tmpPage->link_name.'</a> &raquo;';
        }else {}
                
    }

    //$tmpPage = CmsPage::model()->findByPk($this->id);
            $urlHome = CmsPage::model()->getElement('id', 4, 'CmsPage', 'url');
            $breadcrumbs .= '<a href="'.$this->module->assetsUrl.'/index.php?r=cms/cmsPage/displayPage&url='.$urlHome.'">Strona główna</a> &raquo;';
            $breadcrumbs .= '<a href="index.php?r=cms/cmsPage/displayPage&url='.$page->url.'"> '.$page->link_name.'</a>';

?>                    
			<div class="path">Jesteś tutaj: <?php echo $breadcrumbs; ?></div>
		</div>

		<div class="content">		
			<div class="right">
				<div class="right_tresc"></div>
                                    <?php CmsUniversal::model()->redLastProjectList(); ?>

			</div>

			<div class="top"></div>
			<div class="tresc">
                            <div class="txt">
                                    <p class="main_title"><?php echo $home['link_name']; ?></p>
                                    <div class="line"></div>
                                        <div class="text_essential"><?php echo $home['txt']; ?></div>

                                        <?php // zdjecia galerii 

                                        $modelGalleryPicture=CmsGalleryPicture::model()->findAll('parent_id=?',array($home['id_gallery']));
                                        
                                        $directory = CmsGallery::model()->inputTypes();
                                        $directory_m = $directory['image']['folder_name'].$home['id_gallery'].'/m';
                                        $directory_d = $directory['image']['folder_name'].$home['id_gallery'].'/d';
                                       
                                          foreach (new DirectoryIterator($directory_m) as $fileInfo) {
                                              $plik_nazwa = $fileInfo->getFilename();
                                                
                                                      if(($plik_nazwa!=".")&&($plik_nazwa!="..")&&($plik_nazwa!=".svn")){                
                                                            //dynamicznie pobieramy id
                                                            $uniqePicID = CmsPage::model()->getElement('image',$plik_nazwa,'CmsGalleryPicture','id');                                                  
                                                                echo '<div class="gallery_row">';
                                                                //echo '<a class="'.$uniqePicID.'" target="_blank" rel="gallery_lp" href="'.$directory_d.'/'.$plik_nazwa.'" ><img alt="" src="'.$directory_m.'/'.$plik_nazwa.'" /></a>';
                                                                echo '<div style="background-image: url('.$directory_d.'/'.$plik_nazwa.'); background-repeat: no-repeat; background-position: center -10px;" class="cutImage">
                                                                    <a class="'.$uniqePicID.'" target="_blank" rel="gallery_lp" href="'.$directory_d.'/'.$plik_nazwa.'">
                                                                    </a>
                                                                    </div>';
                                                                echo '</div>';   
                                                      }
                                           }


                                        ?>

                            </div>
			</div>
			<div class="bottom"></div>
		</div>


<?php $this->endContent(); ?>