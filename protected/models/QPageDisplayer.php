<?php
class QPageDisplayer
{
    public $uzytkownik;
    public $klient;
    public $page;
    public $menu;
    public $mainMenu;
    public $dict;
    public $elements;
    public $cart;
    public $contactModel;
    public $newsList;
    public $news;
    public $galleryList;

       
    public function getAllElements(){
        $criteria = new CDbCriteria;
        $criteria->compare('display',1);
                
        $this->elements['CmsUniversal'] = CmsUniversal::model()->findAll($criteria);
        
        foreach ($this->elements['CmsUniversal'] as $elem){
            $criteria = new CDbCriteria;
            $criteria->compare('display',1);
            $criteria->order='`order`';
            $this->elements[$elem->table_name] = CActiveRecord::model($elem->table_name)->findAll($criteria); // ok
              
            //$this->elements[$elem->table_name] = $elem->table_name::model()->findAll($criteria);
            
        } 
    }
    
    public function getPage($url){        
        $criteria = new CDbCriteria;
        $criteria->compare('`t`.`display`',1);   
        $criteria->compare('`t`.`url`',$url);
        $this->page = CmsPage::model()->with(array(
            'cmsLayouts','pageElement',
            'pageElement.cmsUniversal',
            'pageElement.maps',
            'pageElement.news',
            'pageElement.gallery',            
            ))->find($criteria);
        
        //echo $this->page->cmsLayouts->name;
        //echo $this->page->pageElement->maps->title;
        //var_dump($this->page->pageElement->maps->attributes);
        //die;
        
        //echo '<p>';
        //var_dump($this->page->pageElement->attributes);
    }
    
    public function getDictionary($context=null){
        $criteria = new CDbCriteria;
        if (!empty($context)) {
            $criteria->compare('context',$context);   
        }   
        $dictionary = CmsDictionary::model()->findAll($criteria);
        foreach ($dictionary as $dictRow){
            $this->dict[$dictRow->key] = $dictRow; 
        }        
    }
    
    public function getCart(){
        $this->cart = QProductCart::model()->findAll(array(
         				'condition'=>'t.sid="'.Yii::app()->session->sessionID.'"',
         				'with'=>array(
         					'rev.attrOptions.attrDefOption.attrDef',
         					'rev.product.currentPrices'
         				)	
         			));
       
    }

    public function hasCartItems(){
        if (sizeof($this->cart)!=0){
            return true;
        }else return false;               
    }


    public function getDictFor($key){    
        //var_dump($this->dict[$key]); die();
        //return $this->dict[$key]->txt;      
        
        /* Mariusz */
        return CmsDictionary::model()->dictionaryGetText($key);
        /* --- */
        
    }
    
    /* MENU */
    public function getMainMenu(){
        // menu_top
                    $criteria=new CDbCriteria;
                    $criteria->compare('parent_id', 3);
                    $criteria->compare('display', 1);
                    $criteria->order = '`order`';

                    $strony_z_bazy = CmsPage::model()->findAll($criteria);
                    $this->mainMenu = $strony_z_bazy;

    }
    
    public function getSubMenu(){
        

        $criteria=new CDbCriteria;        
        $criteria->compare('display', 1);
        $criteria->order = '`order`';
        $allPages = CmsPage::model()->findAll($criteria);
        
        foreach($allPages as $page){
            $this->subMenu[$page->parent_id][] = $page;
        }
         
    }
    
    
//    public function getSubMenu($url){
//        $idByUrl = CmsPage::model()->getElement('url', $url, 'CmsPage', 'id');
//
//        $criteria=new CDbCriteria;
//        $criteria->compare('parent_id', $idByUrl);
//        $criteria->compare('display', 1);
//        $criteria->order = '`order`';
//
//        $strony_z_bazy = CmsPage::model()->findAll($criteria);
//        $this->menu = $strony_z_bazy;
//    }
    /* --- */
    
    /* News */
    public function getNewsByOrderByFieldFromCmsUniversal($count=0){
       $orderByField = CmsPage::model()->getElement('table_name', 'CmsNews', 'CmsUniversal', 'order_by');
       
       $criteria=new CDbCriteria;
       $criteria->compare('display', 1);
       if(!empty($orderByField)){
        $criteria->order = $orderByField;
       }
       if($count>0){
           $criteria->limit=$count;
       }
       $newsy = CmsNews::model()->findAll($criteria);
       $this->newsList = $newsy;
    }

    /* --- */
  
    /* Gallery */
    public function getGalleryByOrderByFieldFromCmsUniversal(){
       $orderByField = CmsPage::model()->getElement('table_name', 'CmsGallery', 'CmsUniversal', 'order_by');
       
       $criteria=new CDbCriteria;
       $criteria->compare('display', 1);
       if(!empty($orderByField)){
        $criteria->order = '`'.$orderByField.'`';
       }

       $galleries = CmsGallery::model()->findAll($criteria);
       $this->galleryList = $galleries;
    }

    /* --- */    

    /* Baner Top */
    public function getBannerTop(){
       $criteria=new CDbCriteria;
       $criteria->compare('display', 1);
       $banery_z_bazy = CmsBanner::model()->findAll($criteria);

        $link = '#';
        $banery = array();
        foreach($banery_z_bazy as $baner){

            if(empty($baner['code'])){
                $directory = './pictures/banner/'.$baner['id'];  //podaje sciezke/nazwa folderu

                if(file_exists($directory)){

                }else{ echo "Folder z banerami nie został znaleziony"; }

                  foreach (new DirectoryIterator($directory) as $fileInfo) {
                      $plik_nazwa = $fileInfo->getFilename();

                        if(($plik_nazwa!=".")&&($plik_nazwa!="..")&&($plik_nazwa!=".svn")){
                            if($baner['image'] == $plik_nazwa){
                                $file_extension = substr($baner['image'], -3);//zostawia tylko jpg/png/gif
                                if($file_extension == 'swf'){

                                    echo '<a style="width: 930px; height: 170px;"  href="'.$link.'"><div>';
                                    // flash
                                        echo '
                                        <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                                        codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
                                        WIDTH="770" HEIGHT="110" id="prezentacja">
                                         <PARAM NAME=movie VALUE="'.$directory.'/'.$plik_nazwa.'"> <PARAM NAME=quality VALUE=high>
                                         <PARAM NAME=bgcolor VALUE=#FFFFFF><param name="wmode" value="transparent" />
                                        <EMBED src="'.$directory.'/'.$plik_nazwa.'" quality=high bgcolor=#FFFFFF  WIDTH="280" HEIGHT="200" NAME="prezentacja" ALIGN="left"
                                        TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer" wmode="transparent"></EMBED>
                                        </OBJECT>';

                                          echo '</div><div class="title">'.$baner['title'].'</div>';
                                          echo $baner['txt'];
                                        echo '</div></a>';
                                }else{
                                    if(empty($baner['url'])){
                                        $link = '';
                                    }else{
                                        $link = $baner['url'];
                                    }

                                    echo '<a style="width: 930px; height: 170px;"  href="'.$link.'">
                                        <div><img src="'.$directory.'/'.$plik_nazwa.'" style=" padding-top:10px; padding-left:20px;" />';
                                    //echo '<div class="title"><span>'.$baner['txt'].'</span></div>';
                                    echo '</div></a>';
                                }
                            }//end if($baner['image'] == $plik_nazwa){
                        }
                    }   // end foreach

            }else{
                //jesli zostal wpisany kod skryptu
                echo $baner['code'];
            }

        }//end foreach

    }
    /* --- */
    
            
       
        
}    
?>