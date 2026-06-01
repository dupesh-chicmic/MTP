<?php

/**
 * This is the model class for table "input_types_form".
 *
 * The followings are the available columns in table 'input_types_form':
 * @property integer $id
 * @property integer $id_input_types
 * @property string $type
 * @property string $type_options
 * @property string $html_options
 * @property string $js
 * @property string $conditions
 * @property string $v_field_name
 * @property string $t_field_name
 * @property string $help
 * @property string $order_by
 *
 * The followings are the available model relations:
 * @property InputTypes[] $inputTypes
 * @property InputTypes $idInputTypes
 */
class InputTypesForm extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return InputTypesForm the static model class
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
		return 'input_types_form';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_input_types', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>100),
			array('v_field_name, t_field_name, order_by', 'length', 'max'=>75),
			array('type_options, html_options, js, conditions, help', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_input_types, type, type_options, html_options, js, conditions, v_field_name, t_field_name, help, order_by', 'safe', 'on'=>'search'),
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
			'inputTypes' => array(self::HAS_MANY, 'InputTypes', 'id_form'),
			'idInputTypes' => array(self::BELONGS_TO, 'InputTypes', 'id_input_types'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_input_types' => 'Id Input Types',
			'type' => 'Type',
			'type_options' => 'Type Options',
			'html_options' => 'Html Options',
			'js' => 'Js',
			'conditions' => 'Conditions',
			'v_field_name' => 'V Field Name',
			't_field_name' => 'T Field Name',
			'help' => 'Help',
			'order_by' => 'Order By',
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
		$criteria->compare('id_input_types',$this->id_input_types);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('type_options',$this->type_options,true);
		$criteria->compare('html_options',$this->html_options,true);
		$criteria->compare('js',$this->js,true);
		$criteria->compare('conditions',$this->conditions,true);
		$criteria->compare('v_field_name',$this->v_field_name,true);
		$criteria->compare('t_field_name',$this->t_field_name,true);
		$criteria->compare('help',$this->help,true);
		$criteria->compare('order_by',$this->order_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}