<h2>Log qpay</h2>
<?php
echo CHtml::form().CHtml::hiddenField('clearLog', 1).CHtml::submitButton('Clear log').CHtml::endForm();
echo Yii::app()->format->nText($log);
