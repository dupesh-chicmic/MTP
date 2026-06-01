<?php
/* TYL */

/* elementy ze slownika */
$dict_univ_element = CmsDictionary::model()->dictionaryGetText('adm_univ_element');
$dict_univ_create = Yii::t(Yii::app()->language.'_YiiTranslation', 'Add new element');
$dict_create = Yii::t(Yii::app()->language.'_YiiTranslation', 'Create');
$dict_update = Yii::t(Yii::app()->language.'_YiiTranslation', 'Update');
$dict_zarzadzaj_zdjeciami = Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage picture');
$dict_na_pewno_usunac = Yii::t(Yii::app()->language.'_YiiTranslation', 'Are you sure you want to delete this item?');
$dict_operations = Yii::t(Yii::app()->language.'_YiiTranslation', 'Options');

/* */

if(Yii::app()->language == 'pl'){
    $header_universal = $universal_model->menu_top_label_pl; 
}else{
    $header_universal = $universal_model->menu_top_label_en;     
}

$this->breadcrumbs=array(
	$dict_univ_element=>array('elements'),
	//$model->id=>array('view','id'=>$model->id),
	$header_universal,        
);

$modelName = $_GET['e'];
if( $_GET['id'] !=0){ // update
    
    switch($modelName){
    
        case 'CmsNews': 
            $this->menu=array(
                    array('label'=>$dict_univ_create, 'url'=>array('modelElement','e'=>$_GET['e'], 'id'=>0)),
                    //array('label'=>$dict_dodaj_zdjecie, 'url'=>array('addPicture','e'=>$_GET['e'],'id'=>$_GET['id'])),
                    //array('label'=>$dict_zarzadzaj_zdjeciami, 'url'=>array('pictureManage','e'=>$_GET['e'], 'id'=>$_GET['id'], 'delete'=>'0')),
            );
        break;
        
        case 'CmsShopProduct':
            $this->menu=array(
                        array('label'=>$dict_univ_create, 'url'=>array('modelElement','e'=>$_GET['e'], 'id'=>0)),
                        //array('label'=>$dict_dodaj_zdjecie, 'url'=>array('addPicture','e'=>$_GET['e'],'id'=>$_GET['id'])),
                        array('label'=>$dict_zarzadzaj_zdjeciami, 'url'=>array('pictureManage','e'=>$_GET['e'], 'id'=>$_GET['id'], 'delete'=>'0')),
                );
        break;
    
        case 'CmsGallery':
            $this->menu=array(
                        array('label'=>$dict_univ_create, 'url'=>array('modelElement','e'=>$_GET['e'], 'id'=>0)),                        
                        array('label'=>$dict_zarzadzaj_zdjeciami, 'url'=>array('gallery_pictureManage','e'=>$_GET['e'], 'id'=>$_GET['id'], 'delete'=>'0')),
                );
        break;
    
    default:
        if($_GET['e'] == 'InputTypes'){                
            $types = InputTypes::model()->inputTypesForInputTypes();
        }else{                            
            $types = InputTypes::model()->getInputTypes($_GET['e']);
        }        
        
        if(isset($types['image'])){
            if($types['image']['type'] == 'onlyFolder'){
                        $this->menu=array(
                        array('label'=>$dict_univ_create, 'url'=>array('modelElement','e'=>$_GET['e'], 'id'=>0)),
                        array('label'=>$dict_zarzadzaj_zdjeciami, 'url'=>array('pictureManage','e'=>$_GET['e'], 'id'=>$_GET['id'], 'delete'=>'0')),
                    );
            }else{
                    $this->menu=array(
                        array('label'=>$dict_univ_create, 'url'=>array('modelElement','e'=>$_GET['e'], 'id'=>0)),
                    );
            }                    
        }else{
            $this->menu=array(
                array('label'=>$dict_univ_create, 'url'=>array('modelElement','e'=>$_GET['e'], 'id'=>0)),
            );         
        }

        
    }
    
}else{
    $this->menu=array(
            array('label'=>$dict_univ_create, 'url'=>array('modelElement','e'=>$_GET['e'], 'id'=>0)),
    );
}
?>

    <h2 style="padding-left:10px;"><?php 
        echo $header_universal;
    ?></h2>


<?php
$id = $_GET['id'];
$model_element = $_GET['e'];




    if( (Yii::app()->getUser()->getName() == 'su') || (Yii::app()->getUser()->getName() == 'admin')  ){
?>    
	<div class="operations">
<div class="boxNewPage"><img alt="arrow" src="<?php echo $this->module->assetsUrl; ?>/images/admin/img/arrow.png"><div class="text"><?php echo $dict_operations; ?></div></div>            
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				//'title'=>$dict_operations,
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'boxBackground'),
			));
			$this->endWidget();
		?>

