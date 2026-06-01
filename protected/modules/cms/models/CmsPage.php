<?php

/**
 * This is the model class for table "pl_cms_page".
 *
 * The followings are the available columns in table 'pl_cms_page':
 * @property integer $id
 * @property integer $parent_id
 * @property string $url
 * @property string $name
 * @property string $title
 * @property string $header
 * @property string $link_name
 * @property string $keywords
 * @property string $function
 * @property string $layout
 * @property string $template
 * @property string $seo_visible
 * @property string $seo_unvisible
 * @property string $param_1
 * @property string $param_2
 * @property string $txt
 * @property string $button
 * @property integer $order
 * @property integer $editable
 * @property integer $display
 * @property string $description
 * @property integer $deletable
 * The followings are the available model relations:
 */
class CmsPage extends CmsActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CmsPage the static model class
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
                return parent::prefixTableName('pl_cms_page');
		//return 'pl_cms_page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link_name, editable', 'required'),
			array('parent_id, order, editable, display, deletable', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>700),
			array('name, title, header, link_name, function, layout, template, seo_visible, seo_unvisible, param_1, param_2, button', 'length', 'max'=>500),
			array('txt, description, keywords', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, url, name, title, header, link_name, keywords, function, layout, template, seo_visible, seo_unvisible, param_1, param_2, txt, button, order, editable, display, description, deletable', 'safe', 'on'=>'search'),
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
                    'pageElement' => array(self::HAS_ONE, 'PageElement', 'id_page'),
                    'cmsLayouts' => array(self::BELONGS_TO, 'CmsLayouts', 'layout'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            if(Yii::app()->language == 'pl'){
                return array(
			'id' => 'ID',
			'parent_id' => 'Rodzic (menu)',
			'url' => 'Url',
			'name' => 'Nazwa',
			'title' => 'Tytuł',
			'header' => 'Nagłówek',
			'link_name' => 'Nazwa linku',
			'keywords' => 'Słowa kluczowe',
			'function' => 'Funkcja',
			'layout' => 'Layout',
			'template' => 'Szablon',
			'seo_visible' => 'Seo Visible',
			'seo_unvisible' => 'Seo Unvisible',
			'param_1' => 'Param 1',
			'param_2' => 'Param 2',
			'txt' => 'Tekst',
			'button' => 'Przycisk',
			'order' => 'Kolejność',
			'editable' => 'Edytowalny',
			'display' => 'Publikuj',
                        'description' => 'Opis (meta tag)',
			'deletable' => 'Usuwalny',
                        'id_map' => 'Mapa',
			'id_gallery' => 'Galeria',
			//'id_video' => 'Wideo',
		);

            }else{

		return array(
			'id' => 'ID',
			'parent_id' => 'Parent(menu)',
			'url' => 'Url',
			'name' => 'Name',
			'title' => 'Title',
			'header' => 'Header',
			'link_name' => 'Link name',
			'keywords' => 'Keywords',
			'function' => 'Function',
			'layout' => 'Layout',
			'template' => 'Template',
			'seo_visible' => 'Seo Visible',
			'seo_unvisible' => 'Seo Unvisible',
			'param_1' => 'Param 1',
			'param_2' => 'Param 2',
			'txt' => 'Text',
			'button' => 'Button',
			'order' => 'Order',
			'editable' => 'Editable',
			'display' => 'Publish',
                        'description' => 'Description',
			'deletable' => 'Deletable',
                        'id_map' => 'Map',
			'id_gallery' => 'Gallery',
			//'id_video' => 'Video',
		);
            }
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('header',$this->header,true);
		$criteria->compare('link_name',$this->link_name);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('function',$this->function,true);
		$criteria->compare('layout',$this->layout,true);
		$criteria->compare('template',$this->template,true);
		$criteria->compare('seo_visible',$this->seo_visible,true);
		$criteria->compare('seo_unvisible',$this->seo_unvisible,true);
		$criteria->compare('param_1',$this->param_1,true);
		$criteria->compare('param_2',$this->param_2,true);
		$criteria->compare('txt',$this->txt,true);
		$criteria->compare('button',$this->button,true);
		$criteria->compare('order',$this->order);
		$criteria->compare('editable',$this->editable);
		$criteria->compare('display',$this->display);
                $criteria->compare('description',$this->description,true);
		$criteria->compare('deletable',$this->deletable);
                $criteria->compare('id_map',$this->id_map);
		$criteria->compare('id_gallery',$this->id_gallery);
		$criteria->compare('id_video',$this->id_video);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public static function getURL($url){
/*Zwraca url strony
 * Jesli jest przekierowanie to zwraca przekierowanie jak nie to zwykly URL
 */
//echo "<br>mam ".$url;

             $criteria = new CDbCriteria;
             $criteria->select='*';
             $criteria->compare('`url`', $url); //biore param_1 dla url=$url
             $redirection = CmsPage::model()->findAll($criteria);

                    foreach($redirection as $item){
                        //echo $txt = '<br>param1: '.$item['param_1'];
                        //echo $txt = '<br>URL: '.$item['url'];
                        //if( $item['param_1'] != '' ){
                        if( !empty($item['param_1']) ){
//                            if($item['param_2'] != null){
//                                //oznacza ze to jest np CmsCatgory/Gallery itp.
//
//                            }

                            return $item['param_1'];
                        }
                        else{
                            return $item['url'];
                        }
                    }
        }

        public static function checkURL($prop_url){
/*
             $criteria = new CDbCriteria;
             $criteria->select='*';
             $criteria->compare('`url`', $prop_url);
             $result = CmsPage::model()->findAll($criteria);
             if (isset($result)){  return true;
             }else{ return false;  }
 */
             $criteria = new CDbCriteria;
             $criteria->select='*';
             $criteria->compare('`url`', $prop_url);
             $result = CmsPage::model()->findAll($criteria);
             if (empty($result)){
                return true;
             }//podmieni przerobiona nazwe na urla
             else{
                return false;
             }//zostawi stary URL
       }

        public static function createURL($name){
//zamienia znaki
            $out = str_replace('ą', 'a', $name);
            $out = str_replace('Ą', 'a', $out);
            $out = str_replace(' ', '_', $out);
            $out = str_replace('ż', 'z', $out);
            $out = str_replace('ź', 'z', $out);
            $out = str_replace('ć', 'c', $out);
            $out = str_replace('ń', 'n', $out);
            $out = str_replace('ó', 'o', $out);
            $out = str_replace('ł', 'l', $out);
            $out = str_replace('ś', 's', $out);
            $out = str_replace('ę', 'e', $out);
            $out = str_replace('Ż', 'z', $out);
            $out = str_replace('Ź', 'z', $out);
            $out = str_replace('Ć', 'c', $out);
            $out = str_replace('Ń', 'n', $out);
            $out = str_replace('Ó', 'o', $out);
            $out = str_replace('Ł', 'l', $out);
            $out = str_replace('Ś', 's', $out);
            $out = str_replace('Ę', 'e', $out);
            $out = str_replace('?', '', $out);
            $out = str_replace('\'', '', $out);
            $out = str_replace('!', '', $out);
            $out = str_replace('@', '', $out);
            $out = str_replace('"', '', $out);
            $out = str_replace('\'', '&acute', $out);
            $out = str_replace('®', '&reg', $out);
            $out = str_replace('®', '&reg', $out);
            $out = str_replace(';', '', $out);
            $out = str_replace(':', '', $out);
            $out = str_replace('#', '', $out);
            $out = str_replace('$', '', $out);
            $out = str_replace('%', '', $out);
            $out = str_replace('^', '', $out);
            $out = str_replace('&', '', $out);
            $out = str_replace('(', '', $out);
            $out = str_replace(')', '', $out);
            $out = str_replace('*', '', $out);
            $out = str_replace('+', '', $out);
            $out = str_replace('-', '', $out);


            $out = strtolower($out);
   // $id_con = Yii::app()->db;
   // $db=@mysql_connect('localhost','root','root' );

           // $out = mysql_real_escape_string($out,$db);
            return $out;

        }
    public static function existsURL($prop_url){
/* Sprawdza czy dany URL jest w bazie
 * jesli istnieje to do nazwy doda liczbe (nazwa_12)
 * zaraz po dodaniu jeszcze raz sprawdzi czy ta nazwa istnieje jesli jakims cudem tak to doda kolejna liczbe tylko z innego zakresu
 * na koniec zwraca wynik
 */
             $criteria = new CDbCriteria;
             $criteria->select='url';
             $criteria->compare('`url`', $prop_url);
             $result = CmsPage::model()->findAll($criteria);
             if( !empty($result) ){ //cos MA
                 //echo "Znalazlem taki sam URL<br>";
                 //$a = "DODAJ_COS_BO_JA_JUZ_ISTNIEJE";
                 $rand = rand(1, 1000);
                 $prop_url = $prop_url."_".$rand; //final v0.1

                     $criteria->select='url';
                     $criteria->compare('`url`', $prop_url);//url z rand
                     $result = CmsPage::model()->findAll($criteria); //sprawdzam czy juz zmieniony jest w bazie
                         if( !empty($result) ){ //jesli cos znowu MA (lucky bastard :P)
                             $rand = rand(1001,2000);
                             $final_url = $prop_url."_".$rand; //final v0.2 po 2 losowaniach
                             return $final_url;
                         }
                 $final_url = $prop_url;//url z rand
                 return $final_url;
             }else{
                 //echo "Nie ma takiego - dodawaj<br>";
                 //return true;
                 $final_url = $prop_url;
                 return $final_url;
             }
    }

        public static function checkURLbyID($url,$id){

             $criteria = new CDbCriteria;
             $criteria->select='url';
             $criteria->compare('`id`', $id); //wez url dla id=$id
             //AND
             $criteria->compare('`url`', $url);
             $result = CmsPage::model()->findAll($criteria);

             if( !empty($result) ){ //jesli cos znajdzie
                return true;
             }else{
                return false;
             }
        }

        public static function getFunction($url){
//echo $url; //ma
             $criteria = new CDbCriteria;
             $criteria->select='*';
             //$criteria->compare('`id`', $id); //wez * dla id=$id
             //AND
             $criteria->compare('`url`', $url);
             $result = CmsPage::model()->findAll($criteria);

                    foreach($result as $function){
                        if( !empty($function['function']) ){
                            return $function['function'];
                        }
                        else{
                            //return $item['url'];
                        }
                    }
        }


        public static function getId_ByUrl($url){
//echo $url; //ma
             $criteria = new CDbCriteria;
             $criteria->select='*';
             //$criteria->compare('`id`', $id); //wez * dla id=$id
             //AND
             $criteria->compare('`url`', $url);
             $result = CmsPage::model()->findAll($criteria);

                    foreach($result as $id){
                        if( !empty($id['id']) ){
                            return $id['id'];
                        }
                        else{
                            //return $item['url'];
                        }
                    }
        }

        //uniwersalny
        public static function getElement($key, $val, $model_p,$what='id'){ //np. select * from model_p where $key=$val (id = 5)
        /* jako element podajemy co chcemy otrzymac jesli id to w wywolaniu podajemy 'id' */
             $criteria = new CDbCriteria;
             $criteria->select='*';
             $criteria->compare('`'.$key.'`', $val);
             $result = CActiveRecord::model($model_p)->find($criteria);
             return $result[$what];
        }

        public function getRow($model_p,$key,$val){
             $criteria = new CDbCriteria;
             $criteria->select='*';
             $criteria->compare('`'.$key.'`', $val);
             $result = CActiveRecord::model($model_p)->find($criteria);
             return $result;
        }
        public static function queryWithAnd($key, $val, $andKey_2, $andVal_2, $model_p, $table, $what='id'){
             $criteria = new CDbCriteria;
             $criteria->select='*';


             //AND `'.$andKey_2.'` = '.$andVal_2.'


             // $criteria->compare('`id`', $id); //wez * dla id=$id
             //AND
             //$criteria->compare('`'.$key.'`', $val);
             //$criteria->compare('`'.$andKey_2.'`', $andVal_2);
             //$criteria->condition = "'.$key.' = :'.$val.' AND '.$andKey_2.' ='.$andVal_2.'";
             //$criteria->condition='( ('.$key.' = :'.$val.') AND ('.$andKey_2.' = :'.$andVal_2.') )';
             $query = 'SELECT * FROM `'.$table.'` WHERE  `'.$key.'` = \''.$val.'\' AND `'.$andKey_2.'` = '.$andVal_2.' ';
             //$result = CmsPage::model()->findAll($criteria);
             //$model = 'CmsGallery';
             //$result = $model_p::model()->find($criteria);
             $result = CActiveRecord::model($model_p)->findBySql($query);
            //$what = 'parent_id';
             return $result[$what];
        }


        public static function getElementList($model_p){
            // $out = $model_p::model()->findAll();
             $out = CActiveRecord::model($model_p)->findAll();
             return $out;
        }

        public static function BackupDateBase(){

                        $db_user = Yii::app()->getDb()->username;
                        $db_password = Yii::app()->getDb()->password;
                        $host = Yii::app()->getDb()->connectionString;

                        $host = explode('=',$host);
                        $hostName = explode(';',$host[1]);
                        $db_host = $hostName[0];
                        $db_name = $host[2];

            $where = "backup/";
            echo $backupFile = $where.$db_name."_". date("d.m.Y_H-i-s");
            $backup = "mysqldump -u $db_user -p$db_password -h $db_host $db_name > $backupFile.sql";    //work!!!!

            system($backup,$status);
            if($status == 1){
                "Kopia wykonana poprawnie";
            }else{
                "Kopia nie została wykonana";
            }


        }

        public static function RestoreDateBase($dataBase){

                        $db_user = Yii::app()->getDb()->username;
                        $db_password = Yii::app()->getDb()->password;
                        $host = Yii::app()->getDb()->connectionString;

                        $host = explode('=',$host);
                        $hostName = explode(';',$host[1]);
                        $db_host = $hostName[0];
                        $db_name = $host[2];

            // < all-DATABASES.dump  //dla wszystkich baz
            $backupFile = "backup/".$dataBase;
            $restore = "mysql -u $db_user -p$db_password -h $db_host $db_name < $backupFile";    //work!!!!
            system($restore);
        }


        //zwraca order pierwszy =0 , kolejny= n+1, ostatni = ostatni+1
        public static function GetOrder($model_o, $order, $table){
            //var_dump($model_o);exit;
            if($order == 0){
              //zapytanie robi update na wszystkich orderach w bazie w danym modelu
              $order++;
                $transaction = Yii::app()->db->beginTransaction();
                try
                {
                       $sql = 'UPDATE `'.$table.'` SET `order`= `order`+1;';

                        $command = Yii::app()->db->createCommand($sql);
                        $command->execute();
                     $transaction->commit();

                }
                catch(Exception $e) // jeśli zapytanie nie powiedzie się, wołany jest wyjątek
                {
                    echo "<br>Rzuca wyjatek: ".$e;
                    $transaction->rollBack();
                }

            }else if($order == 999999){
                 //echo "OSTATNI";
                 $criteria = new CDbCriteria;
                 $criteria->select='*';
                 $criteria->condition='`order`<\''.$order.'\' order by `order` DESC LIMIT 1'; //where

                 //$result = $model_o::model()->findAll($criteria);
                 $result = CActiveRecord::model($model_o)->findAll($criteria);

                    foreach($result as $return){
                            $orderRet = $return['order'].'<br>';
                        }
                        $orderRet = $orderRet+1;

                     //999999
                     $criteriaO = new CDbCriteria;
                     $criteriaO->select='*';
                     $criteriaO->condition='`order`=\''.$order.'\' order by `order` DESC LIMIT 1'; //where

                     //$result = $model_o::model()->findAll($criteriaO);
                     $result = CActiveRecord::model($model_o)->findAll($criteriaO);
                            foreach($result as $return){
                                    $id = $return['id']; //999999
                                }

                            //$newLastOrder = $model_o::model()->find('id=?', array($id));
                            $newLastOrder = CActiveRecord::model($model_o)->find('id=?', array($id));
                            $newLastOrder->order = $orderRet;
                            $newLastOrder->update(array('order'));
                        return;
            }

        }




    public static function isOnActivePath($current_page_id, $menu_tree_path){

//    echo "<br>is on path active id:".$current_page_id;
    if (!empty($menu_tree_path)){
            foreach ($menu_tree_path as $menu_item){
//                echo "<br>checking id:".$menu_item;
               // echo "<br/>comp:".$menu_item."-".$current_page_id;
                if ($menu_item == $current_page_id) return true;
            }
        }
        return false;
    }


    public function getMenuActivePath($elementClass, $dbParentFieldName, $activeElementId){
        $activePath = array();
        $activePath[]=$activeElementId;
   //     echo "<br>active:".$activeElementId;

        //$model_tmp = $elementClass::model()->findByPk($activeElementId);
        $model_tmp = CActiveRecord::model($elementClass)->findByPk($activeElementId);

                if($model_tmp) {
                    $parent_id = $model_tmp->$dbParentFieldName;
                } else {
                    //szczegoly ogloszenia
                    if(isset($_GET['cat_id'])){
                        $parent_id = $_GET['cat_id'];
                    }else{
                        $parent_id = $_GET['id'];
                    }
                    //break;
                }
        //echo $parent_id = $model_tmp->$dbParentFieldName;
        //return;
        $activePath[]=$parent_id;
        //echo $parent_id;return;
        //echo "<br/>tutaj:".$parent_id;
        while ($parent_id!=0 or $parent_id!=null){
                //$model_tmp = $elementClass::model()->findByPk($parent_id);
                $model_tmp = CActiveRecord::model($elementClass)->findByPk($parent_id);

                if($model_tmp) {
                    $parent_id = $model_tmp->$dbParentFieldName;
                } else {
                    //$parent_id = 0;
                    break;
                }
                    //$parent_id = $model_tmp->$dbParentFieldName;
                    $activePath[]=$parent_id;
                    //echo "<br>on path id:".$parent_id;
                   // if ($parent_id == 0) break;
                    //echo $parent_id;
                }

        return $activePath;

    }



   function getSubmenu($categories, $level_p, $activePath, $assetsUrl){
        $dict_na_pewno_usunac = Yii::t(Yii::app()->language.'_YiiTranslation', 'Are you sure you want to delete this item?');

                                        $i=0;
                                        $class='admin_sub_li';
                                        $padding = $level_p*1;
                                       // echo $level_p;
                                        echo '<ul class="boxBackground">';
                                        foreach($categories as $categoryChild){
                                            //echo $parent.'<p>';
                                            //echo ' '.$parentChild = $categoryChild['id']; // kazda kategoria ma swojego parenta
                                            if($this->isOnActivePath($categoryChild['id'], $activePath)){
                                                $class='active ';
                                                //if($categoryChild['display']==1){
                                                    $a_padding=$padding+5;
                                                    echo '<li class="options"><div class="caption"><a style="padding-left:'.$a_padding.'px;" href="index.php?r=cms/cmsPage/update&&id='.$categoryChild['id'].'">» '.$categoryChild['link_name'].'</a>
                                                        ';
                                                    if($categoryChild['display']==0){
                                                        echo '<div class="iconExit"><img style="width:30px; height:30px;" src="'.$assetsUrl.'/images/admin/img/lupa.png" alt="(!)"></div>';
                                                    }
                                                    if($categoryChild['deletable']==1){
                                                        echo '</div><div class="iconExit"><a class="delete" href="index.php?r=cms/cmsPage/delete&&id='.$categoryChild['id'].'" title="Delete" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')"><img alt="Delete" src="'.$assetsUrl.'/images/admin/img/delete.png"></a>';
                                                    }else{
                                                        echo '</div>'; //caption div
                                                    }
                                                    echo '</li>';

                                                //}
                                                $criteriaChild=new CDbCriteria;
                                                $criteriaChild->compare('parent_id', $categoryChild['id']); // wszystkie dzieci
                                                $criteriaChild->order = '`order`';
                                                $category_z_bazy_children = CmsPage::model()->findAll($criteriaChild);
                                                $level=0;
                                                if (is_array($category_z_bazy_children)){
                                                    //echo "jest array";
                                                    $level_pass = $level_p+1;
                                                  //  echo 'k.'.$level_pass;
                                                    $this->getSubmenu($category_z_bazy_children, $level_pass, $activePath, $assetsUrl);
                                                }
                                            }else {
                                                  //if($categoryChild['display']==1){
                                                    echo '<li class="options" ><div class="caption"><a style="padding-left:'.$padding.'px;" href="index.php?r=cms/cmsPage/update&&id='.$categoryChild['id'].'">» '.$categoryChild['link_name'].'</a>';
                                                    if($categoryChild['display']==0){
                                                        echo '<div class="iconExit"><img style="width:30px; height:30px;" src="'.$assetsUrl.'/images/admin/img/lupa.png" alt="(!)"></div>';
                                                    }
                                                    if($categoryChild['deletable']==1){
                                                        echo '</div><div class="iconExit"><a class="delete" href="index.php?r=cms/cmsPage/delete&&id='.$categoryChild['id'].'" title="Delete" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')"><img alt="Delete" src="'.$assetsUrl.'/images/admin/img/delete.png"></a>';
                                                     }else{
                                                        echo '</div>'; //caption div
                                                     }
                                             echo '</li>';

                                                //}
                                                }




                                            $i++;
                                            $class='';
                                        }//end foreach
                                        echo '</ul>';

        }

