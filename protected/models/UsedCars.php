<?php

/**
 * This is the model class for table "used_cars".
 *
 * The followings are the available columns in table 'used_cars':
 * @property integer $id
 * @property integer $id_import
 * @property string $name
 * @property string $xml
 * @property integer $order
 *
 * The followings are the available model relations:
 * @property Import $idImport
 */
class UsedCars extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UsedCars2 the static model class
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
		return 'used_cars';
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
                        'usedCarsModels' => array(self::HAS_MANY, 'UsedCarsModel', 'id_used_cars'),
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
        public static function isInYears($yearsRange, $itemYear)
        {
            if(!empty($yearsRange)){
                $years = explode('/', $yearsRange);
                if(is_array($years)){
                    if($years[1]=='-') $years[1]=99999;
                    if($itemYear>$years[0] && $itemYear<$years[1]){
                        return true;
                    }else return false;
                }else 
                    return false;
            }else 
                return false;
           
        }
        
        public static function newCarsRanges($xmlRangeFilePath)
	{
		//RANGES:
            $range_file = file_get_contents($xmlRangeFilePath);  
            $range_file = htmlspecialchars($range_file);
            $range_cars = simplexml_load_string(html_entity_decode($range_file), 'SimpleXMLElement', LIBXML_NOCDATA);
            //var_dump($range_cars);
            $ranges_array = array();
            foreach($range_cars->range as $row){
              //  echo 'in';
               // var_dump($row);
               $manufacturerName = str_replace(' ', '_', $row['manufacturer']);
               //echo $manufacturerName.'--model';
               $ranges_array[$manufacturerName][(String)$row['rangedesc']] = $row['rangecode'];
//                
            }
            return $ranges_array;
	}
        
        public static function usedCarsRanges1($importId, $year, $makeId)
	{
		//RANGES:
            $list= Yii::app()->db->createCommand('SELECT distinct cr.rangecode, cr.manufacturer, cr.rangedesc FROM `used_cars_ranges` cr, used_cars_model cm WHERE cr.rangecode=cm.rangecode AND cm.yearfrom<=:year AND cm.yearto >=:year AND cr.id_import = :import_id AND cm.id_used_cars=:make_id')->bindValue('make_id',$makeId)->bindValue('import_id',$importId)->bindValue('year',$year)->queryAll();
            if(!empty($list)){
            $ranges_array = array();
            foreach($list as $row){
                $manufacturerName = str_replace(' ', '_', $row['manufacturer']);
                //process each item here
                $ranges_array[$manufacturerName][(String)$row['rangedesc']] = $row['rangecode'];
                

            }

            
           // $useCarsRanges = UsedCarsRanges::model()->findAll('id_import=:id_import', array('id_import'=>$importId));
//            if(!empty($useCarsRanges)){
//            
//            //var_dump($range_cars);
//            $ranges_array = array();
//            foreach($useCarsRanges as $row){
//              //  echo 'in';
//               // var_dump($row);
//               $manufacturerName = str_replace(' ', '_', $row['manufacturer']);
//               //echo $manufacturerName.'--model';
//               $ranges_array[$manufacturerName][(String)$row['rangedesc']] = $row['rangecode'];
////                
//            }
            return $ranges_array;
            }else return null;
	}
        
    public static function usedCarsRanges($importId)
	{
		//RANGES:
            $useCarsRanges = UsedCarsRanges::model()->findAll('id_import=:id_import', array('id_import'=>$importId));
            if(!empty($useCarsRanges)){
            
            //var_dump($range_cars);
            $ranges_array = array();
            foreach($useCarsRanges as $row){
              //  echo 'in';
               // var_dump($row);
               $manufacturerName = str_replace(' ', '_', $row['manufacturer']);
               //echo $manufacturerName.'--model';
               $ranges_array[$manufacturerName][(String)$row['rangedesc']] = $row['rangecode'];
//                
            }
            return $ranges_array;
            }else return null;
	} 
        
        public static function getManufacturersRanges($markId, $year){
	
            
        $mark = UsedCars::model()->findByPk($markId);
        if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){
            $ranges = UsedCars::usedCarsRanges($mark->id_import);
        }else{
            $ranges = UsedCars::usedCarsRanges1($mark->id_import, $year, $markId);
        }
       
        
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
public static function odometerCalculation($data)
    {
        //var_dump($data);
        if( !empty($data) ){
            $km = $data['km']*1000;
            $year = $data['year'];
            $fuel = $data['fuel'];            
            $guide = $data['guide']; // ze znakiem euro
            $guide = substr((string)$guide,3); // wycinam euro ktore jest pierwszym znakiem
            $guideKm = $data['guideKm']*1000; // km z tabeli
            $carOrCom = $data['carOrCom'];
            $codenumber = $data['codenumber'];
            $id_import = $data['import'];
            // print_r($data); die;
            // liczenie 
            if(!empty($km)){
                if(!empty($year)){
                    if(!empty($guide)){
                        if($fuel == 'P'){
                            // petrol
                            $adjustedValue = XmlPetrolBandsModel::countPetrol($km, $year, $guide, $guideKm, $id_import);
                            //$carOrCom = $_POST['carOrCom'];
                        }else if($fuel == 'D'){
                            // diesel
                            $adjustedValue = XmlDieselBandsModel::countDiesel($km, $year, $guide, $guideKm, $id_import);
                            //$carOrCom = $_POST['carOrCom'];
                        }else if($fuel == 'E'){
                            // diesel
                            $adjustedValue = XmlElectricBandsModel::countElectric($km, $year, $guide, $guideKm, $id_import);
                            //$carOrCom = $_POST['carOrCom'];
                        }else{
                            $adjustedValue = 'Valuation cannot be provided now.';
                        }
                    }else{
                        $adjustedValue = 'Valuation cannot be provided now.';
                    }
                }else{
                    $adjustedValue = 'Please select a year to adjust.';
                }
            }else{
                $adjustedValue = 'Please enter km\'s';
            }        
            // echo "sdfbergf"; die;
        return array('adjustedValue'=>$adjustedValue,//user Value pdf
                         'carOrCom'=>$carOrCom,
                         'codenumber'=>$codenumber,
                         'userYear'=>$year,
                         'userKms'=>$km,
                         'import'=>$id_import
                        );
        }
        else
        {
            return null;
        }
    }
