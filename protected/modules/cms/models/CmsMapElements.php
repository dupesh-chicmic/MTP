<?php

/**
 * This is the model class for table "cms_map_elements".
 *
 * The followings are the available columns in table 'pl_cms_map_elements':
 * @property integer $id
 * @property integer $id_Map
 * @property string $title
 * @property integer $order
 * @property string $icon_pic
 * @property string $icoCenter_width
 * @property string $icoCenter_long
 * @property string $infoWindow
 *
 * The followings are the available model relations:
 */
class CmsMapElements extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CmsMapElements the static model class
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
		return 'cms_map_elements';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_Map', 'required'),
			array('id_Map, order', 'numerical', 'integerOnly'=>true),
			array('title, icon_pic', 'length', 'max'=>300),
			array('icoCenter_width, icoCenter_long', 'length', 'max'=>500),
			array('infoWindow', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_Map, title, order, icon_pic, icoCenter_width, icoCenter_long, infoWindow', 'safe', 'on'=>'search'),
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
		return array(
			'id' => 'ID',
			'id_Map' => 'Id Map',
			'title' => 'Title',
			'order' => 'Order',
			'icon_pic' => 'Icon Picture',
			'icoCenter_width' => 'Ico Center Latitude',
			'icoCenter_long' => 'Ico Center Longitude',
			'infoWindow' => 'Info Window',
                        'display' => 'Display',
		);
	}

	/**
	 * zwraca tablice typow bazodanowych
	 */
//	public function inputTypes()
//	{                     
//$criteria=new CDbCriteria;
//$criteria->order='`title`';
//$mapy = CHtml::listData(CmsMap::model()->findAll($criteria), 'id', 'title');                                            
//array('value_list'=>array($mapy));
//                    
//		return array(
////			'id' => array('type'=>'hidden'),
//			'id_Map' => array('type'=>'select', 'value_list'=>array($mapy)),
////			'title' => array('type'=>'varchar'),
////			'order' => array('type'=>'order', 'value_list'=>array(0=>'Pierwszy', 999999=>'Ostatni')),
////			'icon_pic' => array('type'=>'image'),                        
////			'icoCenter_width' => array('type'=>'varchar'),
////			'icoCenter_long' => array('type'=>'varchar'),
////			'infoWindow' => array('type'=>'textarea'),                        
//		);
//	}


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
		$criteria->compare('id_Map',$this->id_Map);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('order',$this->order);
		$criteria->compare('icon_pic',$this->icon_pic,true);
		$criteria->compare('icoCenter_width',$this->icoCenter_width,true);
		$criteria->compare('icoCenter_long',$this->icoCenter_long,true);
		$criteria->compare('infoWindow',$this->infoWindow,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}