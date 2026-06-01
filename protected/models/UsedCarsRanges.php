<?php

/**
 * This is the model class for table "used_cars_ranges".
 *
 * The followings are the available columns in table 'used_cars_ranges':
 * @property integer $id
 * @property integer $id_import
 * @property string $manufacturer
 * @property integer $rangecode
 * @property string $rangedesc
 */
class UsedCarsRanges extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'used_cars_ranges';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, id_import, manufacturer, rangecode, rangedesc', 'required'),
			array('id, id_import, rangecode', 'numerical', 'integerOnly'=>true),
			array('manufacturer, rangedesc', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_import, manufacturer, rangecode, rangedesc', 'safe', 'on'=>'search'),
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
			'manufacturer' => 'Manufacturer',
			'rangecode' => 'Rangecode',
			'rangedesc' => 'Rangedesc',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_import',$this->id_import);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('rangecode',$this->rangecode);
		$criteria->compare('rangedesc',$this->rangedesc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsedCarsRanges the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
