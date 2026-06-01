<?php

/**
 * This is the model class for table "api_users".
 *
 * The followings are the available columns in table 'api_users':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property integer $chasis
 * @property integer $riDataOnlyOk
 * @property integer $uk_regs
 * @property integer $valuations
 * @property string $mtp_fields
 * @property integer $is_test_user
 * @property string $verisk_credential_set
 * @property integer $display_mtp_code
 * @property string $display_function_name
 */
class ApiUsers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'api_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, riDataOnlyOk', 'required'),
			array('chasis, riDataOnlyOk, uk_regs, valuations, is_test_user, display_mtp_code', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>50),
			array('password, display_function_name', 'length', 'max'=>100),
			array('verisk_credential_set', 'length', 'max'=>20),
			array('mtp_fields', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, chasis, riDataOnlyOk, uk_regs, valuations, mtp_fields, is_test_user, verisk_credential_set, display_mtp_code, display_function_name', 'safe', 'on'=>'search'),
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
			'username' => 'Username',
			'password' => 'Password',
			'chasis' => 'Chasis',
			'riDataOnlyOk' => 'Ri Data Only Ok',
			'uk_regs' => 'Uk Regs',
			'valuations' => 'Valuations',
			'mtp_fields' => 'Mtp Fields',
			'is_test_user' => 'Is Test User',
			'verisk_credential_set' => 'Verisk Credential Set',
			'display_mtp_code' => 'Display Mtp Code',
			'display_function_name' => 'Display Function Name',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('chasis',$this->chasis);
		$criteria->compare('riDataOnlyOk',$this->riDataOnlyOk);
		$criteria->compare('uk_regs',$this->uk_regs);
		$criteria->compare('valuations',$this->valuations);
		$criteria->compare('mtp_fields',$this->mtp_fields,true);
		$criteria->compare('is_test_user',$this->is_test_user);
		$criteria->compare('verisk_credential_set',$this->verisk_credential_set,true);
		$criteria->compare('display_mtp_code',$this->display_mtp_code);
		$criteria->compare('display_function_name',$this->display_function_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ApiUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function setDefaults(){
            $this->chasis = $this->is_test_user = $this->mtp_fields = $this->uk_regs = false;
            $this->display_function_name = 'getMTPDisplayValues';
            
        }
}
