<?php

echo '<p><div class="operations"><a href="index.php?r=site/index">Wróc do swojego profilu</a></div>';
             echo '<div class="form">';

                $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'cms-article-form',
                        'enableAjaxValidation'=>false,
                        'htmlOptions' => array('enctype'=>'multipart/form-data'),
                ));

                    if(isset($_GET['pic'])){
                                echo '<fieldset>
                                <legend>Dodaj swoje zdjęcie</legend>';
                                echo CHtml::activeFileField($model, 'image'); 
                                echo '</fieldset>';

                    }else if(isset($_GET['txt'])){

                        Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/assets/js/tiny_mce/tiny_mce.js',CClientScript::POS_HEAD);
                        Yii::app()->clientScript->registerScript('form','
                           tinyMCE.init({
                            mode : "exact",
                            elements : "element1,element2,element3,element4,element5",
                            language : "en",
                            element_format : "xhtml",
                            theme : "advanced",
                            forced_root_block : false,
                            force_br_newlines : true,
                            force_p_newlines : false,
                            convert_fonts_to_spans : false,
                            plugins : "save,advimage,advlink,preview,contextmenu, ibrowser",
                            convert_urls : false,
                            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,fontsizeselect,|,code",
                            theme_advanced_buttons2 : "link,unlink,|,forecolor,backcolor,|,charmap,image,|,removeformat,cleanup",
                            theme_advanced_buttons3 : "",
                            theme_advanced_toolbar_location : "top",
                            theme_advanced_toolbar_align : "left",
                extended_valid_elements : "a[name|href|target|align|title|onclick],img[src|style||alt|title|width|height|align],hr[class|width|size|noshade|align],span[class|align|style],br,p",
                valid_elements : "blockquote,strong,em,cite,abbr,acronym,p,br,b,i,u,ul,ol,li",
                             external_link_list_url : "example_data/example_link_list.js",
                             external_image_list_url : "example_data/example_image_list.js"
                        });
                        ',CClientScript::POS_HEAD);




                        echo '<div class="row">';
                                 echo $form->labelEx($model,'Opis');echo '<p>';
                                 echo $form->textArea($model,'txt',array('rows'=>20, 'cols'=>50,'id'=>'element1'));                                 
                        echo '</div>';
                    }

                    echo '<div class="row buttons">';
                            echo CHtml::submitButton('Dodaj');
                    echo '</div>';
                    
            $this->endWidget();
?>

     </div>

