<?php
class QpayrealexController extends Controller
{
	public function actionRequest()
	{
		/*$testFixAmount=[
			10,
			1.23,
			'1,34',
			0.01, '0.01',
			'345,1234567',
			];
		foreach($testFixAmount as $tf)
		var_dump(
			QPayRealexRequest::amountToInt($tf)
		);
		die;
*/
		$realexRequest=new QPayRealexRequest;
		$this->module->currentRequest=$realexRequest;
		$realexRequest->attributes=array(
			'amount'=>'100',
		);
		if(!$realexRequest->makeRequest())
			var_dump($realexRequest->errors);
		else
		{
			$this->render('form', array('realexRequest'=>$realexRequest));
		}
	}

	public function actionResponse()
	{
		Yii::log("Realex response:\nPost - ".var_export($_POST, true)."\nGet -".var_export($_GET, true), 'info', 'qpay');
		try
		{
			if(Yii::app()->request->isPostRequest&&isset($_POST['ORDER_ID']))
			{
				if($realexResponse=QPayRealexRequest::model()->findByPk($_POST['ORDER_ID']))
				{
					$this->module->currentRequest=$realexResponse;
					if(!$realexResponse->hasResponse())
					{
						$realexResponse->scenario='response';
						if($realexResponse->parseResponse($_POST))
						{
							if(!$realexResponse->save()){
                                                            Yii::log("Error saving realex response:\n", 'info', 'qpay');
                                                            throw new Exception("Error saving realex response:\n");
                                                        }                                                          
                                                            
                                                        
								
							Yii::trace('Realex response succesfuly parsed. Forwarding to '.$this->module->responseRoute, 'realex');
							$this->forward($this->module->responseRoute);
						}
						else{
                                                    Yii::log("Error parsing realex response:\n", 'info', 'qpay');
                                                    throw new Exception("Error parsing realex response:\n");
                                                }
							//throw new Exception("Error parsing realex response:\n".QModel::implodeErrors($realexResponse, ','));
                                                    
					}
					else
						throw new Exception('Already responsed.');
				}
				else
					throw new Exception('Request not found.');
			}
			else
				throw new Exception('Invalid request.');
		}
		catch (Exception $e)
		{
			Yii::log("Realex response:\n".$e->getMessage(), 'info', 'qpay');
		}
	}

	public function actionViewLog()
	{
		foreach(Yii::app()->log->routes as $route)
		{
			if($route->categories=='qpay')
			{
				$path=$route->logPath.DIRECTORY_SEPARATOR.$route->logFile;
				if(is_file($path))
				{
					if(!empty($_POST['clearLog']))
					{
						ftruncate(fopen($path, 'r+'), 0);
						$this->redirect(Yii::app()->request->urlReferrer);
					}

					$log=file_get_contents($path);
					$this->render('viewLogs', array('log'=>$log));
				}
				else
					echo 'Brak pliku logu qpay';
				Yii::app()->end();
			}
		}
		echo 'Nie znaleziono defininicji logu qpay.';
	}

	public function actionHandleResponse()
	{
		if($qpayRequest=$this->module->currentRequest)
		{
			if($qpayRequest->isSuccessful)
				echo 'Request successful.';
			elseif($qpayRequest->isCanceled)
				echo 'Request was canceled. '.$qpayRequest->message;
			else
				echo 'Request was not successful. '.$qpayRequest->message;
		}
		else
			throw new Exception('No current qpay request.');
	}
}