<?php
class Valuation extends CFormModel
{
	public $verifyCode;

	public function rules()
	{
		return array(
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
            array('verifyCode', 'required'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
		);
	}
}