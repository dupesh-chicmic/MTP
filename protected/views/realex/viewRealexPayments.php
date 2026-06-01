<h2>Invoices paid with realex payment</h2>
<?php
$provider->criteria->mergeWith(array('order'=>'t.timestamp DESC'));
//$provider->pagination->pageSize=1;

$this->widget('zii.widgets.grid.CGridView', array(
    'summaryText'=>'',
    'dataProvider'=>$provider,
    'enableSorting'=>true,
	'filter'=>$filter,
    'columns'=>array(
    	array(
    		'header'=>'A/c No',
			'value'=>'$data->invoices[0]->bp_id',
    		'filter'=>CHtml::activeTextField($filterInvoice, 'bp_id'),
    	),
    	array(
    		'header'=>'Invoices',
    		'value'=>'implode(", ", CHtml::listData($data->invoices, "id", "no"))',//function($data){$nos=''; foreach($data->invoices as $i) $nos.=', '.$i->no; return $nos;},),
    		'filter'=>CHtml::activeTextField($filterInvoice, 'no')
    	),
    	array(
    		'header'=>'Total Payment',
    		'type'=>'raw',
    		'value'=>'"&euro;".Yii::app()->numberFormatter->formatCurrency($data->amount, "")',
    		'filter'=>CHtml::activeTextField($filter, 'amount'),
    	),
    	array(
    		'header'=>'Paid at',
    		'value'=>'$data->timestamp',
    	),
    	'id:text:Ref# (Realex Order ID)',
	)
));
echo CHtml::link('<<< Back to main Page', Yii::app()->homeUrl);