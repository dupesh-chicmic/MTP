<?php

/**
 * This is the model class for table "cms_map".
 *
 * The followings are the available columns in table 'pl_cms_map':
 * @property integer $id
 * @property string $title
 * @property string $mapCenter_wide
 * @property string $mapCenter_long
 * @property integer $zoom
 * @property string $mapControll
 * @property string $styleControll
 * @property string $navControll
 * @property string $navControllOpt
 * @property string $type
 * @property string $size_width
 * @property string $size_height
 * @property integer $order
 *
 * The followings are the available model relations:
 */
class CmsMap extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CmsMap the static model class
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
		return 'cms_map';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zoom, order, display', 'numerical', 'integerOnly'=>true),
			array('title, mapCenter_wide, mapCenter_long, mapControll, styleControll, navControll, navControllOpt, type, size_width, size_height', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, mapCenter_wide, mapCenter_long, zoom, mapControll, styleControll, navControll, navControllOpt, type, size_width, size_height, order, display', 'safe', 'on'=>'search'),
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
                    //'pageElement' => array(self::HAS_MANY, 'PageElement', 'id'),
                    //'pageElement' => array(self::BELONGS_TO, 'PageElement', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'mapCenter_wide' => 'Map Center Latitude',
			'mapCenter_long' => 'Map Center Longitude',
			'zoom' => 'Zoom',
			'mapControll' => 'Map Controll',
			'styleControll' => 'Style Controll',
			'navControll' => 'Nav Controll',
			'navControllOpt' => 'Nav Controll Opt',
			'type' => 'Type',
			'size_width' => 'Size Width',
			'size_height' => 'Size Height',
			'order' => 'Order',
                        'display' => 'Display',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('mapCenter_wide',$this->mapCenter_wide,true);
		$criteria->compare('mapCenter_long',$this->mapCenter_long,true);
		$criteria->compare('zoom',$this->zoom);
		$criteria->compare('mapControll',$this->mapControll,true);
		$criteria->compare('styleControll',$this->styleControll,true);
		$criteria->compare('navControll',$this->navControll,true);
		$criteria->compare('navControllOpt',$this->navControllOpt,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('size_width',$this->size_width,true);
		$criteria->compare('size_height',$this->size_height,true);
		$criteria->compare('order',$this->order);
		$criteria->compare('display',$this->display);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}