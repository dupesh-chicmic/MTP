<?php

/**
 * This is the model class for table "pl_cms_universal".
 *
 * The followings are the available columns in table 'pl_cms_universal':
 * @property integer $id
 * @property string $table_name
 * @property string $menu_top_label_pl
 * @property string $menu_top_label_en
 * @property string $field_to_display
 * @property integer $group
 * @property string $group_label
 * @property string $label_replace
 * @property string $layout
 * @property integer $display
 * @property string $view_list
 * @property string $view_details
 * @property integer $help
 * @property integer $deletable
 * @property integer $admin_display
 * @property integer $order_by
 * @property string $db_tbl_name
 * @property integer $orderable
 *
 * The followings are the available model relations:
 */
define("FOLDER_MAIN", "main");

class CmsUniversal extends CActiveRecord
{
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return CmsUniversal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_universal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group, display, help, deletable, admin_display, order_by, orderable', 'numerical', 'integerOnly'=>true),
			array('table_name, menu_top_label_pl, menu_top_label_en, field_to_display, group_label, label_replace, layout, view_list, view_details, db_tbl_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, table_name, menu_top_label_pl, menu_top_label_en, field_to_display, group, group_label, label_replace, layout, display, view_list, view_details, help, deletable, admin_display, order_by, db_tbl_name, orderable', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    //'pageElement' => array(self::BELONGS_TO, 'PageElement', 'id_element'),
                    // elementy universalne
                    //'maps' => array(self::HAS_ONE, 'CmsMap', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'table_name' => 'Nazwa modelu(pliku)',
			'menu_top_label_pl' => 'Menu Top Label Pl',
			'menu_top_label_en' => 'Menu Top Label En',
			'field_to_display' => 'Field To Display',
			'group' => 'Grupa',
			'group_label' => 'Etykieta grupy',
			'label_replace' => 'Label Replace',
			'layout' => 'Layout',
			'display' => 'Wyświetlaj',
			'view_list' => 'View List',
			'view_details' => 'View Details',
			'help' => 'Pomoc',
			'deletable' => 'Deletable',
			'admin_display' => 'Admin Display',
			'order_by' => 'Order By',
			'db_tbl_name' => 'Nazwa tabeli z BD',
			'orderable' => 'Orderowany',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('table_name',$this->table_name,true);
		$criteria->compare('menu_top_label_pl',$this->menu_top_label_pl,true);
		$criteria->compare('menu_top_label_en',$this->menu_top_label_en,true);
		$criteria->compare('field_to_display',$this->field_to_display,true);
		//$criteria->compare('group',$this->group);
		$criteria->compare('group_label',$this->group_label,true);
		$criteria->compare('label_replace',$this->label_replace,true);
		$criteria->compare('layout',$this->layout,true);
		$criteria->compare('display',$this->display);
		$criteria->compare('view_list',$this->view_list,true);
		$criteria->compare('view_details',$this->view_details,true);
		$criteria->compare('help',$this->help);
		$criteria->compare('deletable',$this->deletable);
		$criteria->compare('admin_display',$this->admin_display);
		$criteria->compare('order_by',$this->order_by);
		$criteria->compare('db_tbl_name',$this->db_tbl_name,true);
		$criteria->compare('orderable',$this->orderable);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}



