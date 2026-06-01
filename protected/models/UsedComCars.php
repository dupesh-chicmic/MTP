<?php

/**
 * This is the model class for table "used_com_cars".
 *
 * The followings are the available columns in table 'used_com_cars':
 * @property integer $id
 * @property integer $id_import
 * @property string $name
 * @property string $xml
 * @property integer $order
 *
 * The followings are the available model relations:
 * @property Import $idImport
 */
class UsedComCars extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UsedComCars2 the static model class
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
		return 'used_com_cars';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_import', 'required'),
			array('id_import, order', 'numerical', 'integerOnly'=>true),
			array('name, xml', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_import, name, xml, order', 'safe', 'on'=>'search'),
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
			'idImport' => array(self::BELONGS_TO, 'Import', 'id_import'),
                        'usedComCarsModels' => array(self::HAS_MANY, 'UsedComCarsModel', 'id_used_com_cars'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_import' => 'Id Import',
			'name' => 'Name',
			'xml' => 'Xml',
			'order' => 'Order',
		);
	}
public static function getManufacturersRanges($markId){
	
            
        $mark = UsedComCars::model()->findByPk($markId);
        $ranges = UsedCommsRanges::getUsedCommsRanges($mark->id_import);
        
        $manufacturer = str_replace(' ', '_', $mark->name);
		//RANGES:
            if(!empty($ranges) && !empty($manufacturer)){            
                return $ranges[$manufacturer];
            }else return null;
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
		$criteria->compare('id_import',$this->id_import);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('xml',$this->xml,true);
		$criteria->compare('order',$this->order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}