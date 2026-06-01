<?php
$groupArrayScript = '';    
$groupArrayScript .= '
function ShowHideField(){
    
    var myValue = $(\'#CmsPage_function\').val();    
      
                       switch (myValue){
                   
                           case \'1\':  
                                $("#CmsPage_param_1").slideUp("normal", function(){} );
                                $("#CmsPage_param_2").attr("disabled", true);
                                $("#CmsPage_param_2").slideUp("normal", function(){} ); //hide
                                $("#CmsPage_layout").removeAttr("disabled");
                                $("#CmsPage_layout").slideDown("normal", function(){} ); //show
                                $("#addOnsUniversalElement").slideUp("normal", function(){} );                                

                                var group_array = {';
                                $groupArrayScript .= CmsLayouts::model()->getLayoutsByGroup(1); // normal_pageID
                                $groupArrayScript .= '};

                                var select = document.getElementById("CmsPage_layout");
                                select.options.length = 0;
                                for(index in group_array) {
                                    select.options[select.options.length] = new Option(group_array[index], index);
                                }
                           break; 
                               
                           case \'2\':  
                                $("#CmsPage_param_1").slideUp("normal", function(){} );
                                $("#CmsPage_param_2").attr("disabled", true);
                                $("#CmsPage_param_2").slideUp("normal", function(){} ); //hide
                                $("#CmsPage_layout").removeAttr("disabled");
                                $("#CmsPage_layout").slideDown("normal", function(){} ); //show
                                $("#addOnsUniversalElement").slideUp("normal", function(){} );
                              
                                var group_array = {';
                                $groupArrayScript .= CmsLayouts::model()->getLayoutsByGroup(2); // contactID
                                $groupArrayScript .= '};

                                var select = document.getElementById("CmsPage_layout");
                                select.options.length = 0;
                                for(index in group_array) {
                                    select.options[select.options.length] = new Option(group_array[index], index);
                                }
                            break;  

                            case \'3\':
                                $("#CmsPage_param_1").slideUp("normal", function(){} );
                                $("#CmsPage_param_2").attr("disabled", true);    
                                $("#CmsPage_param_2").slideUp("normal", function(){} ); //hide
                                $("#CmsPage_layout").attr("disabled", true);
                                $("#CmsPage_layout").slideUp("normal", function(){} );
                                
                  
//                                var select = document.getElementById("CmsPage_layout");
//                                select.options.length = 0;
//                                for(index in group_array) {
//                                    select.options[select.options.length] = new Option(group_array[index], index);
//                                }
                                
                                $("#addOnsUniversalElement").slideDown("normal", function(){} ); // elements univ                                   
                            break;

                            case \'4\': 
                                $("#CmsPage_param_1").slideDown("normal", function(){} ); //show
                                $("#CmsPage_param_2").attr("disabled", true);
                                $("#CmsPage_param_2").slideUp("normal", function(){} ); //hide
                                $("#CmsPage_layout").attr("disabled", true);
                                $("#CmsPage_layout").slideUp("normal", function(){} );
                                $("#addOnsUniversalElement").slideUp("normal", function(){} );
                            break;                   
                       }
                  
        
}';

Yii::app()->clientScript->registerScript('mainContent',$groupArrayScript,CClientScript::POS_HEAD);



/* filtrowanie uniwersalnych elementow */
$groupArrayScriptUniversalElement = '';    
$groupArrayScriptUniversalElement .= '
    
function ShowHideFieldUniversalElements(){
    $("#CmsPage_param_2").removeAttr("disabled");
    $("#CmsPage_param_2").slideDown("normal", function(){} );    
    $("#CmsPage_layout").removeAttr("disabled");
    $("#CmsPage_layout").slideDown("normal", function(){} );
            
    var myValueUniversalElementEl = $(\'#addOnsUniversalElement\').val();   
                        switch (myValueUniversalElementEl){';
    $groupArrayScriptUniversalElement .= CmsLayouts::model()->generateCase_universal_elements();
    $groupArrayScriptUniversalElement .= '}   
}';

Yii::app()->clientScript->registerScript('choiceOptions',$groupArrayScriptUniversalElement,CClientScript::POS_HEAD);
/* --- */

/* filtrowanie ELEMENTOW uniwersalnych elementow ()konkretne mapy/video/galerie/newsy */
//$groupArrayScriptUniversalElementElement = '';    
//$groupArrayScriptUniversalElementElement .= '
//    
//function ShowHideFieldUniversal(){
//    $("#CmsPage_layout").removeAttr("disabled");
//    $("#CmsPage_layout").slideDown("normal", function(){} );
//
//            
//    var myValueUniversalElement = $(\'#addOnsUniversalElement\').val();   
//
//                        switch (myValueUniversalElement){';
//                        
//    $groupArrayScriptUniversalElementElement .= CmsLayouts::model()->generateCase_universal();                                                      
//    $groupArrayScriptUniversalElementElement .= '}   
//}';
//
//Yii::app()->clientScript->registerScript('formHeader',$groupArrayScriptUniversalElementElement,CClientScript::POS_HEAD);
/* --- */

/* --- */




$this->widget('cms.extensions.elrte.elRTE', array(
    'selector'=>'element',    
    'doctype' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">',
    'cssClass' => 'el-rte',
    'absoluteURLs' => 'false',
    'allowSource' => 'true', //pokaz zrodlo
    'lang' => 'en',
    'styleWithCSS' => 'true',
    'height' => '250',
    'width' => '500px',
    'fmAllow' => 'true',
    'toolbar' => 'qcms',
 ));

$yesNoSelect = array(1=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Yes'),0=>Yii::t(Yii::app()->language.'_YiiTranslation', 'No'));
$firstLastSelect = array(0=>Yii::t(Yii::app()->language.'_YiiTranslation', 'First'),999999=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Last'));
?>

<div id="mainContent" style="padding-top:10px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'formField',          
	'enableAjaxValidation'=>false,     
        'htmlOptions'=> array('name'=>'pages'),
)); ?>

    <?php 
    //TABY 
            Yii::setPathOfAlias('juiExtension', Yii::app()->getModulePath().'/cms');
            
$this->beginWidget('juiExtension.extensions.jui.ETabs', array('name'=>'tabpanel1')); ?>
   <?php $this->beginWidget('juiExtension.extensions.jui.ETab', array('name'=>'tab1', 'title'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Content'))); ?>
    	<p class="note"><span class="requiredText"><?php echo Yii::t(Yii::app()->language.'_YiiTranslation', 'Fields with * are required'); ?></span></p>

        <?php echo $form->errorSummary($model); ?>  
    <?php
//	<div class="choiceOptions">
//		<div class="formHeader">'.$form->labelEx($model,'name').'</div>
//		echo $form->textField($model,'name',array('size'=>60,'maxlength'=>500,'class'=>'inputField iputBackground'));
//	</div>
    ?>

	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'link_name'); ?></div>
		<?php echo $form->textField($model,'link_name',array('size'=>60,'maxlength'=>500,'class'=>'inputField iputBackground')); ?>		
	</div>
        
	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'header'); ?></div>
		<?php echo $form->textField($model,'header',array('size'=>60,'maxlength'=>500,'class'=>'inputField iputBackground')); ?>		
	</div>
           
	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'txt'); ?></div>
                <div class="edit">
                    <?php echo $form->textArea($model,'txt',array('rows'=>20, 'cols'=>50,'id'=>'element','class'=>'tinyForm')); ?>
                </div>
	</div>
    
   <?php $this->endWidget('juiExtension.extensions.jui.ETab'); ?>
       
       
       
    <?php $this->beginWidget('juiExtension.extensions.jui.ETab', array('name'=>'tab2', 'title'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'SEO'))); ?>
    
        <?php echo $form->errorSummary($model); ?>
  
	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'title'); ?></div>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>500,'class'=>'inputField iputBackground')); ?>		
	</div>        
        
	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'url'); ?></div>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>700,'class'=>'inputField iputBackground')); ?>		
	</div>

	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'keywords'); ?></div>
		<?php echo $form->textArea($model,'keywords',array('rows'=>5, 'cols'=>50,'class'=>'inputBackgroundBig')); ?>		
	</div>

       <div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'description'); ?></div>
		<?php echo $form->textArea($model,'description',array('rows'=>5, 'cols'=>50,'class'=>'inputBackgroundBig')); ?>		
	</div>    
    
    <?php $this->endWidget('juiExtension.extensions.jui.ETab'); ?>
    
    
    <?php $this->beginWidget('juiExtension.extensions.jui.ETab', array('name'=>'tab3', 'title'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Advanced'))); ?>

	<?php echo $form->errorSummary($model); ?>
  
        
	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'parent_id'); ?></div>            
                <?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`name`';
                    
                    echo $form->dropDownList($model,'parent_id',CHtml::listData(CmsPage::model()->findAll($criteria), 'id', 'name'),array('class'=>'inputField','style'=>'padding-top:10px;'));
                ?>                
	</div>

        <?php /* wybor FUNKCJA */ ?>
	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'function'); ?></div>
                <?php
                
                    $criteriaGetGroup=new CDbCriteria;
                    $criteriaGetGroup->compare('`group`',0); // 0 = main group
                    $groupMain = CmsLayouts::model()->findAll($criteriaGetGroup);
  
                    
                    // <option id="9" onclick="ShowHideField();" value="f_normal_page">ZwykŇáńĀa strona</option>
                    $listData = CHtml::listData($groupMain,'id','name');
                    
                    $options = array();
                    //generuje opcje                     
                    foreach($groupMain as $grp){                 
                        //liczy od 0
                        $optionsGrp = array($grp->id=>array('onclick'=>'ShowHideField();'));
                        $options = array_merge($optionsGrp,$options);
                        $id_el = $grp->id;
                    }
                    /* aby nie ominal ostatniego elementu (!) */
                    $id_el++;
                    $optionsGrp = array($id_el=>array('onclick'=>'ShowHideField();'));
                    $options = array_merge($optionsGrp,$options);

                    $htmlOptions = array("options"=>$options, 'class'=>'inputField','style'=>'padding-top:10px;');

                    echo $form->dropDownList($model,'function',$listData, $htmlOptions);                        
                    echo '<img src="'.$this->module->assetsUrl.'/images/admin/informationMark.png" style="width:40px; height:40px;padding:2px;" class="tip" title="Funkcje pozwalają na wybranie przeznaczenia strony tzn. czy strona ma być stroną kontaktową, przekierowaniem, czy zwykłą stroną informacyjną. Przekierowanie powinno zaczynać się od index.php lub http://www.adres.pl" />';
                ?>
	</div>
        <?php /* END wybor FUNKCJA */ ?>
        
        
        <?php /* REDIRECTION */ ?>
        <div class="choiceOptions">           
        <?php
            //jesli jest wybrany Redirection
            //domyslnie (po zaladowaniu strony) jest, tylko ze ma display none
        //<img src="'.$this->module->assetsUrl.'/images/admin/informationMark.png" style="width:40px; height:40px;padding:2px;" class="tip" title="info" />
            echo $form->textField($model,'param_1',array('size'=>50,'maxlength'=>100,'style'=>'display:none; margin-left:150px;','class'=>'inputField iputBackground'));
            if(!empty($model->param_1)){
                echo '<div class="choiceOptions"><div class="formHeader"></div><span style="margin-left:20px;"><i>'.$model->param_1.'</i></span></div>';
            }
         ?>
        </div>
        <?php /* END REDIRECTION */ ?>
        
        <div class="choiceOptions">
            <select id="addOnsUniversalElement" name="addOnsUniversalElement" style="padding-top:10px; display:none; margin-left:150px;" class="inputField">
                                
