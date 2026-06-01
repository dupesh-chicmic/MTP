<?php

class TinyMCE {
    
    public function startTiny(){
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/tiny_mce/tiny_mce.js',CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScript('form','
           tinyMCE.init({
            mode : "exact",
            elements : "element1,element2,element3,element4,element5",
            language : "en",
            theme : "advanced",
            plugins : "save,advimage,advlink,preview,contextmenu, ibrowser",

			  forced_root_block : false, 
			  force_br_newlines : true, 
			  force_p_newlines : false,
        
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,fontsizeselect,|,code",
        theme_advanced_buttons2 : "outdent,indent,|,link,unlink,|,forecolor,backcolor,|,charmap,image,ibrowser,|,removeformat,cleanup,|,preview",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_resizing : false,

        skin : "o2k7",
        skin_variant : "",//black
        content_css : "css/example.css",

        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }

        });
        ',CClientScript::POS_HEAD);
    }
    
    public function no_Ibrowser_startTiny(){
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/tiny_mce/tiny_mce.js',CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScript('form','
           tinyMCE.init({
            mode : "exact",
            elements : "element1,element2,element3,element4,element5",
            language : "en",
            theme : "advanced",
            plugins : "save,advimage,advlink,preview,contextmenu, ibrowser",

			  forced_root_block : false, 
			  force_br_newlines : true, 
			  force_p_newlines : false,        
		
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,fontsizeselect,|,code",
        theme_advanced_buttons2 : "outdent,indent,|,link,unlink,|,forecolor,backcolor,|,charmap,image,|,removeformat,cleanup,|,preview",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_resizing : false,

        skin : "o2k7",
        skin_variant : "",
        content_css : "css/example.css",

        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }

        });
        ',CClientScript::POS_HEAD);
    }    
    
  public function dictionary_startTiny(){
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/tiny_mce/tiny_mce.js',CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScript('form','
           tinyMCE.init({
            mode : "exact",
            elements : "element1,element2,element3,element4,element5",
            language : "en",
            theme : "advanced",
            plugins : "save,advimage,advlink,preview,contextmenu, ibrowser",


			  forced_root_block : false, 
			  force_br_newlines : true, 
			  force_p_newlines : false,
			
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough|,forecolor,backcolor,|,code",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_resizing : false,

        skin : "o2k7",
        skin_variant : "",
        content_css : "css/example.css",

        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }

        });
        ',CClientScript::POS_HEAD);
    }    
    
    
}


?>