<?php 
echo '<div class="buttonClearForm" style="margin-left:0px; margin-top:0px; ">'.$header_universal.'</div>';
//echo '<div class="boxNewPage"><img src="'.$this->module->assetsUrl.'/images/admin/img/arrow.png" alt="arrow"><div class="text">'.$dict_zarzadzaj_elementami.'<br />('.$header_universal.')</div></div>';
    //listoawanie menu elementow
echo '<ul>';
    $i=1;
    if($model_element == 'CmsMapElements'){

        Yii::app()->clientScript->registerScript('accordion','
                $(function() {
                        $( "#accordion" ).accordion({
                                autoHeight: false,
                                navigation: true
                        });
                });
        ',CClientScript::POS_HEAD);
        
        $criteria=new CDbCriteria;
        $criteria->order = '`order`';        
        //Mapy
        $maps = CmsMap::model()->findAll($criteria);
        $maps_element = CmsMapElements::model()->findAll($criteria);
        /* */

            echo '<div id="accordion">';
            $i=1;
                        foreach ($maps as $map){
                            echo  '<h3><a href="#section'.$i.'">'.$map->title.'</a></h3><div>';
                                foreach ($maps_element as $item_map){
                                    if($map->id == $item_map->id_Map){
                                        echo '<a href="index.php?r=cms/cmsUniversal/modelElement&&e='.$_GET['e'].'&&id='.$item_map->id.'&&edit=1">'.$item_map->title.'</a> /<a class="del" href="index.php?r=cms/cmsUniversal/deleteElement&&e='.$_GET['e'].'&&id='.$item_map->id.'" title="Delete" onclick="return confirm('.$dict_na_pewno_usunac.')"> X</a><br>';
                                    }
                                }
                            echo '</div>';
                            $i++;
                        }
            echo '</div>';

                }else if ($model_element == 'CmsCategory' || $model_element == 'CmsShopCategories'){                    
                    echo CActiveRecord::model($model_element)->getAdminCategoriesMenu();
                }else if($model_element == 'CmsManager'){
                    foreach ($model as $item){
                        //imie i nazwisko listujemy w adminie
                                echo  '<div class="caption"><a href="index.php?r=cms/cmsUniversal/modelElement&&e='.$_GET['e'].'&&id='.$item->id.'&&edit=1">'.$i.' '.$item->name.' '.$item->nazwisko.'</a></div>
                                        <div class="iconExit"><a onclick="return confirm(\''.$dict_na_pewno_usunac.'\')" title="Delete" href="index.php?r=cms/cmsUniversal/deleteElement&&e='.$_GET['e'].'&&id='.$item->id.'"><img src="'.$this->module->assetsUrl.'/images/admin/img/delete.png" alt="Delete"></a></div>                                                                        
                                       </div>';
                                $i++;                        
                    }  
                }else if ($model_element == 'CmsLayouts'){
                    /* dodawanie layoutow z cms */
                    // TODO: dodawanie layoutow z cms - do zrobienia
//                        foreach ($model as $item){
//                            
//                                echo '<li><div class="caption"><a href="index.php?r=cms/cmsUniversal/modelElement&&e='.$_GET['e'].'&&id='.$item->id.'&&edit=1"><strong>'.$i.'.</strong> '.$item->name.'</a>';
//                                if($item->display == 0){
//                                    echo '<div class="iconExit"><img style="width:30px; height:30px;" src="'.$this->module->assetsUrl.'/images/admin/img/lupa.png" alt="" /></div>';
//                                }    
//                                echo '</div>';                                
//                                if($item['layout_id'] > 1000){
//                                    echo '<div class="iconExit"><a onclick="return confirm(\''.$dict_na_pewno_usunac.'\')" title="Delete" href="index.php?r=cms/cmsUniversal/deleteElement&&e='.$_GET['e'].'&&id='.$item->id.'"><img src="'.$this->module->assetsUrl.'/images/admin/img/delete.png" alt="Delete"></a></div>';
//                                }
//                                    echo '</li>';                                
//                                $i++;                           
//                        }                    
                }else{
                        foreach ($model as $item){
                            if(isset($item->title)){
                                echo  '<li><div class="caption"><a href="index.php?r=cms/cmsUniversal/modelElement&&e='.$_GET['e'].'&&id='.$item->id.'&&edit=1"><strong>'.$i.'.</strong> '.$item->title.'</a>';
                               
                                    if(isset($item->display)){
                                        if($item->display == 0){
                                            echo '<div class="iconExit"><img style="width:30px; height:30px;" src="'.$this->module->assetsUrl.'/images/admin/img/lupa.png" alt="(!)" /></div>';
                                        }    
                                    }else{
                                          echo '<div class="iconExit"><img style="width:30px; height:30px;" src="'.$this->module->assetsUrl.'/images/admin/img/lupa.png" alt="(!)" /></div>';
                                    }
                                
                                echo '</div>';
                                    echo '<div class="iconExit"><a onclick="return confirm(\''.$dict_na_pewno_usunac.'\')" title="Delete" href="index.php?r=cms/cmsUniversal/deleteElement&&e='.$_GET['e'].'&&id='.$item->id.'"><img src="'.$this->module->assetsUrl.'/images/admin/img/delete.png" alt="Delete"></a></div>';
                                        echo '</li>';//<a class="del" href="index.php?r=cms/cmsUniversal/deleteElement&&e='.$_GET['e'].'&&id='.$item->id.'" title="Delete" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')"> X</a>
                                $i++;
                            }else{
                                if($model_element == 'InputTypes'){
                                    echo '<li><div class="caption"><a href="index.php?r=cms/cmsUniversal/modelElement&&e='.$_GET['e'].'&&id='.$item->id.'&&edit=1"><strong>'.$i.'.</strong> '.$item->model.'_'.$item->field.'</a>';
                                }else{
                                    echo '<li><div class="caption"><a href="index.php?r=cms/cmsUniversal/modelElement&&e='.$_GET['e'].'&&id='.$item->id.'&&edit=1"><strong>'.$i.'.</strong> '.$item->name.'</a>';
                                }
                                                             
                                    if(isset($item->display)){
                                        if($item->display == 0){
                                            echo '<div class="iconExit"><img style="width:30px; height:30px;" src="'.$this->module->assetsUrl.'/images/admin/img/lupa.png" alt="(!)" /></div>';
                                        }
                                    }else{
                                         echo '<div class="iconExit"><img style="width:30px; height:30px;" src="'.$this->module->assetsUrl.'/images/admin/img/lupa.png" alt="(!)" /></div>';
                                    }
                                
                                echo '</div>';
                                    echo '<div class="iconExit"><a onclick="return confirm(\''.$dict_na_pewno_usunac.'\')" title="Delete" href="index.php?r=cms/cmsUniversal/deleteElement&&e='.$_GET['e'].'&&id='.$item->id.'"><img src="'.$this->module->assetsUrl.'/images/admin/img/delete.png" alt="Delete"></a></div>';
                                    echo '</li>';
                                //<a class="del" href="index.php?r=cms/cmsUniversal/deleteElement&&e='.$_GET['e'].'&&id='.$item->id.'" title="Delete" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')"> X</a>
                                $i++;
                            }
                        }
                }
  echo '</ul>';
  ?>
	</div>
<?php
    }