        //funkcja ma dodawac zdjecia do kategorii i produktow
        //action = create lub update
        //zwraca sciezke do defaultowego(1) zdjecia
        public function AddPicture($model_e, $path, $action, $staryFolder=null, $def_height=null,$dbFieldPicture=null){
            //skaluje do wysokosci
            /* przyjmuje model oraz sciezke gdzie zapisac zdjecie domyslne
             * $staryFolder=null potrzbny tylko przy UPDATE !
             */

            if($dbFieldPicture==null){
               $dbFieldPicture = 'def_pic';
            }
            
            if(isset($_GET['e'])){
                $stringModel = $_GET['e'];
            }else{
                $stringModel = $model_e;
            }

            //sparwdza czy jest title czy name
            if(isset($model_e->title)){
                $title = $model_e->title;
            }else if(isset($model_e->name)){
                $title = $model_e->name;
            }
            //$title = $model_e->title;
            $id = $model_e->id;
            //majac ID moge generowac nazwe folderu

            //$folder = $title;
            $folder = $model_e->id;
            //zamiana niebezpiecznych znakow na _ !!! createURL jest doskonaly do tego !!!
            $folder = CmsPage::model()->createURL($folder);

//$replace = array('_');
//$folder = str_replace($find, $replace, $folder);


            /* TYLKO DLA GIELDY MUZYCZNEJ !*/
            if(isset($_GET['r'])){
                if( ($_GET['r'] == 'cmsArticle/create') || ($_GET['r'] == 'cmsArticle/update')){
                    $folder = $model_e->id;
                }
            }else{
                $folder = $folder.'_'.$model_e->id;
            }
            /* */

//echo '.'.$path.$folder.''; exit;
//echo $folder;
          //  echo '<p>';
//echo $_GET['r'];
            ///return;
            /* odroznienie CREATE od UPDATE*/
            if($action == 'create'){

                if(file_exists('.'.$path.$folder)){
                    
                    $folder=$folder.$id;
                    echo 'Taki folder juz istnieje ('.$path.$folder.')'; return;
                }
                //else{
                //Michal zmienil przy LP
                //tworze folder

                    mkdir('.'.$path.$folder.'', 0777); //path z ./
                                /* TYLKO DLA GIELDY MUZYCZNEJ !*/
                                if( ($_GET['r'] == 'cmsArticle/create') || ($_GET['r'] == 'cmsArticle/update')){
                                    mkdir('.'.$path.$folder.'/m', 0777); //path z ./
                                    mkdir('.'.$path.$folder.'/d', 0777); //path z ./
                                }
                                /* */
                //} Michal Zmienil
            }else if($action == 'update'){

                    //echo "<p>!empty= ".$path.$staryFolder;
                    $pathOld = $path.$staryFolder;
                    //CmsPage::model()->createURL($oldFolder);//stary folder

                    if(!file_exists($pathOld)){
                        //echo "<p>oldPath".$oldname = $pathOld;
                        //echo "<p>new path".$newname = $path.$folder;

                        $oldfile = $pathOld;
                        $newfile = $path.$folder;
                        //return;
                        rename('.'.$oldfile, '.'.$newfile);

                    }
                    //}else{
                    //    "podaj pelna sciezke";
                    //}
            }



                /* update nazwy folderu do bazy
                 * jesli jest to create to wczesniej stworzyl folder i update do bazy
                 * jesli update to tylko updateuje nowa nazwe folderu do bazy
                 */
                $elem_folder = $model_e->findByPk($id);
                //$elem_folder = CActiveRecord::model($model_e)->findByPk($id);
                $elem_folder->folder = $folder;
                $elem_folder->update(array('folder'));


                // UPDATE
//echo "przed dodaniem obrazka";

                //dodaje zdjecie defaultowe == CREATE + UPDATE
                $image = CUploadedFile::getInstance($model_e,$dbFieldPicture); //def_pic - nazwa pola w bazie!!

                if(!empty($image)){//mam zdjecie

                    if($action == 'update'){
                    //jestem w UPDATE i cos jest dodawane to usuwa istniejace zdjecie
                    //SMIALO, BO WIEM ZE W POSCIE MAM NOWE !! (!EMPTY)
                            echo $directory = '.'.$path.$folder;  //podaje sciezke/nazwa folderu

                            if(file_exists($directory)){
                                $dir = opendir($directory); //otworzenie folderu
                            }else{ echo "Nie znalazłem folderu z kategoriami"; return;}

                            while($plik_nazwa = readdir($dir))  //odczytywanie
                            {
                                if(($plik_nazwa!=".")&&($plik_nazwa!="..")) //jesli element != "." i ".."   sprawdze prawidlowo folder w przeciwnym wypadku wyklucza elementy "." i ".."
                                {
                                    //echo '<div class="text_content"><img src="'.$directory.'/'.$plik_nazwa.'" /></a></div>';
                                    //usuwam stary plik defoultowy

                                    if (!file_exists($plik_nazwa)){
                                        echo $path_m = '.'.$path.$folder.'/'.$plik_nazwa.'';
                                        unlink($path_m);
                                    }else{
                                        echo "Plik nie istnieje"; return;
                                    }
                                }
                            }
                    }// end if($action == 'update'){

                    $file_name = $image;

                    $file_extension = substr($file_name, -3);//zostawia tylko jpg/png/gif
                    $typ = $image->getType();//np. images/jpeg
                    //generuje nazwe pliku
                    $file_name = time().'_thumb.'.$file_extension;

                    if($typ == 'image/jpeg' || $typ == 'image/png' || $typ == 'image/gif'){
                            //zapisuje 2 thumby
                            //if(file_exists($folder)){
                            $image->saveAs('.'.$path.$folder.'/'.$file_name); //false = nie usuwa z tempa //path z ./

                            $path_m = $path.$folder.'/'.$file_name;

                            if(empty($model_e->def_pic_width)){
                                $def_width = 800;
                            }else if(!empty($def_width)){
                                $def_width = $this->$def_width;
                            }

                            
                            $img = CmsGallery::model()->ImgResize(170,$def_width, $path_m);

                            // wrzuc do bazy nazwe
                            //$def_picture = $model_e::model()->findByPk($id);
                            $def_picture = CActiveRecord::model($stringModel)->findByPk($id);
                            $def_picture->def_pic = $img;
                            $def_picture->update(array($dbFieldPicture));

                            /* */
                            //}

                            //usuwanie thumba m i d
                            if (!file_exists($file_name)){
                                $path_m = '.'.$path.$folder.'/'.$file_name.'';//path z ./
                                unlink($path_m);
                            }else{
                                echo "Plik nie istnieje"; return;
                            }

                        }else{
                            echo "Błąd"; return;
                        }

                        return $path_m;
                }//end if(!empty($image)){
                else{
                    //zostaw stary NIC NIE MAM W POSCIE!
                    //UPDATE I CREATE (nie zostalo dodane zdjecie)
                    if($action == 'create'){}
                    if($action == 'update'){
                        //zachowuje stare zdjecie
                    }

                }



        }// end function