<?php
                 $criteria=new CDbCriteria;
                 $criteria->condition = 'LENGTH( `group` ) > 5 AND `display` = 1'; // nie wie czy jest admin_display = 1/0
                 $univElement = CmsLayouts::model()->findAll($criteria);  
                 
                 foreach($univElement as $ue){
                     $styleImage = 'style="height:45px; background-repeat:no-repeat; background-position:bottom left; padding-left:50px;"';
                     echo '<option onclick="ShowHideFieldUniversalElements()" '.$styleImage.' value="'.$ue['id'].'">'.$ue['name'].'</option>';
                 }
?>

            </select>
        </div>   
        <?php /* END WYBOR UNIWERSALNEGO ELEMENTU - Z FUNKCJI */ ?>
        
        <?php /* KONKRETNA MAPA,GALERIA,VIDEO - EL. UNIVERSALNY */ ?>
        <div class="choiceOptions">           
           <select id="CmsPage_param_2" name="CmsPage[param_2]" style="padding-top:10px; display:none; margin-left:150px;" class="inputField">
<?php
// js nadpisuje opcje

//                 $criteria=new CDbCriteria;
//                 $criteria->condition ='`display` = 1';
//                 $univElement = CmsLayouts::model()->findAll($criteria);                                    
//                 
//                 foreach($univElement as $ue){
//                     $selected = '';
//                     if($ue->id == $model->layout){
//                        $selected = 'selected="selected"';
//                     }
//                     echo '<option onclick="ShowHideFieldUniversal()" '.$selected.' value="'.$ue['id'].'">'.$ue['name'].'</option>';//JS. pokaz layouty 
//                 }
?>
            </select>
        </div>
        <?php /* END KONKRETNA MAPA,GALERIA,VIDEO - EL. UNIVERSALNY */ ?>        
        
        <?php /* LAYOUTY */ ?>
	<div class="choiceOptions">
		

                <?php
                // layouty v 4.0
                if ($model->isNewRecord){ // create
                    ?>
                    <div class="formHeader"><?php echo $form->labelEx($model,'layout'); ?></div>
                    <?php
                //starotwo pobiera dla grupy domyslnie wybranej = normal_page
                 $criteria=new CDbCriteria;
                 $criteria->condition =" (`group` = 1) AND `display` = 1"; // group1 = normal_page default                 
                 $listDataElements = CHtml::listData(CmsLayouts::model()->findAll($criteria), 'id', 'name');                
                 echo $form->dropDownList($model,'layout', $listDataElements, array('class'=>'inputField','style'=>'padding-top:10px;'));
                 
                }else{ // update
?>                
        <div class="choiceOptions">                    
        <div class="formHeader"><?php echo $form->labelEx($model,'layout'); ?></div>                    
            <select id="CmsPage_layout" name="CmsPage[layout]" style="padding-top:10px; display:none;" class="inputField">
                                
<?php
                 $criteria=new CDbCriteria;
                 $criteria->condition ='`group` = '.$model->function.' AND `display` = 1';
                 $univElement = CmsLayouts::model()->findAll($criteria);                                    
                 
                 foreach($univElement as $ue){
                     $selected = '';
                     if($ue->id == $model->layout){
                         //echo 'select '.$model->layout;
                        $selected = 'selected="selected"';
                     }
                     echo '<option '.$selected.' value="'.$ue['id'].'">'.$ue['name'].'</option>';
                 }
?>
            </select>
        <?php
            if(!empty($model->layout) && $model->layout != 4 ){
                $oldLay = CmsPage::model()->getElement('id', $model->layout, 'CmsLayouts', 'name');
                echo '<div class="choiceOptions"><div class="formHeader"></div><span style="margin-left:20px;"><i>Wybrany: '.$oldLay.'</i></span></div>';
            }
        ?>
        </div>   
<?php
                
                }// end else update layout
                ?>
	</div>     
        <?php /* END LAYOUTY */ ?>
        
	<div class="choiceOptions">

		<?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`txt`';
                    
                    
                    //var_dump(CmsDictionary::model()->dictionaryGetGroup('order_first_last'));
                    if ($model->isNewRecord){//create
                        echo '<div class="formHeader">'.$form->labelEx($model,'order').'</div>';
                        echo $form->dropDownList($model,'order',$firstLastSelect, array('class'=>'inputField','style'=>'padding-top:10px;'));
                     }else{//update
                        echo $form->hiddenField($model,'order');
                    }
                    
                ?>
		
	</div>
    