/* Konkretne formularze elementow */
    if($id != 0 ){
        //konkretny element UPDATE
        echo '<div id="mainContent">';

    if($model_element == 'CmsMap'){
        //wyswietla mape dla modelu MAP !

        $map_model = CmsMap::model()->find('id=?',array($id));
Yii::app()->clientScript->registerScript('content','

                                    var map;
                                    var markersArray = [];

                                    function initialize() {
                                      var haightAshbury = new google.maps.LatLng('.$map_model->mapCenter_wide.','.$map_model->mapCenter_long.');
                                      var mapOptions = {
                                        zoom: '.$map_model->zoom.',
                                        center: haightAshbury,

                                        mapTypeControl: true,
                                        mapTypeControlOptions: {
                                          style: google.maps.MapTypeControlStyle.'.$map_model->styleControll.'
                                        },
                                        navigationControl: true,
                                        navigationControlOptions: {
                                          style: google.maps.NavigationControlStyle.'.$map_model->navControllOpt.'
                                        },

                                        mapTypeId: google.maps.MapTypeId.'.$map_model->type.'
                                      };
                                      map =  new google.maps.Map(document.getElementById("map_canvas"), mapOptions);



                                      //google.maps.event.addListener(map, \'click\', function(event) {
                                        //startMarker(haightAshbury);    //wczytany punkt
                                      //});


                                      google.maps.event.addListener(map, \'click\', function(event) {
                                        deleteOverlays();
                                        addMarker(event.latLng);
                                      });
                                    }

                                    //marker startowy
                                    function startMarker(location) {
                                      marker = new google.maps.Marker({
                                          position: location,
                                          map: map,
                                      });
                                      markersArray.push(marker);
                                    }


                                    function addMarker(location) {
                                      marker = new google.maps.Marker({
                                        position: location,
                                        map: map
                                      });
                                      markersArray.push(marker);
                                        var a = location.lat().toFixed(6);
                                        var b = location.lng().toFixed(6);

                                         document.getElementById(\'CmsMap_mapCenter_wide\').value = a;    //lat
                                         document.getElementById(\'CmsMap_mapCenter_long\').value = b; //lng

                                       var c = map.getZoom();
                                         document.getElementById(\'CmsMap_zoom\').value = c;
                                    }

                                    function deleteOverlays() {
                                      if (markersArray) {
                                        for (i in markersArray) {
                                          markersArray[i].setMap(null);
                                        }
                                        markersArray.length = 0;

                                        document.getElementById(\'CmsMap_mapCenter_long\').value = "";
                                        document.getElementById(\'CmsMap_mapCenter_wide\').value = "";
                                      }
                                    }
',CClientScript::POS_HEAD);
    }// end  if($model_element == 'CmsMap'){

        $map_element_model = CmsMapElements::model()->find('id=?',array($id));
        if($model_element == 'CmsMapElements'){
            /* Jesli jestesmy w elementach do map (map_elements) dane (ikonki) sa pobierane z modelu elements_map !! nie z MAP!
             * dlatego skrypt jest zmieniony.
             */
                

                         $skrypt = 'var map;
                                    var markersArray = [];
                                    var def_marker;
                                    function initialize() {
                                      var haightAshbury = new google.maps.LatLng('.$map_element_model->icoCenter_width.','.$map_element_model->icoCenter_long.');
                                      var mapOptions = {
                                        zoom: 16,
                                        center: haightAshbury,

                                        mapTypeControl: true,
                                        mapTypeControlOptions: {
                                          style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                                        },
                                        navigationControl: true,
                                        navigationControlOptions: {
                                          style: google.maps.NavigationControlStyle.SMALL
                                        },

                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                      };
                                      map =  new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

                                      ';

                        if ($map_element_model->id !=0){
                            $skrypt .= 'def_marker = new google.maps.LatLng('.$map_element_model->icoCenter_width.','.$map_element_model->icoCenter_long.');
                                 addDefaultMarker(def_marker);';
                        }

                                     $skrypt .= 'google.maps.event.addListener(map, \'click\', function(event) {
                                        deleteOverlays();
                                        addMarker(event.latLng);
                                      });
                                    }

                                    function addMarker(location) {
                                      marker = new google.maps.Marker({
                                        position: location,
                                        map: map
                                      });
                                      markersArray.push(marker);
                                        var a = location.lat().toFixed(6);
                                        var b = location.lng().toFixed(6);

                                         document.getElementById(\'CmsMapElements_icoCenter_width\').value = a;    //lat
                                         document.getElementById(\'CmsMapElements_icoCenter_long\').value = b; //lng

                                       var c = map.getZoom();
                                         document.getElementById(\'zoom\').value = c;
                                    }



                                    function addDefaultMarker(location) {
                                    var image = \'pictures/map_elements/'.$map_element_model->icon_pic.'\';
                                      marker = new google.maps.Marker({
                                        position: location,
                                        icon: image,
                                        map: map
                                      });
                                      markersArray.push(marker);
                                        var a = location.lat().toFixed(6);
                                        var b = location.lng().toFixed(6);

                                    }



                                    function deleteOverlays() {
                                      if (markersArray) {
                                        for (i in markersArray) {
                                          markersArray[i].setMap(null);
                                        }
                                        markersArray.length = 0;

                                        document.getElementById(\'CmsMapElements_icoCenter_long\').value = "";
                                        document.getElementById(\'CmsMapElements_icoCenter_width\').value = "";
                                      }
                                    }
                ';
        Yii::app()->clientScript->registerScript('content',$skrypt,CClientScript::POS_HEAD);
                }// end if($model_element == 'CmsMapElements'){

        if( ($model_element == 'CmsMap')  || ($model_element == 'CmsMapElements') ){
            //Wyswietlanie mapy w adminie
            echo '<div style="border: 2px solid #6E6552; width:700px; height:320px;  margin-bottom:10px;">
            <div id="map_canvas" style="width:700px; height:320px;  margin-bottom:10px;"></div>';
            //<input onclick="deleteOverlays();" type=button value="Delete"/>
            echo '</div>';
        }

         $form=$this->beginWidget('CActiveForm', array(
                'id'=>'formField',
                'enableAjaxValidation'=>false,
                'htmlOptions' => array('enctype'=>'multipart/form-data'),
        ));


            $model_element = $_GET['e'];
            
            $labels = CActiveRecord::model($model_element)->attributeLabels();           
            //$types = CActiveRecord::model($model_element)->inputTypes();
            
            if($model_element == 'InputTypes'){                
                $types = InputTypes::model()->inputTypesForInputTypes();
            }else{
                $types = InputTypes::model()->getInputTypes($model_element);    
            }            
            $item = CActiveRecord::model($model_element)->findByPk($_GET['id']);

                foreach($labels as $label_key=>$label_value){
                    echo '<div class="choiceOptions">';
                    echo '<div class="formHeader">';
                        CmsUniversal::model()->outputLabels($label_key, $item, $label_key, $form,$this->module->assetsUrl); // dynamicznie pokazuje/ukrywa etykiety
                    echo '</div>';
                        //echo $form->labelEx($item,$label_value);//attributeLabels
                            foreach($types as $type_key=>$type_value){
                                if($label_key == $type_key){
                                    if($type_value['type'] == 'textarea'){
                                        $idEdytora = "elementTiny_".$label_key."";
                                        
                                        $this->widget('application.extensions.elrte.elRTE', array(
                                            'selector'=>$idEdytora,
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
                                    }                                    
                                  CmsUniversal::model()->outputTypes($type_value['type'], $item, $label_key, $form);
                                  break;
                                }
                            }
                    echo '</div>';
                }

            
if($modelName != 'CmsUploadFiles'){            
            echo '<div class="button">';
                     echo CHtml::submitButton($dict_update, array('class'=>'buttonClearForm', 'style'=>'padding-top:0px;'));
            echo '</div>';
}
        echo '</div>'; //class form

$this->endWidget();




    }else{
        //id =0 czyli moge dodac nowy element ADD NEW
        //formularz dodawania nowego
        //
//mapka dla id=0
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/js/map_admin.js',CClientScript::POS_HEAD);

if($model_element == 'CmsMapElements'){
    /* W elemencie zerowym (create new) mapa moze byc wyswietlana z modelu MAP (nie element_map)    
     */
    Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/js/map_admin_elements.js',CClientScript::POS_HEAD);
}
        echo '<div id="mainContent">';

if( ($_GET['e'] == 'CmsMap') || ($model_element == 'CmsMapElements') ){
    //Wyswietlanie mapy w adminie
        echo '<div style="border: 2px solid #6E6552; width:700px; height:320px;  margin-bottom:10px;">
        <div id="map_canvas" style="width:700px; height:320px; margin-bottom:10px;"></div>';
        //<input onclick="deleteOverlays();" type=button value="Delete"/>
        echo '</div>';
}

 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'formField',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype'=>'multipart/form-data'),
));


            $model_element = $_GET['e'];            
            $labels = CActiveRecord::model($model_element)->attributeLabels();           
            //$types = CActiveRecord::model($model_element)->inputTypes();
            if($model_element == 'InputTypes'){                
                $types = InputTypes::model()->inputTypesForInputTypes();
            }else{
                $types = InputTypes::model()->getInputTypes($model_element);    
            }     
            

            //wczytuje podany id i zamienia value na puste '' i leci jako create new            
            $item = new $model_element;

                foreach($labels as $label_key=>$label_value){
                    echo '<div class="choiceOptions">';
                    echo '<div class="formHeader">';
                        CmsUniversal::model()->outputLabels($label_key, $item, $label_key, $form,$this->module->assetsUrl); // dynamicznie pokazuje/ukrywa etykiety
                    echo '</div>';                        
                            foreach($types as $type_key=>$type_value){
                                if($label_key == $type_key){
                                    if($type_value['type'] == 'textarea'){
                                        $idEdytora = "elementTiny_".$label_key."";
                                        
                                        $this->widget('application.extensions.elrte.elRTE', array(
                                            'selector'=>$idEdytora,
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
                                    }
                                   $item[$label_key] = '' ; // zerowanie value w formularzu

                                   CmsUniversal::model()->outputTypes($type_value['type'], $item, $label_key, $form);
                                   break;
                                }
                            }
                    echo '</div>';        
                }



            
            echo '<div class="button">';
                     echo CHtml::submitButton($dict_create, array('class'=>'buttonClearForm', 'style'=>'padding-top:0px;'));
            echo '</div>';

        echo '</div>'; //class form

        

        
$this->endWidget();
    }

/* ---- formularze */
?>