        public static function checkDateTime($model, $date_time){

            $inputTypes = InputTypes::model()->getInputTypes($model);

                $pola_z_date_time = array();
                foreach($inputTypes as $key => $value){
//echo $key.' = '; // bedzie data_waznosci
//echo $value['type'].'<p>'; // bedzie date_time

                    if($value['type'] == $date_time){
                        //echo $key;
                        $pola_z_date_time[] = $key;
                    }

                }
                return $pola_z_date_time;

        }

        public function getModelName()
        {
            return __CLASS__;
        }

        public static function getModelNameAndGenerateFolder($model_e){
             $model_e = strtolower($model_e);
             $name = substr($model_e, 0, 3); //tylko cms
             if($name == 'cms'){
               return $correct = substr($model_e, 3);//zostawia tylko jpg/png/gif
             }else{
                 return $correct = $model_e;
             }

        }

        public static function getImageSize($poleDB, $typ){
            $rozmiary = array('image' => array('small'=>array('height'=>115, 'width'=>165), 'medium'=>array('height'=>250, 'width'=>350), 'large'=>array('height'=>800, 'width'=>600), 'default'=>array('height'=>200, 'width'=>231)));
            return $rozmiary[$poleDB][$typ];
        }

        
        
        
        
        
        
        /* PODSTAWOWE FUNKCJE UNIWERSALNYCH ELEMENTOW W CMS */

      public function outputLabels($type, $model_e, $element_label, $form_e, $assetsUrl){

            switch($type){
                case 'id':
                    //echo "hidden";
                    //echo $form_e->labelEx($model_e,'hidden ID');//attributeLabels
                    break;
                case 'folder':
                    break;
                case 'def_pic_width':
                    break;
                case 'image':
                    if(!isset($_GET['edit'])){//create new
                        echo $form_e->labelEx($model_e,$element_label);//attributeLabels
                    }else{
                        echo $form_e->labelEx($model_e,$element_label);//attributeLabels                        
                    }
                    break;
                case 'order':
                    if(!isset($_GET['edit'])){//create new
                        echo $form_e->labelEx($model_e,$element_label);//attributeLabels
                    }else{
                    }
                    break;                    
                
                case 'display':
                    echo $form_e->labelEx($model_e,$element_label);
                    echo '<div class="iconExit"><img style="width:25px; height:25px;" src="'.$assetsUrl.'/images/admin/img/lupa.png" alt="(!)"></div>';
                    break;
                    
                case 'uploadedFile':
                    if(!isset($_GET['edit'])){//create new
                        echo $form_e->labelEx($model_e,$element_label);//attributeLabels
                    }else{
                    }
                    break;                    
                case 'mapControll':
                    //w bazie i w skrypcie JS jest domyslnie true
                    break;
                case 'navControll':
                    //w bazie i w skrypcie JS jest domyslnie true
                    break;
                case 'featured':
                    echo $form_e->labelEx($model_e,$element_label);//attributeLabels
                    break;
                case 'linkToFile':
                    if(!isset($_GET['edit'])){//create new                        
                    }else{
                        echo $form_e->labelEx($model_e,$element_label);//attributeLabels
                    }                    
                    break;
                case 'layout_id':
                    break;
                
                case 'layout_fileGenerator':
                    break;
                    
                default:
                    /* kazda nie majaca specjalnej akcji Create/Update */
                    echo $form_e->labelEx($model_e,$element_label);//attributeLabels
                    break;
            }
      }