//    public static function odometerCalculation($data)
//    {
//        //var_dump($data);
//        if( !empty($data) ){
//            $km = $data['km']*1000;
//            $year = $data['year'];
//            $fuel = $data['fuel'];            
//            $guide = $data['guide']; // ze znakiem euro
//            $guide = substr((string)$guide,3); // wycinam euro ktore jest pierwszym znakiem
//            $guideKm = $data['guideKm']*1000; // km z tabeli
//            $carOrCom = $data['carOrCom'];
//            $codenumber = $data['codenumber'];
//            $id_import = $data['import'];
//            
//            // liczenie 
//            if(!empty($km)){
//                if(!empty($year)){
//                    if(!empty($guide)){
//                        if($fuel == 'P'){
//                            // petrol
//                            $adjustedValue = XmlPetrolBandsModel::countPetrol($km, $year, $guide, $guideKm, $id_import);
//                            //$carOrCom = $_POST['carOrCom'];
//                        }else if($fuel == 'D'){
//                            // diesel
//                            $adjustedValue = XmlDieselBandsModel::countDiesel($km, $year, $guide, $guideKm, $id_import);
//                            //$carOrCom = $_POST['carOrCom'];
//                        }else if($fuel == 'E'){
//                            // diesel
//                            $adjustedValue = XmlElectricBandsModel::countElectric($km, $year, $guide, $guideKm, $id_import);
//                            //$carOrCom = $_POST['carOrCom'];
//                        }else{
//                            $adjustedValue = 'Valuation cannot be provided now.';
//                        }
//                    }else{
//                        $adjustedValue = 'Valuation cannot be provided now.';
//                    }
//                }else{
//                    $adjustedValue = 'Please select a year to adjust.';
//                }
//            }else{
//                $adjustedValue = 'Please enter km\'s';
//            }        
//
//        return array('adjustedValue'=>$adjustedValue,//user Value pdf
//                         'carOrCom'=>$carOrCom,
//                         'codenumber'=>$codenumber,
//                         'userYear'=>$year,
//                         'userKms'=>$km,
//                         'import'=>$id_import
//                        );
//        }
//        else
//        {
//            return null;
//        }
//    }
    
}