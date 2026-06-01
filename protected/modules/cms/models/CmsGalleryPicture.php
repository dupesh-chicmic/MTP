<?php

/**
 * This is the model class for table "cms_gallery_picture".
 *
 * The followings are the available columns in table 'cms_gallery_picture':
 * @property integer $id
 * @property integer $parent_id
 * @property string $link
 * @property string $link_title
 * @property integer $link_position
 * @property string $text
 * @property string $image
 * @property integer $order
 *
 * The followings are the available model relations:
 */
class CmsGalleryPicture extends CActiveRecord
{
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return CmsGalleryPicture the static model class
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
		return 'cms_gallery_picture';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, link_position, order', 'numerical', 'integerOnly'=>true),
			array('link, image', 'length', 'max'=>900),
			array('link_title', 'length', 'max'=>700),
			array('text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, link, link_title, link_position, text, image, order', 'safe', 'on'=>'search'),
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
           if(Yii::app()->params['admin_lang'][1] == 'pl'){
		return array(
			'id' => 'ID',
			'parent_id' => 'ID galerii',
			'link' => 'Link do strony www',
			'link_title' => 'Nazwa linku',
			'link_position' => 'Pozycja linku',
			'text' => 'Krótki Opis',
			'image' => 'Zdjęcie defaultowe',
			'order' => 'Kolejność',
		);
            }else{
                return array(
			'id' => 'ID',
			'parent_id' => 'Gallery ID',
			'link' => 'Link to page www',
			'link_title' => 'Link name',
			'link_position' => 'Link position',
			'text' => 'Short text',
			'image' => 'Default picture',
			'order' => 'Order',
		);
            }
	}

	/**
	 * zwraca tablice typow bazodanowych
	 */
	public function inputTypes()
	{
		return array(
			'id' => array('type'=>'hidden'),
			'parent_id' => 'ID galerii',
			'link' => array('type'=>'varchar'),
			'link_title' => array('type'=>'varchar'),
			'link_position' => array('type'=>'select', 'value_list'=>array(1=>'Pierwszy', 0=>'Ostatni')),
			'text' => array('type'=>'textarea'),
			'image' => array('type'=>'varchar'),
			'order' => array('type'=>'order', 'value_list'=>array(0=>'Pierwszy', 999999=>'Ostatni')),
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('link_title',$this->link_title,true);
		$criteria->compare('link_position',$this->link_position);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('order',$this->order);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function renamePictureNameTransaction($galleryId){
            /* Po sortowaniu jquery nazy plikow zmieniaja sie dochodzi prefix - $i_time 
             * funkcja uaktualnia tabele w ktorej przechowuje zdjęcia
             */
            
            
            
        }
}