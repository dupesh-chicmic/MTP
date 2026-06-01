<?php

/**
 * This is the model class for table "input_types".
 *
 * The followings are the available columns in table 'input_types':
 * @property integer $id
 * @property string $model
 * @property string $field
 * @property integer $id_form
 * @property integer $order
 */
class InputTypes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return InputTypes the static model class
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
		return 'input_types';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_form, order', 'numerical', 'integerOnly'=>true),
			array('model, field', 'length', 'max'=>75),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, model, field, id_form, order', 'safe', 'on'=>'search'),
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
			'idForm' => array(self::BELONGS_TO, 'InputTypesForm', 'id_form'),
			'inputTypesForms' => array(self::HAS_ONE, 'InputTypesForm', 'id_input_types'),                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'model' => 'Model',
			'field' => 'Field',
			'id_form' => 'Input type',
			'order' => 'Order',
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
		$criteria->compare('model',$this->model,true);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('id_form',$this->id_form);
		$criteria->compare('order',$this->order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function inputTypesForInputTypes()
	{          
             $criteria=new CDbCriteria;
             $criteria->order = "help";
             $inputTypesForm = InputTypesForm::model()->findAll($criteria);
             $tablicaInutTypesForm = array();
             foreach($inputTypesForm as $ipt){
                 $itpTable = array($ipt['id']=>$ipt['type']);
                 
                 $tablicaInutTypesForm[$ipt['help']] = $itpTable;
             }                          
		return array(
			'id' => array('type'=>'hidden'),
			'model' => array('type'=>'varchar'),
			'field' => array('type'=>'varchar'),
			'id_form' => array('type'=>'select', 'value_list'=>$tablicaInutTypesForm),
                        'order' => array('type'=>'order', 'value_list'=>array(0=>Yii::t(Yii::app()->language.'_YiiTranslation', 'First'), 999999=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Last'))),
		);
	}
        
        public function getInputTypes($modelName){
            //echo 'uzywa getInputTypes (z bazy)';
                $criteria=new CDbCriteria;                
                $criteria->compare('model', $modelName);
                $criteria->order='`order`';
                //$inputT = InputTypes::model()->with(array('inputTypesForms'=>array('condition'=>'`inputTypesForms`.`id_input_types` = "1" ')))->findAll($criteria);
                $inputT = InputTypes::model()->findAll($criteria);
                
                //echo count($inputT).'elem<p>';
                                
                $inputTypes = array();
                
                //input types
                foreach($inputT as $it){                 
                    // input types form                    
                    $inputForm = InputTypesForm::model()->find('id=?',array($it->id_form));
                                                            
                    if($inputForm['type_options'] == 'map_elements'){                        
                        $criteria=new CDbCriteria;
                        $criteria->order='`title`';
                        $mapy = CHtml::listData(CmsMap::model()->findAll($criteria), 'id', 'title');                                                                    
                        $options = array('value_list'=>$mapy);
                    }else{
                        $options = eval('return '.$inputForm['type_options'].';');
                    }
                    //echo 'ile>'.count($inputForm).'<P>';
                    //echo 'ID '.$inputForm['id'].' TYP >> '.$inputForm['type_options'].'<p>';
//die;                  
//echo var_dump($options)  .'<p>';
                    //sprawdz czy sa jakies opcje dodatkowe
                    if(!empty($inputForm['type_options'])){
                        
                        $inputTypeForm = array('type'=>$inputForm['type']);
                        $inputTypeForm = array_merge($inputTypeForm,$options);

                    }else{
                        $inputTypeForm = array('type'=>$inputForm['type']);
                    }
                        //buduje array
                        //$inputTypes[$it->field] = $inputTypeForm; // dla 2=ok tylko else
                        $inputTypes[$it->field] = $inputTypeForm;
                }
                //var_dump($inputTypes);
                return $inputTypes;
        }
        
}