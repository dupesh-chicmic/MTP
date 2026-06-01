<?php

/**
 * This is the model class for table "xml_kms_bands_model".
 *
 * The followings are the available columns in table 'xml_kms_bands_model':
 * @property integer $id
 * @property integer $id_import
 * @property integer $year
 * @property string $yrID
 * @property string $petrolUp
 * @property string $petrolDn
 * @property string $dieselUp
 * @property string $dieselDn
 *
 * The followings are the available model relations:
 * @property Import $idImport
 */
class XmlKmsBandsModel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return XmlKmsBandsModel34 the static model class
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
		return 'xml_kms_bands_model';
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
			array('id_import, year', 'numerical', 'integerOnly'=>true),
			array('yrID, petrolUp, petrolDn, dieselUp, dieselDn, electricUp, electricDn', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_import, year, yrID, petrolUp, petrolDn, dieselUp, dieselDn, electricUp, electricDn', 'safe', 'on'=>'search'),
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
			'year' => 'Year',
			'yrID' => 'Yr',
			'petrolUp' => 'Petrol Up',
			'petrolDn' => 'Petrol Dn',
			'dieselUp' => 'Diesel Up',
			'dieselDn' => 'Diesel Dn',
                        'electricUp' => 'Electric Up',
			'electricDn' => 'Electric Dn',
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
		$criteria->compare('year',$this->year);
		$criteria->compare('yrID',$this->yrID,true);
		$criteria->compare('petrolUp',$this->petrolUp,true);
		$criteria->compare('petrolDn',$this->petrolDn,true);
		$criteria->compare('dieselUp',$this->dieselUp,true);
		$criteria->compare('dieselDn',$this->dieselDn,true);
                $criteria->compare('electricUp',$this->electricUp,true);
		$criteria->compare('electricDn',$this->electricDn,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getKmsBands($import_id){   
            //$make_file = './qBixSoft/KmsBands.xml';
            //$file = file_get_contents($make_file);
            //return $kmSData = simplexml_load_string(html_entity_decode($file), 'SimpleXMLElement', LIBXML_NOCDATA);
            static $cache = array();
            $importIdKey = (int) $import_id;
            if (isset($cache[$importIdKey])) {
                return $cache[$importIdKey];
            }
            $kms = XmlKmsBandsModel::model()->findAll(array(
                'condition'=>'id_import=:idImport',
                'params'=>array(':idImport'=>$import_id)
            ));
            $cache[$importIdKey] = $kms;
            return $kms;
        }
        
        //import/export KmsBands
        public function export_kmsBand_xml_to_db($tableName,$id_import){
            $dir = 'qBixSoft';
            $file = 'KmsBands.xml';                

            $kms_file = file_get_contents('./'.$dir.'/'.$file);
            $kms_file = htmlspecialchars($kms_file);
            $kms = simplexml_load_string(html_entity_decode($kms_file), 'SimpleXMLElement', LIBXML_NOCDATA);
            //$kms = simplexml_load_string(html_entity_decode(htmlentities($kms_file)), 'SimpleXMLElement', LIBXML_NOCDATA);

            foreach ($kms->bands as $row){
                $values = '';
                // id auto
                $values .= '"'.$row['year'].'",';
                $values .= '"'.$row['yrID'].'",';
                $values .= '"'.$row['petrolUp'].'",';
                $values .= '"'.$row['petrolDn'].'",';
                $values .= '"'.$row['electricUp'].'",';
                $values .= '"'.$row['electricDn'].'",';
                $values .= '"'.$row['dieselUp'].'",';
                $values .= '"'.$row['dieselDn'].'"';                        
                // ostatni element bez , !!!

                $nazwyPolDoInsertu = 'id_import, year, yrID, petrolUp, petrolDn, electricUp, electricDn, dieselUp, dieselDn';
                $sqlKms = 'INSERT INTO `'.$tableName.'` ('.$nazwyPolDoInsertu.') VALUES ('.$id_import.','.$values.')'; // end query                
                Yii::app()->db->createCommand($sqlKms)->execute();
            }            
            
        }            

   
   
}
