<?php
   
    
    $layoutName = CmsLayouts::model()->find('id=?',array(41));

    
//    $checkIsUniversalGroupByGroupField = CmsPage::model()->getElement('id', $layoutName->group, 'CmsLayouts', 'group');                    
//    $lengthGroup = strlen($checkIsUniversalGroupByGroupField);
    
//    if( $lengthGroup > 5 ){    // 5 = ilosc slow (!id => jakis uniwersalny element)
//        $pathToLayout = 'cms.views.layouts.'.$checkIsUniversalGroupByGroupField.'.'.$layoutName->fileName;
//    }else{
        $pathToLayout = 'cms.views.layouts.'.$layoutName->fileName;
//    }
    
    //echo $pathToLayout;die;
    $this->beginContent('//layouts/main'); // dla mainApp
    //$this->beginContent('cms.views.layouts.column1'); // dla CMS

        // CMS
    $this->layout = $pathToLayout;
        echo $this->layout;
        

        // Main APP
        //$this->layout = '//layouts/'.$layoutFileName;

    $this->endContent();
?>