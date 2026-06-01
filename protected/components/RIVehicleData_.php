<?php
class RIVehicleData
{
	public $params;
	public $debug=true;
	public $paid=false;
	private $_soap;
	private $_lastMessageBody;
	private $_lastMessageXMLResponse;

    public function __construct($params=array(), $debug=false)
    {
    	$params=CMap::mergeArray(Yii::app()->params['RIVehicleData'], $params);
    	if(empty($params['free']['ns']))
    		//$params['free']['ns']='http://qdvs.moneymate.com/VehicleDataWebService/VehicleQueryReport/';
    		$params['free']['ns']='https://vqs.riskintelligence.ie/VehicleDataWebService/VehicleQueryReport/';
    	if(empty($params['paid']['ns']))
    		//$params['paid']['ns']='http://qdvs.moneymate.com/VehicleDataWebService/VehicleQuery/';
    		$params['paid']['ns']='https://vqs.riskintelligence.ie/VehicleDataWebService/VehicleQueryReport/';
    	$this->params=$params;
    	$this->debug=$debug;
    }

    protected static function resolveError($soapResponse)
    {
        
    	$errors=array();
    	if(is_object($soapResponse))
    	{
    		if(get_class($soapResponse)=='stdClass')
    		{
    			$doc = new DOMDocument();
    			$doc->loadXML(reset($soapResponse));
    			$xpath=new DOMXPath($doc);
    			$errorNodes=$xpath->query('/*/@Error');
    			foreach($errorNodes as $en)
    				$errors[]=$en->value;
    		}
    		elseif(get_class($soapResponse)=='SoapFault')
    		{
    			$errors[]=$soapResponse->getMessage();
    		}
    	}
    	return $errors;
    }

    public static function array2XMLBody($rootName, $array)
    {
    	$dom=Array2XML::createXML($rootName, $array);
    	return $dom->saveXML($dom->documentElement);
    }

    public function getLastMessageBody()
    {
    	return $this->_lastMessageBody;
    }

    public function getLastSoapMessage()
    {
    	return array(
    		$this->_lastMessageBody,
    		$this->_lastMessageXMLResponse,
    		$this->_soap->__getLastRequestHeaders(),
    		$this->_soap->__getLastRequest()
    	);
    }

    public function query($method, $params)
    {
    	$body=self::array2XMLBody($method, $params);
       // var_dump($body);
        $body=new SOAPVar($body, XSD_ANYXML);
       // echo 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'.$method;
        //var_dump($body);
        //exit;
    	$result=array();
    	$this->_lastMessageBody=$body;
    	//$this->_lastMessageBody['_methodName']=$method;
    	try
    	{       //$this->_soap->QueryVehicle();
               // var_dump($this->_soap);
               
            

    		$response=$this->_soap->$method($body);
//            echo "************ REQUEST HEADERS ***********" . PHP_EOL;
//            var_dump($this->_soap->__getLastRequestHeaders());
//            echo "************ REQUEST ***********" . PHP_EOL;
//            var_dump($this->_soap->__getLastRequest());
//            echo "*********** RESPONSE ***********" . PHP_EOL;
//            var_dump($response);
                
               // exit;
    		$errors=self::resolveError($response);
    		if(!empty($errors))
    		{
    			$result=array('errors'=>$errors);
    		}
    		else
    		{
    			$response=reset($response);
    			$result=XML2Array::createArray($response);
    			$this->_lastMessageXMLResponse=$response;
    		}

    	}
    	catch(Exception $e)
    	{
    		$result['errors'][]='Exception: '.$e->getMessage().($this->debug?"\nLast request headers:\n".$this->_soap->__getLastRequestHeaders()."\nLast request:\n".$this->_soap->__getLastRequest():'');
    	}
    	return $result;
    }