<?php if(Yii::app()->user->isSu() == true){ //jest SU ?>
	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'editable'); ?></div>
		<?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`txt`';
                    echo $form->dropDownList($model,'editable',$yesNoSelect, array('class'=>'inputField','style'=>'padding-top:10px;'));
                ?>		
	</div>
<?php }else{ echo $form->hiddenField($model,'editable',array('value'=>'1')); } ?>

	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'display'); ?></div>
		<?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`txt`';
                    echo $form->dropDownList($model,'display',$yesNoSelect, array('class'=>'inputField','style'=>'padding-top:10px;'));
                    echo '<img style="width:40px; height:40px;" src="'.$this->module->assetsUrl.'/images/admin/img/lupa.png" alt="Delete">';
                ?>		
	</div>

<?php
    if(Yii::app()->user->isSu() == true){ //jest SU
?>
	<div class="choiceOptions">
		<div class="formHeader"><?php echo $form->labelEx($model,'deletable'); ?></div>
		<?php
                    $criteria=new CDbCriteria;
                    $criteria->order='`txt`';

                    //W 'select_yes_no' - podajemy grupe , value - przy select z grupy (jesli w select_yes_no value =0 to pole editable = 0) , txt - po czym ma listowac
                    //Value musi byc za kazdym razem inne
                    echo $form->dropDownList($model,'deletable',$yesNoSelect, array('class'=>'inputField','style'=>'padding-top:10px;'));
                ?>		
	</div>

<?php }// end if
?>    
    
    <?php $this->endWidget('juiExtension.extensions.jui.ETab'); ?>
   
    <?php //$this->beginWidget('juiExtension.extensions.jui.ETab', array('name'=>'tab4', 'title'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Authorship'))); ?>
        
	<?php //echo $form->errorSummary($model); ?>
          
