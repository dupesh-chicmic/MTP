<?php

/**
 * This is the model class for table "email".
 *
 * The followings are the available columns in table 'email':
 * @property integer $id
 * @property string $sender
 * @property string $recipient
 * @property string $title
 * @property string $text
 * @property integer $status
 * @property integer $email_status
 * @property string $lic_exp
 */
class Email extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Email the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, email_status', 'numerical', 'integerOnly'=>true),
			array('sender, recipient', 'length', 'max'=>100),
			array('title', 'length', 'max'=>200),
			array('text, lic_exp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sender, recipient, title, text, status, email_status, lic_exp', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sender' => 'Sender',
			'recipient' => 'Recipient',
			'title' => 'Title',
			'text' => 'Text',
			'status' => 'Status',
			'email_status' => 'Email Status',
			'lic_exp' => 'Lic Exp',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('recipient',$this->recipient,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('email_status',$this->email_status);
		$criteria->compare('lic_exp',$this->lic_exp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function sendEmail ($userEmail, $newPass) {
            Yii::import('application.extensions.phpmailer.JPhpMailer');
            //require_once Yii::app()->basePath . '/extensions/phpmailer/PHPMailerAutoload.php';
            //require_once Yii::app()->basePath . '/extensions/phpmailer/class.phpmailer.php';
            
            $emailTo = $userEmail;
            $fromEmail = 'carguide@mtp.ie';
            $fromName = 'MTP';
            $subject = 'MTP - Reset Password';
            
            $mail = new JPhpMailer;
            $mail->isSendmail();
            $mail->setFrom($fromEmail, $fromName);
            $mail->addReplyTo($fromEmail, $fromName);
            $mail->AddAddress($emailTo, $emailTo);
            $mail->Subject = $subject;
            
            $mail->Body = 
                   '<p>Hi,</p>' .
                   '<p>Your new password is: <b>' . $newPass . '</b></p>' .
                   '<p>Kind Regards,</p>' .
                   '<p>The MTP Team</p>';
            $mail->isHTML(true);
            $result = $mail->send();
            return $result;
        }
}