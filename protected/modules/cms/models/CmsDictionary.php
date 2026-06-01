<?php

/**
 * This is the model class for table "pl_cms_dictionary".
 *
 * The followings are the available columns in table 'pl_cms_dictionary':
 * @property integer $id
 * @property string $key
 * @property string $txt
 * @property integer $client_editable
 * @property string $value
 * @property string $group
 * @property string $actions
 *
 * The followings are the available model relations:
 */
class CmsDictionary extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CmsDictionary the static model class
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
		return 'pl_cms_dictionary';
                //return parent::prefixTableName('en_cms_dictionary');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
            if(Yii::app()->user->isSu() == false){ //jest tylko adminem                
		return array(
			array('key, client_editable', 'required'),
			array('client_editable', 'numerical', 'integerOnly'=>true),
			array('key, value, group, actions', 'length', 'max'=>500),
			array('txt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('key, txt', 'safe', 'on'=>'search'),
		);
            }else{ // jest su
		return array(
			array('key, client_editable', 'required'),
			array('client_editable', 'numerical', 'integerOnly'=>true),
			array('key, value, group, actions', 'length', 'max'=>500),
			array('txt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('id, key, txt, client_editable, value, group, actions', 'safe', 'on'=>'search'),
		);
                }
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
			'key' => 'Klucz',
			'txt' => 'Tekst',
			'client_editable' => 'Edytowalny przez klienta',
			'value' => 'Wartość',
			'group' => 'Grupa',
			'actions' => 'Akcja',
		);
              }else{
		return array(
			'id' => 'ID',
			'key' => 'Key',
			'txt' => 'Text',
			'client_editable' => 'Client editable',
			'value' => 'Value',
			'group' => 'Group',
			'actions' => 'Action',
		);
              }
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{// Tylko dla Manage
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                if(Yii::app()->user->isSu() == false){ //jest tylko adminem
                    //$criteria->compare('key',$this->key,true);
                    $criteria->compare('txt',$this->txt,true);
                    $criteria->compare('`client_editable`', 1); // compare szuka (co, numer (wartosc))  -tylko ci co moga byc edytowalni przez klienta(admina)
                }else{ // jestem SU
                    $criteria->compare('id',$this->id);
                    //$criteria->compare('key',$this->key,true);
                    $criteria->compare('txt',$this->txt,true);
                    $criteria->compare('client_editable',$this->client_editable);
                    $criteria->compare('value',$this->value,true);
                    //$criteria->compare('group',$this->group,true);
                    $criteria->compare('actions',$this->actions,true);
                }
                
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}


        /* pobieram tekst po kluczu */
        public static function dictionaryGetText($key){
             $criteria=new CDbCriteria;
             $criteria->select='txt';
             $criteria->compare('`key`', $key);

             $txt = CmsDictionary::model()->findAll($criteria);

     
                    $tab = array();
                    foreach($txt as $page){
                        return $exit = $page['txt'];
                    }
        }

        /* pobieram wszystko(*) po grupie */
        public static function dictionaryGetGroup($group){
             $criteria=new CDbCriteria;
             $criteria->select='*';
             $criteria->compare('`group`', $group);

             $all = CmsDictionary::model()->findAll($criteria);
             return $all;
        }


        /* wyszukuje akcje dla podanej funckji */
        public static function getActionPage($function){
             $criteria = new CDbCriteria;
             $criteria->select='actions';
             $criteria->compare('`value`', $function); //wybierz akcje value=$function

             //echo "KEY(value): ".$function;
             $act = CmsDictionary::model()->findAll($criteria);

                    $tab = array();
                    foreach($act as $page){
                        return $exit = $page['actions'];
                    }

                    //return $act;
        }

        public static function getHTMLoptions($group, $OptionList_p, $polaZbazy_p){
/*
 * pobiera opcje np. <option onclick="ShowHideField();" value="f_normal_page">Normal Page</option>
 */
             $out = array();
    
             $criteria = new CDbCriteria;
             $criteria->select='*';
             $criteria->compare('`group`', $group);
             $All_group = CmsDictionary::model()->findAll($criteria);

             foreach($All_group as $item){                   

                    $i=0;
                    $tmp = array();
                    foreach($OptionList_p as $option){    
                        $tmp[$option] = $item[$polaZbazy_p[$i]];
                        $i++;
                        
                    }
                    $out[$item['value']] = $tmp;
             }
       
              return $out;
        }
           
}