    protected function prepareVehicleQuery($registration, $addVehicleDataParams=array(), $paid=false)
    {
        //$paid=false;
    	$errors=array();
    	if(empty($registration))
    		$errors[]='Registration cannot be blank.';

    	if(!empty($errors)){            
    		return array('errors'=>$errors);
        }
//$paid=true;
        $this->debug=true;
    	$paidKey=$paid?'paid':'free';
        
        /////////////
//        $context = stream_context_create(array(
//    'ssl' => array(
//        // set some SSL/TLS specific options
//        'verify_peer' => false,
//        'verify_peer_name' => false,
//        'allow_self_signed' => true
//    )
//));

//$client  = new SoapClient(null, [
//    'location' => 'https://...',
//    'uri' => '...', 
//    'stream_context' => $context
//]);
        ////////////
        
        
    	//$soap=$this->_soap=new SoapClient($this->params[$paidKey]['url'], $this->debug?array('trace'=>1, 'exceptions'=>0):array());
    	$soap=$this->_soap=new SoapClient($this->params[$paidKey]['url'], $this->debug?array('trace'=>1, 'exceptions'=>0):array());
        //$soap=$this->_soap=new SoapClient($this->params[$paidKey]['url'], array('trace'=>1, 'exceptions'=>0));
    	$header=new SoapVar(
    		self::array2XMLBody('UserCredentials', array(
    			'@attributes'=>array('xmlns'=>$this->params[$paidKey]['ns']),
    			$paid?'userName':'UserName'=>$this->params[$paidKey]['username'],
    			$paid?'passWord':'PassWord'=>$this->params[$paidKey]['password']
    		)),
    		XSD_ANYXML, null, null, null);
            $soap->__setSoapHeaders(new SOAPHeader($this->params[$paidKey]['ns'], 'UserCredentials', $header));

    	$data=array(
    		'@attributes'=>array('xmlns'=>$this->params[$paidKey]['ns']),
    		$paid?'VehicleData':'vehicleData'=>self::array2XMLBody('VEHICLE_QUERY',
    			array_merge(
    				array(
    					'MEMBER_ID'=>Yii::app()->params['RIVehicleData']['memberID'],
    					'QUERY_ID'=>0,
    					'REGISTRATION'=>$registration
    				),
    				$addVehicleDataParams
    			)
    		)
    	);
    	return $data;
    }

    /**
     * @author Aleksander Stekman
     * @param string $registration Numer rejestracyjny samochodu
     * @return array() Wynik metody VehicleQueryReport soap RI
     * Np:
       array (
			  'VehicleData' =>
			  array (
			    'Make' => 'Citroen',
			    'Model' => 'Berlingo LX TD HDi 600',
			    'Model_Only' => 'Berlingo',
			    'Base_Model' => 'Berlingo',
			    'Engine_Size' => '2.0L',
			    'Fuel_Type' => 'DIESEL',
			    'Registration' => '05CW3106',
			    'Colour' => 'WHITE',
			    'Previous_Registration' => 'SA05LHN',
			    'Imported_Outside_UKIE' => 'false',
			  ),
			  'Valuation' =>
			  array (
			    'Value' => '2400',
			  ),
			  'REPORTS' =>
			  array (
			    0 => 'IrishHistoryFinance',
			    1 => 'IrishHistoryValuation',
			    6 => 'IrishUkHistory',
			    5 => 'FullIrishUkHistory',
			  ),
			  'matches' => '1',
			)
		lub
		array('matches'=>0) gdy brak wyników,
		lub
		array('errors'=>array(...)) tablica błędów podanych parametrów funkcji lub wykonanej metody soap systemu RI
     */
    public function vehicleFreeReport($registration)
    {
    	$result=$this->prepareVehicleQuery($registration);
    	if(!empty($result['errors']))
    		return $result;

	    $result=$this->query('VehicleFreeReport', $result);
	    if(empty($result['errors']))
	    {
			//                if(isset($_GET['dw_debug'])){
			//                    CVarDumper::dump($result);
			//                    $this->displayRIData(1, $result);
			//                    die;
			//                }
                
	    	$result['Result']['matches']=$result['Result']['@attributes']['Matches'];
	    	$result=$result['Result'];
	    	unset($result['@attributes']);
	    	if(isset($result['REPORTS']))
	    	{
	    		$cleanReports=array();
                        if(!isset($result['REPORTS']['REPORT'][0]))
                            $result['REPORTS']['REPORT']=array($result['REPORTS']['REPORT']);

	    		foreach($result['REPORTS']['REPORT'] as $r)
                        {
                            if(!empty($r['@attributes']))
	    			$cleanReports[$r['@attributes']['type']]=$r['@value'];
                        }
                        
	    		$result['REPORTS']=$cleanReports;
                        
	    	}
	    	else
	    		unset($result['REPORTS']);
	    }

	    return $result;
    }
    
