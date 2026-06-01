<?php
class MRealexRequest extends QPayRealexRequest
{
	public static function handleResponse($realexRequest)
	{
		if($realexRequest->isSuccessful)
		{
			foreach($realexRequest->request->invoices as $invoice)
				$invoice->saveAttributes(array('status'=>Invoice::STAT_PAID));
		}
	}
}