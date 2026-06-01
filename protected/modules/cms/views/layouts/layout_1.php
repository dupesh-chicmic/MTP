<?php
            if( (Yii::app()->getUser()->getName() == 'admin') ){ //jest adminem
                $this->beginContent('/layouts/main');
            }else if( (Yii::app()->getUser()->getName() == 'su') ){
                $this->beginContent('/layouts/main');
            }else{
                $this->beginContent('//layouts/mainFront');
            }

/* elementy ze slownika */
$dict_wiadomosc_dnia = CmsDictionary::model()->dictionaryGetText('front_wiadomosc_dnia');

/* */
?>

<?php
if(isset($_GET['url'])){
    $url = $_GET['url'];
    $home = CmsPage::model()->getRow('CmsPage','url',$url); 
}
?>


            <div class="sideContent">
                <div id="logo">
                    <img alt="logo" src="<?php echo $this->module->assetsUrl; ?>/images/logo.png">
                </div>
                    <?php CmsNews::model()->getLatestNews(); ?>
                </div>
            <div id="mainContent">
                <div id="buildPicture">
                    <div class="mainMenu siteFont">
                        <a href=""><div onmouseout="this.className='menu'" onmouseover="this.className='menuHover'" class="menu"><div class="name">Home</div></div></a>
                        <a href=""><div onmouseout="this.className='menu'" onmouseover="this.className='menuHover'" class="menu"><div class="name">About Us</div></div></a>
                        <a href=""><div onmouseout="this.className='menu'" onmouseover="this.className='menuHover'" class="menu"><div class="name">News</div></div></a>
                        <a href=""><div onmouseout="this.className='menu'" onmouseover="this.className='menuHover'" class="menu"><div class="name">Contact</div></div></a>
                     </div>
                </div>
                <div class="pageContent">
                    <div class="headerLeft"></div><div class="headerCenter siteFont title"><?php echo $home['link_name']; ?></div><div class="headerRight"></div>
                    <div class="text"><?php echo $home['txt']; ?></div>
                </div>
          </div>      



<?php $this->endContent(); ?>