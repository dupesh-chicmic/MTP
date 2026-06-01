<?php
class QJSHelper {
    
    public static function colorBoxInit($className='colorBox') {
        if(!Yii::app()->clientScript->isScriptFileRegistered(Yii::app()->baseUrl.'/js/colorbox/jquery.colorbox.js',CClientScript::POS_HEAD)) {
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/colorbox/jquery.colorbox.js',CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/js/colorbox/colorbox.css');
        }
        
        if(!Yii::app()->clientScript->isScriptRegistered('content')) {
                Yii::app()->clientScript->registerScript('content','
        $.colorbox.settings.close = "Zamknij";
        $(document).ready(function(){
        $(".'.$className.'").colorbox({width:"80%", height:"80%", iframe:true});
                        
            //Example of preserving a JavaScript event for inline calls.
//            $("#click").click(function(){
//                $(\'#click\').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
//                return false;
//            });
        });
        ',CClientScript::POS_HEAD);
        }
    }
}
?>