    public function vehicleHistoryCheck($registration)
    {
    	$result=$this->prepareVehicleQuery($registration, array('UK_OPTION'=>2), true);
    	if(!empty($result['errors']))
    		return $result;

	    $result=$this->query('QueryVehicle', $result);
//            var_dump($result);
//            exit;
	    if(empty($result['errors']))
	    {
//                if(isset($_GET['dw_debug'])){
//                    CVarDumper::dump($result);
//                    $this->displayRIData(1, $result);
//                    die;
//                }
	    	$result['Result']['matches']=$result['Result']['@attributes']['Matches'];
	    	$result=$result['Result'];
	    	unset($result['@attributes']);
	    	if(isset($result['REPORTS']))
	    	{
	    		$cleanReports=array();
                        if(!isset($result['REPORTS']['REPORT'][0]))
                            $result['REPORTS']['REPORT']=array($result['REPORTS']['REPORT']);

	    		foreach($result['REPORTS']['REPORT'] as $r)
                        {
                            if(!empty($r['@attributes']))
	    			$cleanReports[$r['@attributes']['type']]=$r['@value'];
                        }
                        
	    		$result['REPORTS']=$cleanReports;
                        
	    	}
	    	else
	    		unset($result['REPORTS']);
	    }

	    return $result;
    }
    
    public static function displayRIData($level, $array){
        echo '</br>';
        foreach($array as $key=>$val){
            echo '<div style="margin-left:'.$level.'0px;"><b>'.$key.'</b>:&nbsp;';            
            if(is_array($val)){
                RIVehicleData::displayRIData($level+1, $val);
                 echo '</div><br>';     
            }else {
                echo ' '.$val.'</div><br>';            
            }
        }
    }

    /**
     * @author Aleksander Stekman
     * @param string $registration Numer rejestracyjny samochodu
     * @return array() Wynik metody VehicleQueryReport soap RI
     * Np:
array (
  'VehicleData' =>
  array (
    'Make' => 'Citroen',
    'Model' => 'Berlingo LX TD HDi 600',
    'Model_Only' => 'Berlingo',
    'Base_Model' => 'Berlingo',
    'Engine_CC' => '1997',
    'Engine_Size' => '2.0L',
    'Insurance_Cost_Range' => 'Low',
    'Number_Owners' =>
    array (
      '@value' => '1',
      '@attributes' =>
      array (
        'warning' => '0',
      ),
    ),
    'Doors' => '4',
    'Body_Type' => 'VAN',
    'Mapped_Body_Type' => 'VAN',
    'Fuel_Type' => 'DIESEL',
    'Transmission' => 'MANUAL',
    'Registration' => '05CW3106',
    'Chassis_Number' => 'V##############34',
    'Engine_Number' => 'DYVD3000528',
    'Year_Manufacture' => '2005',
    'Colour' => 'WHITE',
    'Number_Seats' => '2',
    'Registration_Status' => 'IMPORTED',
    'CO2_Emissions' => '',
    'Next_Tax_Expiry_Date' =>
    array (
      '@value' => '2010-01-31',
      '@attributes' =>
      array (
        'warning' => '0',
      ),
    ),
    'NCT_Expiry_date' =>
    array (
      '@value' => '',
      '@attributes' =>
      array (
        'nil' => 'true',
      ),
    ),
    'Previous_Registration' => 'SA05LHN',
    'Imported_Outside_UKIE' => 'false',
    'Tax_Rate_Type' => '',
    'Tax_Cost' => '',
    'History_Status' =>
    array (
      'Warning_Level' => 'Red',
      'Warnings' =>
      array (
        'Warning' =>
        array (
          0 => 'This vehicle has been imported',
          1 => 'Tax expired more than 120 days',
        ),
      ),
    ),
  ),
  'Risk_Indicators' =>
  array (
    'Scrapped_Vehicle_Destroyed' => 'false',
    'Written_Off_By_Insurer' => 'false',
    'Taxi_Currently' => 'false',
    'Taxi_Previously' => 'false',
    'Hackney_Currently' => 'false',
    'Hackney_Previously' => 'false',
    'Change_In_Engine_Number' => 'false',
    'Change_In_Colour' => 'false',
  ),
  'Valuation' =>
  array (
    'Value' => '2400',
    'Range' => '2300 - 2550',
  ),
  'NCAP' =>
  array (
    'Pre_2009' =>
    array (
      'Adult' => '4',
      'Child' => '3',
      'Pedestrian' => '2',
    ),
  ),
  'matches' => '1',
)
		lub
		array('matches'=>0) gdy brak wyników,
		lub
		array('errors'=>array(...)) tablica błędów podanych parametrów funkcji lub wykonanej metody soap systemu RI
     */
    public function queryVehicle($registration)
    {
    	$result=$this->prepareVehicleQuery($registration, array('UK_OPTION'=>2), true);
    	if(!empty($result['errors']))
    		return $result;

    	$result=$this->query('QueryVehicle', $result);
    	if(empty($result['errors']))
    	{
    		$result['Result']['matches']=$result['Result']['@attributes']['Matches'];
    		$result=$result['Result'];
    		unset($result['@attributes']);

    	}

    	return $result;
    }
}