<?php
class TestController extends Controller
{
	public function actionTestRI()
	{
		$t=new RIVehicleData();
		//var_export($t->vehicleFreeReport('05CW3106'));
		var_export($t->queryVehicle('05CW3106'));
		var_export($t->getLastSoapMessage());
	}

	public function actionViewRealexTpl()
	{
		$this->renderPartial('viewRealexTpl');
	}
	
	public function actionTestRI() {
		echo 'bbb';
        //$file = "https://iedes.verisk.com/des/";
        $file = "https://vqs.riskintelligence.ie/";
//if (function_exists('curl_version'))
//{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $file);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $content = curl_exec($curl);
    curl_close($curl);
    echo 'a'.$content;
//}
//else if (file_get_contents(__FILE__) && ini_get('allow_url_fopen'))
//{
 //   $content = file_get_contents($file);
    
//}
//else
//{
 //   echo 'You have neither cUrl installed nor allow_url_fopen activated. Please setup one of those!';
//}
echo 'a'.$content;
//        echo 'a';
//        $file = file_get_contents('https://iedes.verisk.com/des/');
//        echo $file;
//        echo 'b';
        
    }
}