      public function outputTypes($type, $model_e, $element_name, $form_e){
            switch($type){
                case 'hidden':
                    //echo "hidden";
                    break;
                case 'varchar':
                    //public static string textField(string $name, string $value='', array $htmlOptions=array ( )) *doc                                     
                    echo $form_e->textField($model_e,$element_name,array('size'=>60,'maxlength'=>100,'class'=>'inputField iputBackground'));                
                    break;
                case 'textarea':
                    /* widget z tiny jest w ladowany w widoku modelElements.php */                   
                    echo '<div class="edit">';
                    $idEdytora = 'elementTiny_'.$element_name;
                        echo $form_e->textArea($model_e,$element_name,array('rows'=>20, 'cols'=>50,'id'=>$idEdytora,'class'=>'tinyForm'));
                    echo '</div>';
                    break;
                
                case 'textarea_no_tiny':
                    // zwykle pole tekstowe
                    echo $form_e->textArea($model_e,$element_name,array('rows'=>20, 'cols'=>50,'class'=>'inputBackgroundBig'));
                    break;
                
                case 'int':
                    echo $form_e->textField($model_e,$element_name,array('size'=>10,'maxlength'=>50,'class'=>'inputField iputBackground'));
                    break;
                
                case 'float':
                    echo $form_e->textField($model_e,$element_name,array('size'=>10,'maxlength'=>50,'class'=>'inputField iputBackground'));
                    break;
                
                case 'layout_id':    
                    if($_GET['id'] == 0){//nowy element
                        $sql = "SELECT max(layout_id) FROM `cms_layouts`";

                        $connection = Yii::app()->db;
                        $command = $connection->createCommand($sql);
                        $results = $command->queryAll();

                        $maxLayId = $results[0]['max(layout_id)'];
                        $maxLayId += 1;

                        echo $form_e->hiddenField($model_e,$element_name,array('value'=>$maxLayId));
                    }
                    break;
                
                case 'layout_fileGenerator':
                    // kontroler wygeneruje plik tam mam nazwe ktora uzyje
//                    var_dump($element_name);
//                    exit;
//                    $layoutFileName = 'layout_subPage';
//                    echo $form_e->hiddenField($model_e,$element_name,array('value'=>$layoutFileName));
                    break;
                
                case 'select':                    
                        if($_GET['e'] == 'InputTypes'){                
                            $lista = InputTypes::model()->inputTypesForInputTypes();
                        }else{                            
                            $lista = InputTypes::model()->getInputTypes($_GET['e']);
                        }
                    echo $form_e->dropDownList($model_e,$element_name,$lista[$element_name]['value_list'], array('class'=>'inputField','style'=>'padding-top:10px;'));
                break;
            
                case 'listBox':
                    echo $form_e->hiddenField($model_e,$element_name,array('value'=>'0'));                    
                    $modelName = $_GET['e'];
                    if($modelName == 'CmsShopProduct'){
                        $modelNameCategory = 'CmsShopCategories';
                    }else{
                        $modelNameCategory = $modelName;
                    }
                    //$model = CActiveRecord::model($modelName)->find('id=?', array($id));
                    
                    if(isset($_GET['id'])){                                
                            echo CActiveRecord::model($modelNameCategory)->getCategorySelects(0, "", $modelNameCategory.'_parent_cat', $_GET['id']);
                        }else{
                            echo CActiveRecord::model($modelNameCategory)->getCategorySelects(0, "", $modelNameCategory.'_parent_cat', 0);
                        }                           
                break;

                case 'date':
                    if(!isset($_GET['edit'])){ //create
                        $date = date("Y-m-d");                                                
                        echo $form_e->textField($model_e,$element_name,array('value'=>$date,'id'=>"datepicker",'class'=>'inputField iputBackground'));
                    }else{//update
                        $style='style="color:#CC3333; background:#EEEEEE;"';
                        echo $form_e->textField($model_e,$element_name,array('id'=>"datepicker",'class'=>'inputField iputBackground'));
                    }
                    
                    //echo $form_e->textField($model_e,$element_name,array('id'=>"datepicker",'class'=>'inputField iputBackground'));
                break;
                case 'added_date':
                    if(!isset($_GET['edit'])){ //create
                        $date = date("Y-m-d");
                        $time = date("H:i:s");
                        echo $date = $date.' '.$time;
                        echo $form_e->hiddenField($model_e,'added',$htmlOptions = array("value"=>$date));
                    }else{//update
                        $style='style="color:#CC3333; background:#EEEEEE;"';
                        echo $form_e->textField($model_e,'added',array('size'=>60,'maxlength'=>500, 'readonly'=>"readonly", $style=>''));
                    }
                    //echo $form_e->textField($model_e,$element_name,array('id'=>"datepicker"));
                break;
                case 'date_time':

                    if(isset($_GET['id'])){                      
                        if($_GET['id'] == 0){//nowy element
                            $aktualna_data = date("Y-m-d");
                            $aktualny_czas = date("H:i:s");
                            echo $form_e->textField($model_e,$element_name,array('id'=>"datepicker",'value'=>$aktualna_data));
                            echo $form_e->textField($model_e,$element_name."_time",array('value'=>$aktualny_czas));
                        }else{//update          
                            $data_z_bazy = $model_e->$element_name;
                            $data_z_bazy = substr($data_z_bazy, 0, 10); //obcina od 10znaku dalej

                            $czas_z_bazy = $model_e->$element_name;
                            $czas_z_bazy = substr($czas_z_bazy, -8); //zostawia ostatnie 8 znakow

                            echo $form_e->textField($model_e,$element_name,array('id'=>"datepicker",'value'=>$data_z_bazy));
                            echo $form_e->textField($model_e,$element_name."_time",array('value'=>$czas_z_bazy));
                        }
                    }
                break;
                case 'image':
                    if(!isset($_GET['edit'])){ //create
                        echo CHtml::activeFileField($model_e, $element_name, array('class'=>'inputField'));
                    }else{
                        //update
                        //echo $form_e->hiddenField($model_e,$element_name);
                        echo CHtml::activeFileField($model_e, $element_name, array('class'=>'inputField'));                        
                    }
                    //$this->beginWidget('CActiveForm', array('id'=>'activity_form', 'enableAjaxValidation'=>true, 'stateful'=>true, 'htmlOptions'=>array('enctype' => 'multipart/form-data')));
                    break;
                case 'def_image':                        
                    echo CHtml::activeFileField($model_e, $element_name, array('class'=>'inputField'));    
                    if(isset($_GET['edit'])){ //create
                        $dict_adm_nadpisanie_defaulta = 'Overwrite the default picture?';
                        
                        //var_dump($element_name);exit;
                        $plikImage = CmsPage::model()->getElement('id', $_GET['id'], $_GET['e'], $element_name);
                        
                        if($_GET['e'] == 'InputTypes'){                
                            $types = InputTypes::model()->inputTypesForInputTypes();
                        }else{                            
                            $types = InputTypes::model()->getInputTypes($_GET['e']);
                        }
                        
                        $getFolder = CmsPage::model()->getElement('id', $_GET['id'], $_GET['e'], 'folder');
                        if( empty($getFolder) ){
                            $folder = $_GET['id'];
                        }else{
                            $folder = $getFolder;
                        }               
						
                        if( is_array($types['image']['folder_structure'])){
                            $directory = $types['image']['folder_name'].$folder.'/m/'.$plikImage;
                        }else{
                            $directory = $types['image']['folder_name'].$folder.'/'.$plikImage;
                        }                        
                        echo'<img style="max-width:45px; height:45px;" src="'.$directory.'" alt="" />';
                        echo '<div class="error_msg_def_pic">'.$dict_adm_nadpisanie_defaulta.'</div>';
                    }
                    break;   
                case 'file':
                    if(!isset($_GET['edit'])){ //create
                        echo CHtml::activeFileField($model_e, $element_name, array('class'=>'inputField'));
                    }else{
                        //update
                        echo $form_e->hiddenField($model_e,$element_name);
                    }
                    //$this->beginWidget('CActiveForm', array('id'=>'activity_form', 'enableAjaxValidation'=>true, 'stateful'=>true, 'htmlOptions'=>array('enctype' => 'multipart/form-data')));
                    break;                       
                case 'varcharLinkToFile':
                    if(!isset($_GET['edit'])){ //create
                        echo $form_e->hiddenField($model_e,$element_name);                        
                    }else{
                        //update                        
                        $style='style="color:#CC3333; background:#DDDDDD; border:1px solid #E9E9E9;"';
                        echo $form_e->textField($model_e,$element_name,array('size'=>60,'maxlength'=>100, 'readonly'=>"readonly", $style=>'','class'=>'inputField iputBackground'));
                    }
                    break;                    
                    
                case 'order':
                    if(!isset($_GET['edit'])){ //create
                        if($_GET['e'] == 'InputTypes'){                
                            $lista = InputTypes::model()->inputTypesForInputTypes();
                        }else{                            
                            $lista = InputTypes::model()->getInputTypes($_GET['e']);
                        }   
                        
                        echo $form_e->dropDownList($model_e,$element_name,$lista[$element_name]['value_list'], array('class'=>'inputField','style'=>'padding-top:10px;'));
                    }else{
                        //update
                        echo $form_e->hiddenField($model_e,$element_name);
                    }                 
                    break;
                  
               case 'featured':
                    //if(!isset($_GET['edit'])){ //create
                    echo CHtml::activeFileField($model_e, $element_name);
                    //}else{
                        //update
                        //echo $form_e->hiddenField($model_e,$element_name);
                    //}
                    //$this->beginWidget('CActiveForm', array('id'=>'activity_form', 'enableAjaxValidation'=>true, 'stateful'=>true, 'htmlOptions'=>array('enctype' => 'multipart/form-data')));
                    break;
                
                case 'folder':
                    echo $form_e->hiddenField($model_e,$element_name);
                    break;
            
                case 'getLayout':
                    $criteria=new CDbCriteria;
                    //$criteria->order='`name`';
                    $criteria->select="*";
                    $criteria->compare('parent_id', 3);
                    $criteria->compare('function', 'f_normal_page');
                    $model=new CmsPage;
                    $lista = CHtml::listData(CmsPage::model()->findAll($criteria), 'id', 'link_name');

                    //echo $form_e->dropDownList($model,'id',CHtml::listData(CmsPage::model()->findAll($criteria), 'id', 'link_name'));
                    echo $form_e->dropDownList($model_e,$element_name,$lista);
                    //echo $form_e->dropDownList($model_e,$element_name,$lista[$element_name]['value_list']);
                    break;

                /* gallery */
                case 'gallery_group':
                    $criteria=new CDbCriteria;
                    //$criteria->order='`name`';
                    $criteria->select="*";
//                    $criteria->compare('parent_id', 3);
//                    $criteria->compare('function', 'f_normal_page');
                    $criteria->condition='( parent_id > 1 )'; 
                    $lista = CHtml::listData(CmsPage::model()->findAll($criteria), 'id', 'link_name');

//                    $criteria=new CDbCriteria;
//                    $criteria->order='`txt`';
//                    echo $form->dropDownList($model,'group',CHtml::listData(CmsDictionary::model()->dictionaryGetGroup('front_location_media'), 'value', 'txt'));
                    echo $form_e->dropDownList($model_e,'group',$lista);
                    
                    break;
                /* end gallery */
                
                default:
                    break;
            }
            
      }
        /* -------- */
      
