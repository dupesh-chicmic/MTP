<?php
    //$layoutFileName = CmsPage::model()->getElement('id', $model->layout, 'CmsLayouts', 'fileName');
    //echo 'IDzeStrony '.$model->layout.'<p>';

    // sprawdz czy jest przekierowanie (layout = 4)
    if($model->layout == 4 ){
        //przekieruj
        $this->redirect($model->param_1);
        exit;
    }
            
    $layoutName = CmsLayouts::model()->find('id=?',array($model->layout));

    
    $checkIsUniversalGroupByGroupField = CmsPage::model()->getElement('id', $layoutName->group, 'CmsLayouts', 'group');                    
    $lengthGroup = strlen($checkIsUniversalGroupByGroupField);
    
    if( $lengthGroup > 5 ){    // 5 = ilosc slow (!id => jakis uniwersalny element)
        $pathToLayout = 'cms.views.layouts.'.$checkIsUniversalGroupByGroupField.'.'.$layoutName->fileName;
    }else{
        $pathToLayout = 'cms.views.layouts.CmsPage.'.$layoutName->fileName;
    }
    
    //echo $pathToLayout;die;
    $this->beginContent('//layouts/main'); // dla mainApp
    //$this->beginContent('cms.views.layouts.column1'); // dla CMS

        // CMS
        $this->layout = $pathToLayout;

        // Main APP
        //$this->layout = '//layouts/'.$layoutFileName;

    $this->endContent();
?>