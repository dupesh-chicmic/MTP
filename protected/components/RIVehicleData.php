<?php
class RIVehicleData
{
	public $params;
	public $debug=true;
	public $paid=false;
	private $_soap;
	private $_lastMessageBody;
	private $_lastMessageXMLResponse;
	public $chassis;

    public function __construct($params=array(), $debug=false, $chassis=false)
    {
    	$params=CMap::mergeArray(Yii::app()->params['RIVehicleData'], $params);
    	if(empty($params['free']['ns']))
    		$params['free']['ns']='http://qdvs.moneymate.com/VehicleDataWebService/VehicleQueryReport/';
    		//$params['free']['ns']='https://vqs.riskintelligence.ie/VehicleDataWebService/VehicleQueryReport/';
    	if(empty($params['paid']['ns']))
    		$params['paid']['ns']='http://qdvs.moneymate.com/VehicleDataWebService/VehicleQuery/';
    		//$params['paid']['ns']='https://vqs.riskintelligence.ie/VehicleDataWebService/VehicleQueryReport/';
    	$this->params=$params;
		$this->debug=true;//$debug;
		$this->chassis = $chassis;
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
        $body=new SOAPVar($body, XSD_ANYXML);
    	$result=array();
    	$this->_lastMessageBody=$body;
    	try
    	{
    		$response=$this->_soap->$method($body);

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

    protected function prepareVehicleQuery($registration, $addVehicleDataParams=array(), $paid=false, $chassis=false)
    {
		$chassis = $this->chassis;

    	$errors=array();
    	if(empty($registration))
    		$errors[]='Registration cannot be blank.';

    	if(!empty($errors)){            
    		return array('errors'=>$errors);
        }

        $this->debug=true;
    	$paidKey=$paid?'paid':'free';
        
        /////////////
        $context = stream_context_create(array(
        'ssl' => array(
            'cacert' => '/home/bitnami/gd_bundle-g2.crt',
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        )
        );

        $wsdlPath = './wdsl.txt';
    	$soap=$this->_soap=new SoapClient($wsdlPath, $this->debug?array('trace'=>1, 'exceptions'=>0):array());
		
		if($chassis){
            $header=new SoapVar(                
    		self::array2XMLBody('UserCredentials', array(
    			'@attributes'=>array('xmlns'=>$this->params[$paidKey]['ns']),
    			$paid?'userName':'UserName'=>$this->params['openChassis']['username'],
    			$paid?'passWord':'PassWord'=>$this->params['openChassis']['password']
    		)),
    		XSD_ANYXML, null, null, null);
            $soap->__setSoapHeaders(new SOAPHeader($this->params[$paidKey]['ns'], 'UserCredentials', $header));
        }else {
    	$header=new SoapVar(
    		self::array2XMLBody('UserCredentials', array(
    			'@attributes'=>array('xmlns'=>$this->params[$paidKey]['ns']),
    			$paid?'userName':'UserName'=>$this->params[$paidKey]['username'],
    			$paid?'passWord':'PassWord'=>$this->params[$paidKey]['password']
    		)),
    		XSD_ANYXML, null, null, null);
            $soap->__setSoapHeaders(new SOAPHeader($this->params[$paidKey]['ns'], 'UserCredentials', $header));
		}
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
		
    	if(!empty($result['errors'])){
			return $result;
		}

	    $result = $this->query('VehicleFreeReport', $result);
	

	    if(empty($result['errors']))
	    {
			// if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){
            $date = date('d-m-Y');
			file_put_contents('protected/runtime/riQuery_'.$date.'.log', $registration."-->".json_encode($result)."\r\n", FILE_APPEND);
			// }
                
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

	    if(empty($result['errors']))
	    {
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