<?php

/**
 * This is the model class for table "pl_cms_gallery".
 *
 * The followings are the available columns in table 'pl_cms_gallery':
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $data
 * @property string $folder
 * @property string $seo1
 * @property string $seo2
 * @property integer $display
 * @property integer $editable
 * @property integer $order
 * @property integer $image
 * @property integer $group
 * @property integer $deletable
 * The followings are the available model relations:
 */
define('MODE',1); //1 galeria z opisem zdjecia
class CmsGallery extends CActiveRecord
{

    
	/**
	 * Returns the static model of the specified AR class.
	 * @return CmsGallery the static model class
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
		return 'cms_gallery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, display, editable, order', 'required'),
			array('display, editable, order, group, deletable', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>600),
			array('folder, image', 'length', 'max'=>500),
			array('seo1, seo2', 'length', 'max'=>900),
			array('text, data', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, text, data, folder, seo1, seo2, display, editable, order, image, group, deletable', 'safe', 'on'=>'search'),
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
                            'title' => 'Tytuł',
                            'text' => 'Tekst',
                            'data' => 'Data',
                            'folder' => 'Folder',
                            //'seo1' => 'Seo1',
                            //'seo2' => 'Seo2',
                            'display' => 'Wyświetlaj',
                            'editable' => 'Edytowalny',
                            'order' => 'Kolejność',
                            //'image' => 'Default picture',
                            //'group' => 'Strona www',
                            'deletable' => 'Usuwalny',
                    );
            }else{
                    return array(
                            'id' => 'ID',
                            'title' => 'Title',
                            'text' => 'Text',
                            'data' => 'Data',
                            'folder' => 'Folder',
                            //'seo1' => 'Seo1',
                            //'seo2' => 'Seo2',
                            'display' => 'Display',
                            'editable' => 'Editable',
                            'order' => 'Order',
                            //'image' => 'Default picture',
                            //'group' => 'Page www',
                            'deletable' => 'Deletable',
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
		$criteria->compare('title',$this->title);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('folder',$this->folder,true);
		$criteria->compare('seo1',$this->seo1,true);
		$criteria->compare('seo2',$this->seo2,true);
		$criteria->compare('display',$this->display);
		$criteria->compare('editable',$this->editable);
		$criteria->compare('order',$this->order);
                $criteria->compare('image',$this->image,true);
                $criteria->compare('group',$this->group);
		$criteria->compare('deletable',$this->deletable);


		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public function getElementId($key, $val){
//echo $key."<br>";
//echo $val;
             $criteria = new CDbCriteria;
             $criteria->select='*';
             //$criteria->compare('`id`', $id); //wez * dla id=$id
             //AND
             $criteria->compare('`title`', $val);
             $result = CmsPage::model()->findAll($criteria);

                    foreach($result as $id){
                        if( !empty($id['id']) ){
                            echo $id['id'];
                            return $id['id'];
                        }
                        else{
                            //return $item['url'];
                        }
                    }
        }



        public function ImgResize($width, $height, $path, $folder=null)
	{
            //echo "Sciezka do pliku: ".$path;
            if($folder == 'm'){

                        //$pathToResizeFile_duzy = './gallery/'.$folder.'/d/'.$file_name;
                        $file_name = Yii::app()->request->baseUrl.ImageHelper::thumb($width,$height,$path, array(
                            'method' => 'resize',
                            'quality' => 90));
                //return $$file_name;
            }else if($folder == 'd'){
                        //$path_d = $path;
                        //$path_d = './gallery/'.$folder.'/d/'.$file_name;
                        $file_name = Yii::app()->request->baseUrl.ImageHelper::thumb($width,$height,$path, array(
                            'method' => 'resize',
                            'quality' => 90));
                //return $$file_name;
            }else if($folder == null){
                        $file_name = Yii::app()->request->baseUrl.ImageHelper::thumb($width,$height,$path, array(
                            'method' => 'resize',
                            'quality' => 90));
            }
            //ostatnie 14 znakow to nazwa pliku
            $file_name = substr($file_name, -14);
		return $file_name;
	}


        public function getGalleryMode($mode=MODE){
            //zwraca typ galerii
            return $mode;
        }

        public static function getImageSize($poleDB, $typ){
            $rozmiary = array('image' => array('small'=>array('height'=>115, 'width'=>165), 'medium'=>array('height'=>800, 'width'=>600), 'large'=>array('height'=>250, 'width'=>350), 'default'=>array('height'=>200, 'width'=>231)),                
                );
            return $rozmiary[$poleDB][$typ];
        }
}