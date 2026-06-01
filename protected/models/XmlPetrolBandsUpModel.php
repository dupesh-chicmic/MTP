<?php

/**
 * This is the model class for table "xml_petrol_bands_up_model".
 *
 * The followings are the available columns in table 'xml_petrol_bands_up_model':
 * @property integer $id
 * @property integer $id_import
 * @property integer $fromXml
 * @property integer $toXml
 * @property integer $yr1
 * @property integer $yr2
 * @property integer $yr3
 * @property integer $yr4
 * @property integer $yr5
 * @property integer $yr6
 * @property integer $yr7
 * @property integer $yr8
 * @property integer $yr9
 */
class XmlPetrolBandsUpModel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return XmlPetrolBandsUpModel the static model class
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
		return 'xml_petrol_bands_up_model';
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
			array('id_import, fromXml, toXml, yr1, yr2, yr3, yr4, yr5, yr6, yr7, yr8, yr9, yr10, yr11, yr12, yr13, yr14, yr15, yr16', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_import, fromXml, toXml, yr1, yr2, yr3, yr4, yr5, yr6, yr7, yr8, yr9, yr10, yr11, yr12, yr13, yr14, yr15, yr16', 'safe', 'on'=>'search'),
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
			'id_import' => 'Id Import',
			'fromXml' => 'From Xml',
			'toXml' => 'To Xml',
			'yr1' => 'Yr1',
			'yr2' => 'Yr2',
			'yr3' => 'Yr3',
			'yr4' => 'Yr4',
			'yr5' => 'Yr5',
			'yr6' => 'Yr6',
			'yr7' => 'Yr7',
			'yr8' => 'Yr8',
			'yr9' => 'Yr9',
                        'yr10' => 'Yr10',
                        'yr11' => 'Yr11',
                        'yr12' => 'Yr12',
                        'yr13' => 'Yr13',
                        'yr14' => 'Yr14',
                        'yr15' => 'Yr15',
                        'yr16' => 'Yr16',
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
		$criteria->compare('id_import',$this->id_import);
		$criteria->compare('fromXml',$this->fromXml);
		$criteria->compare('toXml',$this->toXml);
		$criteria->compare('yr1',$this->yr1);
		$criteria->compare('yr2',$this->yr2);
		$criteria->compare('yr3',$this->yr3);
		$criteria->compare('yr4',$this->yr4);
		$criteria->compare('yr5',$this->yr5);
		$criteria->compare('yr6',$this->yr6);
		$criteria->compare('yr7',$this->yr7);
		$criteria->compare('yr8',$this->yr8);
		$criteria->compare('yr9',$this->yr9);
                $criteria->compare('yr10',$this->yr10);
                $criteria->compare('yr11',$this->yr11);
                $criteria->compare('yr12',$this->yr12);
                $criteria->compare('yr13',$this->yr13);
                $criteria->compare('yr14',$this->yr14);
                $criteria->compare('yr15',$this->yr15);
                $criteria->compare('yr16',$this->yr16);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}