<!--        <p>Autorstwo :tylko ja / inni edytorzy</p>-->
        
    <?php //$this->endWidget('juiExtension.extensions.jui.ETab'); ?>        
        
<?php $this->endWidget('juiExtension.extensions.jui.ETabs'); 
    //ZAKONCZENIE TABOW
?>

		<?php
                /* jesli zostal wybrany layout z galeria */
//                $adminDisplay = CmsPage::model()->getElement('table_name', 'CmsGallery', 'CmsUniversal', 'admin_display');
//                if($adminDisplay == 1){                
//                        echo '<div class="choiceOptions">';
//
//                        echo '<div class="formHeader">'.$form->labelEx($model,'id_gallery').'</div>';
//
//                            $criteria=new CDbCriteria;                            
//                            $listDataElements = CHtml::listData(CmsGallery::model()->findAll($criteria), 'id', 'title');
//                            
//                        echo $form->dropDownList($model,'id_gallery',$listDataElements, array('disabled'=>'disabled','class'=>'inputField','style'=>'padding-top:10px;'));
//
//                    echo '</div>';
//                }
                
                /* jesli zostal wybrany layout z mapami */
//                $adminDisplay = CmsPage::model()->getElement('table_name', 'CmsMap', 'CmsUniversal', 'admin_display');
//                if($adminDisplay == 1){                
//                        echo '<div class="choiceOptions">';
//
//                        echo '<div class="formHeader">'.$form->labelEx($model,'id_map').'</div>';
//
//                            $criteria=new CDbCriteria;                            
//                            $listDataElements = CHtml::listData(CmsMap::model()->findAll($criteria), 'id', 'title');
//                            
//                        echo $form->dropDownList($model,'id_map',$listDataElements, array('disabled'=>'disabled','class'=>'inputField','style'=>'padding-top:10px;'));
//
//                    echo '</div>';
//                }                
                ?>
        
