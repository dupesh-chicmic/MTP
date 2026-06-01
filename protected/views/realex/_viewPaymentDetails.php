<div class="orange">A/c No: <?php echo $qpayRequest->invoices[0]->bp_id; ?></div>
<div class="orange">Invoices: <?php echo implode(', ', CHtml::listData($qpayRequest->invoices, 'id', 'no')); ?></div>
<div class="orange">Total invoices: <?php echo count($qpayRequest->invoices); ?></div>
<div class="orange">Total amount: &euro;<?php echo Yii::app()->numberFormatter->formatCurrency($qpayRequest->amount, ''); ?></div>