public static function getTopMenuWithHorizontalSubMenu($activeUrl, $startPageId){
        $currentPage =  CmsPage::model()->find('url=?',array('url'=>$activeUrl));
        $criteria=new CDbCriteria;
        $criteria->compare('parent_id', $startPageId);
        $criteria->order = '`order`';
        $strony_glowne = CmsPage::model()->findAll($criteria);
        $activePath = CmsPage::model()->getMenuActivePath('CmsPage', 'parent_id', $currentPage['id']);

        $menu_txt = '<div class="podmenu">';
                    foreach($strony_glowne as $page){
                        if($page['display']==1){
                            //guest
                            $GetUrl = CmsPage::model()->getURL($page['url']);
                            $urlStrony = substr($GetUrl,0, 12);
                            if($urlStrony == 'index.php?r='){
                                $menu_txt .= '<li><a href="'.$GetUrl.'">'.$page['link_name'].'</a></li>';
                            }else{
                                $menu_txt .= '<li><a href="index.php?r=cms/cmsPage/displayPage&url='.$GetUrl.'">'.$page['link_name'].'</a></li>';
                            }
                            if (isset($activeUrl)){
                                $strony_glowne = CmsPage::model()->find('url=?',array('url'=>$activeUrl));

                                //if ()
                            }

                        }
                    }
}








        public function sendMailToAdmin($post){

          //ob_start();
          $dict_txt_front_admin_email = CmsDictionary::model()->dictionaryGetText('txt_front_admin_email');

          $dict_txt_front_admin_email = 'mariusz.winiarz@gmail.com';

                    Yii::import('application.extensions.phpmailer.JPhpMailer');
                    $mail = new JPhpMailer;
                    $SMTPDebug = true;
                    $mail->IsSMTP();
                    $mail->Host = 'a0copyplot.pl';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'system@a0copyplot.pl';
                    $mail->Password = 'SYS@ala123';
                    $mail->SetFrom('system@a0copyplot.pl', 'System');
                    $mail->Subject = 'Kontakt ze strony A0copyplot - '.$post['name'].'';
                    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                    $mail->MsgHTML('<p>Od: '.$post['name'].'<p>
                            E mail: '.$post['email'].'<p>
                            <p>Treść: '.$post['body'].'<p>
                                  ');


                    $mail->AddAddress($dict_txt_front_admin_email, 'A0copyplot Administrator');
                    $mail->Send();
            $mail->ClearAddresses();
            $mail->ClearAttachments();
            //ob_end_flush();

        }

        public static function GetMenuByParentId($parent_id){
            $criteria=new CDbCriteria;

		$criteria->compare('parent_id',$parent_id);
                $criteria->order='`order`';
            $menu_model = CmsPage::model()->findAll($criteria);
            $out = array();
            foreach ($menu_model as $menuItem){
                $out[] = array('label'=>$menuItem['name'], 'url'=>array('/site/page', 'url'=>$menuItem['url']));
            }
            return $out;
        }


}//end clas