<!--
	<div class="row">
		<?php //echo $form->labelEx($model,'template'); ?>
		<?php //echo $form->textField($model,'template',array('size'=>60,'maxlength'=>500)); ?>
		<?php //echo $form->error($model,'template'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'seo_visible'); ?>
		<?php //echo $form->textField($model,'seo_visible',array('size'=>60,'maxlength'=>500)); ?>
		<?php //echo $form->error($model,'seo_visible'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'seo_unvisible'); ?>
		<?php //echo $form->textField($model,'seo_unvisible',array('size'=>60,'maxlength'=>500)); ?>
		<?php //echo $form->error($model,'seo_unvisible'); ?>
	</div>
-->
<!--
	<div class="row">
		<?php //echo $form->labelEx($model,'param_1'); ?>
		<?php //echo $form->textField($model,'param_1',array('size'=>60,'maxlength'=>500)); ?>
		<?php //echo $form->error($model,'param_1'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'param_2'); ?>
		<?php //echo $form->textField($model,'param_2',array('size'=>60,'maxlength'=>500)); ?>
		<?php //echo $form->error($model,'param_2'); ?>
	</div>
-->

<!--
	<div class="row">
		<?php //echo $form->labelEx($model,'button'); ?>
		<?php //echo $form->textField($model,'button',array('size'=>60,'maxlength'=>500)); ?>
		<?php //echo $form->error($model,'button'); ?>
	</div>
-->

	<div class="button">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t(Yii::app()->language.'_YiiTranslation', 'Create') : Yii::t(Yii::app()->language.'_YiiTranslation', 'Update'), array('class'=>'buttonClearForm', 'style'=>'padding-top:0px;')); ?>


            
		<?php 
                if(!$model->isNewRecord){
                    //echo CHtml::Button(Yii::t(Yii::app()->language.'_YiiTranslation', 'Public'), array('class'=>'buttonClearForm', 'style'=>'padding-top:0px;')); 
                    if(empty($model->display) || $model->display == 0){
                        $public = 1;
                        $title = Yii::t(Yii::app()->language.'_YiiTranslation', 'Publish');
                    }else{
                        $public = 0;
                        $title = Yii::t(Yii::app()->language.'_YiiTranslation', 'Not publish');
                    }
                    
                    echo CHtml::submitButton($title,array(
                        'submit' => 'index.php?r=cms/cmsPage/publicPage&id='.$model->id.'&p='.$public,
                        'class' => 'buttonClearForm',
                        'style' => 'padding-top:0px;'
                    ));
                }
                ?>
	</div>

<?php $this->endWidget(); ?>


</div>