    function getCategoryTree($level, $parentId, $elementModelName, $parentDBField, $out){

            $criteria=new CDbCriteria;
            $criteria->compare($parentDBField,$parentId);
            //$sub_element = $elementModelName::model()->findAll($criteria);
            $sub_element  = CActiveRecord::model($elementModelName)->findAll($criteria);
            foreach($sub_element as $item){
                $out[$level][$parentId][] = array("id"=>$item['id'], "name"=>$item['name']);
                $out = getCategoryTree($level+1, $item['id'], $elementModelName, $parentDBField, $out);
            }
            return $out;
        }        
        
        
        
        
        
        /* QBIX - CMS != demo */  
        public function menuTop_2(){
            $criteria=new CDbCriteria;            
            $criteria->select="id,title,url";
            $criteria->compare('parent_id', 169);
            $criteria->order = '`order`';
            $modelPage = CmsPage::model('CmsPage')->findAll($criteria);                        
            
            echo '<div class="down">';
                foreach($modelPage as $page){
                    if($page['id'] == 180){ $class = 'strony'; }
                    else if($page['id'] == 181){ $class = 'sklepy'; }
                    else if($page['id'] == 182){ $class = 'apps'; }
                    else{
                        $class='';
                    }
                    echo '<a href="'.Yii::app()->baseUrl.'/index.php?r=cmsPage/displayPage&url='.$page['url'].'" class="'.$class.'"><div>'.$page['title'].'</div></a>';
                }
            echo '</div>';
        }
        
     
        /* ----- */
        
}