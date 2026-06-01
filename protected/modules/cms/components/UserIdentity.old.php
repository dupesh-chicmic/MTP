<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
         *
         */
	 
    const ERROR_SESSION_TIMEOUT=3;
    const ERROR_SESSION_UNKNOWN=4;
    const ERROR_GUEST=5;
    
    private $_id;

    public function authenticate()
    {
            $_user=Uzytkownik::model()->findByAttributes(array('login'=>$this->username));
            if($_user===null)
            { // No user found!
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            }
            else
                if($_user->haslo!==self::encryptPassword($this->password))
                {
                    // Invalid password!
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
                    $_user->ostatnie_nieudane_logowanie=new CDbExpression('NOW()');
                    $_user->saveAttributes(array('ostatnie_nieudane_logowanie'));
                }
                else
                {
                    $this->errorCode=self::ERROR_NONE;
                    $this->_id=$_user->id;
                    //TODO: poniższe rzeczy nie tutqaj mają być (WebUser->login() ?)
                    $this->setState('account_type', $_user->typ_uzytkownika);
                    if($_user->typ_uzytkownika>=10)
                            $this->setState('customer', true);
                    else if($_user->typ_uzytkownika==1)
                            $this->setState('admin', true);
                    else if($_user->typ_uzytkownika==2)
                            $this->setState('employee', true);
                }

        
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

    /*
     * Funkcja implementuje właściwy algorytm szyfrowania hasła, używany w aplikacji
     */
    public static function encryptPassword($password)
    {
        return sha1($password);
    }
}
