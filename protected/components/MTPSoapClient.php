<?php
class MTPSoapClient extends SoapClient{

    
    
    public function __doRequest($request, $location, $action, $version, $one_way = null){
//        $this->qlog = new Qlog;
//        $this->qlog->source='web';
//        $this->qlog->source = $this->source;
//        $webRootPath = \Yii::$app->params['cenergise']['webroot'];
//        $curlPathCommand = \Yii::$app->params['cenergise']['curlPathCommand'];
        //$apiURL='https://vqs.riskintelligence.ie/VehicleQueryReport.asmx';//$location;  //$location;//\Yii::$app->params['cenergise']['apiURL'];
        $apiURL='https://vqslx.riskintelligence.ie/VehicleQueryReport.asmx';//$location;  //$location;//\Yii::$app->params['cenergise']['apiURL'];
        $apiEndPoint= 'https://vqslx.riskintelligence.ie/VehicleQueryReport.asmx';
        
//        $certFileName= \Yii::$app->params['cenergise']['certFile'];
//        $certFilePass= \Yii::$app->params['cenergise']['certFilePass'];
        
//        echo 'request:------------>'.$request.'<br/>';
//        echo 'location:------------>'.$location.'<br/>';
//        echo 'action:------------>'.$action.'<br/>';
//        echo 'ver:------------>'.$version.'<br/>';
//        echo 'onbeway:------------>'.$one_way.'<br/>';
        
//        if($action=='KeepAlive'){
//            $request = str_replace('userLoginName', 'ns1:userLoginName', $request);
//            $request = str_replace('sessionKey', 'ns1:sessionKey', $request);
//        }
        
        
        //$file = $this->saveRequestToFile($request);
        $file = '/opt/bitnami/apache2/htdocs/theguide/dev/pictures/files/request3.xml';
        //$resultPath = $this->getPathForXML().'result.xml';
        $len = filesize($file);
       //LINUX $command = 'curl -v -X POST -k --tlsv1.2 -d @' . $file . ' -L --cert C:\inetpub\wwwroot\etsuk\web/sert/ets/certboth.pem:cen8gise https://ets-simu2.api.epexspot.com:4444/OpenAccess/3.0 -H "Content-Type: text/xml; charset=utf-8" -H "SOAPAction: '.$action.'" -H "Host: ets-simu2.api.epexspot.com" -H "Connection: Keep-Alive" -H "User-Agent: Apache-HttpClient/4.1.1 (java 1.5)" -H "Content-length: '.$len.'"';
       //WIn:
        $command = 'curl -v -X POST -k -m 120 --user mtpfree:XMG3HE7d -d @' . $file . ' '.$apiEndPoint.' -H "Content-Type: text/xml; charset=utf-8" -H "SOAPAction: '.$action.'" -H "Host: '.$apiURL.'" -H "Connection: Keep-Alive" -H "User-Agent: Apache-HttpClient/4.1.1 (java 1.5)" -H "Content-length: '.$len.'"';
 echo $command;
            exit;
//        if ($displayCommandOnly) {
//            echo $command;
//            exit;
//        }

//        $status = null;
//        if($action=='SetNewPassword'){
//            $this->qlog->request = 'Not stored, details available in log';
//        }else {
//            $this->qlog->request = $request;
//        }
//        
//        $this->qlog->api_method = $action;
//        $this->qlog->cli_cmd = $command;
//        if(!$this->qlog->save()){
//            echo '<br/>error saving qlog!<br/>';
//            var_dump($this->qlog->getErrors());
//        }
        $result = exec($command, $status);
        var_dump($result);
        //$handle = popen($command, 'r');
        //$result = fgets($handle);
//        $this->qlog->response = $result;
//        if($action=='KeepAlive'){
//            $this->qlog->status = $this->getIsAlive();
//        }else {
//            $this->qlog->status = $this->getStatus();
//        }
//        
//        $this->qlog->called_at = date("Y-m-d H:i:s");
//        
//        //echo $result;
//        $xml = simplexml_load_string($result);
//        $json = json_encode($xml);
//        $array = json_decode($json,TRUE);
//        
//        $this->qlog->out_res_json = $json;
//        
//        //sjon too
//        
//        if(!$this->qlog->save()){
//            echo '<br/>error saving qlog!<br/>';
//            var_dump($this->qlog->getErrors());
//        }
//        if (!$result) {
//            return array('error executing curl command');
//        }
//        
        
       // file_put_contents($resultPath, $result);
        
//       
    }
    
    
    public function saveRequestToFile($soapRequest){
        $file = $this->getPathForXML().'request2.xml';
        $file;
        //exit;                
        
        
        //$string = rtrim(ltrim($soapRequest));
        $string = trim(preg_replace('/\s\s+/', '', $soapRequest));
        $string = str_replace("\r\n", '', $string);
        $string = str_replace("\r", '', $string);
        $string = str_replace("\n", '', $string);
        //file_put_contents($file,$soapRequest);
        //$string = preg_replace('/\s+/', '', $soapRequest);
        file_put_contents($file,$string);
//        $doc = new \DOMDocument();
//        $doc->load($file);
//        $fileDestination = $this->getPathForXML().'request.xml';
//        $doc->save($fileDestination);
        return $file;
        
                
    }
    
    public function getPathForXML() {
        $webRootPath = '/opt/bitnami/apache2/htdocs/theguide/dev/pictures/files/';
        $path = $webRootPath;
//        if($this->console){
//            $path = $webRootPath.'web/ets/xmls/console/' . date("Y-m-d") . '/';
//        }else {
//            $path = $webRootPath.'web/ets/xmls/' . date("Y-m-d") . '/';
//        }
        
        if (!file_exists($path)) {
            mkdir($path);
        }
        //$path .= date("Hmi").'/';
//        if (!file_exists($path)) {
//            mkdir($path);
//        }
        return $path;
    }
    
}