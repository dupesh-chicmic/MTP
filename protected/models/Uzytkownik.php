<?php

/**
 * This is the model class for table "uzytkownik".
 */
class Uzytkownik extends CActiveRecord
{
    const PARAM_USED_CARS = "CARS"; 
    const PARAM_USED_COMMERCIAL = "COMMERCIAL";
    
    public static $VIDEO_YOUTUBE_ID = 'FSk2m4boAkg';
	/**
	 * The followings are the available columns in table 'uzytkownik':
	 * @var integer $id
	 * @var string $login
	 * @var string $haslo
	 * @var string $ostatnie_nieudane_logowanie
	 * @var integer $typ_uzytkownika
	 * @var integer $status_uzytkownika
	 * @var string $imie
	 * @var string $nazwisko
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Uzytkownik the static model class
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
		return 'uzytkownik';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
       return array(
            array('login', 'unique', 'message' => "This user's name already exists."), // new!
           array('email', 'unique', 'message' => "This email is already used by another user."), // new!
            array('login, email, typ_uzytkownika, imie, nazwisko', 'required'),
            array('used_cars, used_com_cars, trial, pages, dinkey, mobile_on, checks, network_licences_number, free_tokens', 'numerical', 'integerOnly'=>true),
            array('login, haslo, imie, nazwisko, sid, mobile_token, desktop_token, guide_mobile_token, guide_mobile_token_ios', 'length', 'max'=>50),
            array('email', 'length', 'max'=>254),
            array('typ_uzytkownika, status_uzytkownika', 'length', 'max'=>10),
            array('ostatnie_nieudane_logowanie, lic_start_cars, lic_exp_cars, lic_start_comm, network_licences_number, lic_exp_comm, lic_start_cars_mob, lic_exp_cars_mob, lic_start_comm_mob, lic_exp_comm_mob, email', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, login, haslo, email, ostatnie_nieudane_logowanie, typ_uzytkownika, network_licences_number, status_uzytkownika, imie, nazwisko, sid, lic_start_cars, lic_exp_cars, used_cars, used_com_cars, trial, pages, dinkey, mobile_on, mobile_token, desktop_token, guide_mobile_token, guide_mobile_token_ios checks, free_tokens, lic_start_comm, lic_exp_comm, lic_start_cars_mob, lic_exp_cars_mob, lic_start_comm_mob, lic_exp_comm_mob', 'safe', 'on'=>'search'),
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
			'klient' => array(self::HAS_ONE, 'Klient', 'id_uzytkownika'),
			'pracownik' => array(self::HAS_ONE, 'Pracownik', 'id_uzytkownika'),
                        'elementyZamowienia' => array(self::HAS_MANY, 'ElementZamowienia', 'id_uzytkownika'),
                        'wlasnoscElemZams' => array(self::HAS_MANY, 'WlasnoscElemZam', 'id_uzytkownika'),
                        'wplaty' => array(self::HAS_MANY, 'Wplata', 'id_uzytkownika'),
                        //'email' => array(self::HAS_MANY, 'Email', 'recipient','joinType'=>'INNER JOIN'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
        return array(
            'id' => 'ID',
            'login' => 'Login',
            'haslo' => 'Password',
            'ostatnie_nieudane_logowanie' => 'Ostatnie Nieudane Logowanie',
            'typ_uzytkownika' => 'User Type',
            'status_uzytkownika' => 'User Status',
            'email' => ' Email',
            'imie' => 'First name',
            'nazwisko' => 'Last name',
            'sid' => 'Session ID',
            'lic_start_cars' => 'Licence Start for Cars',
            'lic_exp_cars' => 'Licence Expired for Cars',
            'used_cars' => 'Used Cars',
            'used_com_cars' => 'Used Commercial',
            'trial' => 'Trial',
            'pages' => 'Pages',
            'dinkey' => 'Dinkey',
            'mobile_on' => 'Mobile On',
            'network_licences_number' => 'Number of network licen.',
            'mobile_token' => 'Mobile Token',
            'desktop_token' => 'Desktop Token',
            'guide_mobile_token' => 'Guide Browser Token',
			'guide_mobile_token_ios' => 'Guide Home screen token iOS',
            'checks' => 'Checks',
            'free_tokens' => 'Free Tokens',
            'lic_start_comm' => 'Licence Start for Commercial',
            'lic_exp_comm' => 'Licence Expired for Commercial',
            'lic_start_cars_mob' => 'Licence Start for Cars - Mobile',
            'lic_exp_cars_mob' => 'Licence Expired for Cars - Mobile',
            'lic_start_comm_mob' => 'Licence Start for Commercial - Mobile',
            'lic_exp_comm_mob' => 'Licence Expired for Commercial - Mobile',
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

		$criteria->compare('login',$this->login,true);

		$criteria->compare('haslo',$this->haslo,true);

		$criteria->compare('ostatnie_nieudane_logowanie',$this->ostatnie_nieudane_logowanie,true);

		$criteria->compare('typ_uzytkownika',$this->typ_uzytkownika);

		$criteria->compare('status_uzytkownika',$this->status_uzytkownika);
                
                $criteria->compare('email',$this->email,true);

		$criteria->compare('imie',$this->imie,true);

		$criteria->compare('nazwisko',$this->nazwisko,true);

        $criteria->compare('lic_start_cars',$this->lic_start_cars,true);
        $criteria->compare('lic_exp_cars',$this->lic_exp_cars,true);

		$criteria->compare('used_cars',$this->used_cars);
		$criteria->compare('used_com_cars',$this->used_com_cars);
		$criteria->compare('trial',$this->trial);
		$criteria->compare('pages',$this->pages);

        $criteria->compare('dinkey',$this->dinkey);
        $criteria->compare('checks',$this->checks);
        $criteria->compare('free_tokens',$this->free_tokens);
        
        $criteria->compare('lic_start_comm',$this->lic_start_comm,true);
        $criteria->compare('lic_exp_comm',$this->lic_exp_comm,true);
        $criteria->compare('lic_start_cars_mob',$this->lic_start_cars_mob,true);
        $criteria->compare('lic_exp_cars_mob',$this->lic_exp_cars_mob,true);
        $criteria->compare('lic_start_comm_mob',$this->lic_start_comm_mob,true);
        $criteria->compare('lic_exp_comm_mob',$this->lic_exp_comm_mob,true);   
        $criteria->compare('network_licences_number',$this->network_licences_number);

                $criteria->having='`typ_uzytkownika` <> 1002';

//                $criteria->condition="`typ_uzytkownika` <> 1002"; //nie pokazuj admina i su


		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    protected function beforeSave()
    {
        if($this->isNewRecord)//insert
        {
            //czy istnieje konto o podanym loginie (emailu)
            if($this->exists('login=:login', array(':login'=>$this->login)))
            {
                $this->addError('email', 'A user account with the given email address already exists in the system');
                return false;
            }
        }
        else//update
        {
            //czy istnieje konto o podanym loginie, poza aktualizowanym rekordem
            if($this->exists('login=:login AND id<>:id', array(':login'=>$this->login, ':id'=>$this->id)))
            {
                $this->addError('email', 'A user account with the given email address already exists in the system');
                return false;
            }
        }

        if(strlen($this->haslo)>0)
        {
            $this->haslo=UserIdentity::encryptPassword($this->haslo);
        }

        $this->nazwisko=strtoupper($this->nazwisko);
        $this->imie=strtoupper($this->imie);

        return parent::beforeSave();
    }

    public function confirm()
    {
        $this->status_uzytkownika=1;
        $this->saveAttributes(array('status_uzytkownika'));
    }

    public static function wczytaj($id)
    {
        return Uzytkownik::model()->findByPk($id);
    }

    public function getName()
    {
        return $this->nazwisko.' '.$this->imie;
    }

    public function getIsAgency()
    {
        if($this->klientFirma)
                if($this->klientFirma->firma)
                        return $this->klientFirma->firma->typ_firmy==Slownik::getIdFromName('agencja','typ firmy');
        return false;
    }

    /**
     *
     * @deprecated use getIsEmployee instead
     */
    public function isEmployee()
    {
        return $this->getIsEmployee();
    }

    public function getIsEmployee()
    {
        return $this->typ_uzytkownika<Slownik::getIdFromName('klient administrator', 'typ_uzytkownika');
    }

    public function load($id)
    {
        return self::model()->findByPk($id);
    }
    
    

    public static function generateNewPassword(){
        $newPassword = '';
        for ($i=0; $i<10; $i++) {
            $losuj=rand(1,30)%2; //T/F
            if($losuj){
                $losuj2=rand(1,30)%2;
                if($losuj2){
                    $newPassword .= chr(rand(65,90)); //A-Z
                }else{
                    $newPassword .= chr(rand(97,122)); //a-z
                }
            }else{
                $newPassword .= chr(rand(48,57)); //0-9
            }
        }
        return $newPassword;
    }

    public static function checkDifferenceBetweenExpirationDates($user)
    {
        $msg = '';
        if($user->lic_start_cars == '')
            $msg .= '<b>Used Cars Desktop</b> Start date of the license can not be empty.<br />';
        if($user->lic_exp_cars == '')
            $msg .= '<b>Used Cars Desktop</b> Expiration date of the license can not be empty.<br />';          
        if($user->lic_start_comm == '')
            $msg .= '<b>Used Commercial Desktop</b> Start date of the license can not be empty.<br />';
        if($user->lic_exp_comm == '')
            $msg .= '<b>Used Commercial Desktop</b> Expiration date of the license can not be empty.<br />';  
        if($user->lic_start_cars_mob == '')
            $msg .= '<b>Used Cars Mobile</b> Start date of the license can not be empty.<br />';
        if($user->lic_exp_cars_mob == '')
            $msg .= '<b>Used Cars Mobile</b> Expiration date of the license can not be empty.<br />';          
        if($user->lic_start_comm_mob == '')
            $msg .= '<b>Used Commercial Mobile</b> Start date of the license can not be empty.<br />';
        if($user->lic_exp_comm_mob == '')
            $msg .= '<b>Used Commercial Mobile</b> Expiration date of the license can not be empty.<br />';   
        
        if($msg == '')
        {
            //lic_exp_date must be >= today
            if($user->lic_exp_cars < $user->lic_start_cars)
            {
                $msg .= 'In <b>Used Cars Desktop</b> Start date of the license can not be greater than the expiration.<br />';
            }
            if($user->lic_exp_comm < $user->lic_start_comm)
            {
                $msg .= 'In <b>Used Commercial Desktop</b> Start date of the license can not be greater than the expiration.<br />';
            }
            if($user->lic_exp_cars_mob < $user->lic_start_cars_mob)
            {
                $msg .= 'In <b>Used Cars Mobile</b> Start date of the license can not be greater than the expiration.<br />';
            }
            if($user->lic_exp_comm_mob < $user->lic_start_comm_mob)
            {
                $msg .= 'In <b>Used Commercial Mobile</b> Start date of the license can not be greater than the expiration.<br />';
            }
        }
        if($msg != '')
        {
            Yii::app()->user->setFlash('errorMsg',$msg);
            return false;
        }
        return true;
    }
    
    public static function getCarsLicenseStartDate(){
        $model = Uzytkownik::model()->find( 'id=?',array(Yii::app()->user->getId() ));
        if(empty($model))
            return false;
        
        return date("Y-m-d",  strtotime($model->lic_start_cars));
    }
    
    public static function getCommsLicenseStartDate(){
        $model = Uzytkownik::model()->find( 'id=?',array(Yii::app()->user->getId() ));
        if(empty($model))
            return false;
        
        return date("Y-m-d", strtotime($model->lic_start_comm));
    }
    

    public static function checkExpirationDate($isCarsOrComm){
        $model = Uzytkownik::model()->find( 'id=?',array(Yii::app()->user->getId() ));
        if(empty($model))
            return false;
        
        switch($isCarsOrComm)
        {
            case Uzytkownik::PARAM_USED_CARS:
                return Uzytkownik::checkExpirationDateForCars($model);
            case Uzytkownik::PARAM_USED_COMMERCIAL:
                return Uzytkownik::checkExpirationDateForCommercial($model);
            default:
                return false;
        }
    }
    
    private static function checkExpirationDateForCars($model)
    {
        if(Yii::app()->mobileDetect->isMobile() || Yii::app()->mobileDetect->isTablet())
        {
            return (date("Y-m-d") > $model->lic_exp_cars_mob) ? false : true;
        }
        else
        {
            return (date("Y-m-d") > $model->lic_exp_cars) ? false : true;
        }        
    }
    
    private static function checkExpirationDateForCommercial($model)
    {
        if(Yii::app()->mobileDetect->isMobile() || Yii::app()->mobileDetect->isTablet())
        {
            return (date("Y-m-d") > $model->lic_exp_comm_mob) ? false : true;
        }
        else
        {
            return (date("Y-m-d") > $model->lic_exp_comm) ? false : true;
        }        
    }    
    
    /**
     * Jesli flaga used_cars lub used_com_cars jest ustawiona na 
     * 1 zwraca true
     * 0 zwraca false
     * @return boolean
     */
    public static function checkProductIsOn($carsOrComm)
    {
        $model = Uzytkownik::model()->find('id=?',array(Yii::app()->user->getId()));
        if($carsOrComm == Uzytkownik::PARAM_USED_CARS)
        {
            return ($model->used_cars == 1);
        }
        else if($carsOrComm == Uzytkownik::PARAM_USED_COMMERCIAL)
        {
            return ($model->used_com_cars == 1);
        }
        else
        {
            return false;
        }
    }

    public function getVideo()
    {
        return '<a class="youtube" href="http://www.youtube.com/embed/'.self::$VIDEO_YOUTUBE_ID.'?rel=0&amp;wmode=transparent" title=""><div id="player"></div></a>';
    }

    final public function validateChangePassword($tempCurrentPassword_encrypted,$oldPasswordField,$newPasswordField,$newPasswordField_confirm){
        $newPassword = null;

        $encrypted_old_password = sha1($oldPasswordField);
        $encrypted_new_password = sha1($newPasswordField);
        $encrypted_new_password_confirm = sha1($newPasswordField_confirm);

        if($tempCurrentPassword_encrypted === $encrypted_old_password){
            //correct

            //check is confirm password = confim_password
            if($encrypted_new_password === $encrypted_new_password_confirm){
                Yii::app()->user->setFlash('accountSuccess','Data was updated successfully<br />Password was changed.');
                $newPassword = $newPasswordField;// important $newPasswordField must be DEcrypted !
                return $newPassword;
            }else{
                Yii::app()->user->setFlash('accountError','Confirm new password must match the password field.');
                return null;
            }
        }else{
            Yii::app()->user->setFlash('accountError','Old password does not match the current.');
        }
        return null;

    }

    public function carOrComGuideVisibility_trialIncluded($dbField,$userId){
        // if trial = 1 User can see the dbField(car/userCar) site
        if(empty($userId))
        {
            $visible = false;
        }
        else
        {
            $model = Uzytkownik::model()->find(array(
                'condition'=>'id=:uid',
                'params'=>array(':uid'=>$userId)
            ));
            if($model->trial == 1)
            {
                $visible = ($model->$dbField == 0) ? false : true;
            }
            else
            {
                $visible = true;
            }
        }
        return $visible;
    }

    public function trialOn(){
        $userId = Yii::app()->user->getId();
        if(empty($userId)){
            $visible = false;
        }else{
            $model = Uzytkownik::model()->find(array(
                'condition'=>'id=:uid AND trial=:tr ',
                'params'=>array(':uid'=>$userId, ':tr'=>1)
            ));
            $visible = (empty($model)) ? false : true;
        }
        return $visible;
    }

    public function dinkeyRequired(){
        $userId = Yii::app()->user->getId();
        if(empty($userId)){
            $visible = FALSE;
        }else{
            $model = Uzytkownik::model()->find(array(
                'condition'=>'id=:uid AND dinkey=:tr ',
                'params'=>array(':uid'=>$userId, ':tr'=>1)
            ));
            $visible = (empty($model)) ? false : true;
        }
        return $visible;
    }

    public static function getUserChecksStatus(){
        if(!Yii::app()->user->isGuest)
        {
            $lvUser = Uzytkownik::model()->find(array(
                'condition'=>'id=:id',
                'params'=>array(':id'=>Yii::app()->user->getId())
                ));
            return $lvUser->checks;
        }
        return 0;
    }
    
    public static function getCookieName()
    {
        return (Yii::app()->params['is_test_version']) ? 'mtp_test_version_desktop_token' : 'mtp_desktop_token';
    }
    
    
    public static function checkNumberOfLiveNetworkUserSessions($lvUser)
    {
        
        $currentSessions = UzytkownikSessions::model()->findAll('uzytkownik_id=:user_id', array('user_id'=>$lvUser->id));
        
        //echo sizeof($currentSessions);
        return sizeof($currentSessions);
        //exit;
    }
    
    public static function cleanUnusedNetworkSessions()
    {
        $lvUser = Uzytkownik::model()->find(array(
                'condition'=>'id=:id',
                'params'=>array(':id'=>Yii::app()->user->getId())
            ));
        if(!empty($lvUser->network_licences_number)){
            $activeSession = UzytkownikSessions::model()->deleteAll('uzytkownik_id=:user_id AND `when` < NOW() - INTERVAL 20 MINUTE', array('user_id'=>$lvUser->id));
            
        }
        return true;
       // echo sizeof($currentSessions);
        //exit;
    }
    
    
    public static function destroyNetworkSession()
    {
        $lvUser = Uzytkownik::model()->find(array(
                'condition'=>'id=:id',
                'params'=>array(':id'=>Yii::app()->user->getId())
            ));
        if(!empty($lvUser->network_licences_number)){
            $activeSession = UzytkownikSessions::model()->deleteAll('uzytkownik_id=:user_id AND sid=:sid', array('user_id'=>$lvUser->id, 'sid'=>Yii::app()->session->sessionID));
            
        }
        return true;
       // echo sizeof($currentSessions);
        //exit;
    }
    
    public static function updateNetworkUserSession(){
             $lvUser = Uzytkownik::model()->find(array(
                'condition'=>'id=:id',
                'params'=>array(':id'=>Yii::app()->user->getId())
            ));
            if(!empty($lvUser->network_licences_number)){
                //user is a network user - will not have token - check number f logged in users already and grant or deny access.
                $liveSessions = Uzytkownik::checkNumberOfLiveNetworkUserSessions($lvUser);

                $currentSession = UzytkownikSessions::model()->find('uzytkownik_id=:user_id AND sid=:sid', array('user_id'=>$lvUser->id, 'sid'=>Yii::app()->session->sessionID));
                if(!empty($currentSession)){
                    $currentSession->when = new CDbExpression("NOW()");
                    $currentSession->save();
                }else {
                    if($liveSessions >= ($lvUser->network_licences_number)){
                       // Yii::app()->request->redirect('/path/to/url');
                        Yii::app()->getController()->redirect(array('/site/tooManyActiveNetworkUsers', 'reason'=>1));
                    }else {
                        $newSession = new UzytkownikSessions;
                        $newSession->uzytkownik_id = $lvUser->id;
                        $newSession->sid = Yii::app()->session->sessionID;
                        if($newSession->save()){
                          //  echo 'Session saved';
                        }else {
                            echo 'couldn\'t store session';
                        }
                    }
                }
                
                
                
                
               
            }
    }

    
    public static function checkDesktopCookie()
    {
        
        $lvUser = Uzytkownik::model()->find(array(
                'condition'=>'id=:id',
                'params'=>array(':id'=>Yii::app()->user->getId())
            ));
            if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){
                if(!empty($lvUser->network_licences_number)){
                    //user is a network user - will not have token - check number f logged in users already and grant or deny access.
                    $liveSessions = Uzytkownik::checkNumberOfLiveNetworkUserSessions($lvUser);
                   // echo 'live sessions'.$liveSessions;
                  //  echo 'allowsed sessions'.($lvUser->network_licences_number);
                    //exit;
                    if($liveSessions >= ($lvUser->network_licences_number)){
                       // echo 'not enough licences';
                        Yii::app()->getController()->redirect(array('/site/tooManyActiveNetworkUsers'));
                        exit;
                    }else {
                      //  echo ' storing new session';
                        $exist = UzytkownikSessions::model()->exists('uzytkownik_id=:user_id AND sid=:sid', array('user_id'=>$lvUser->id, 'sid'=>Yii::app()->session->sessionID));
                        if(!empty($exist)){
                          //  echo 'session already active';
                        }else {
                            $newSession = new UzytkownikSessions;
                            $newSession->uzytkownik_id = $lvUser->id;
                            $newSession->sid = Yii::app()->session->sessionID;
                            if($newSession->save()){
                              //  echo 'Session saved';
                            }else {
                                echo 'couldn\'t store session';
                            }
                        }
                        
                        return true;
                    }
                }

            }//api check end here
            $cookieName = Uzytkownik::getCookieName();
            // die(Yii::app()->user->getId().'me');
            if((empty($lvUser->desktop_token)))
            {
                Yii::app()->getController()->redirect(array('site/noDesktopToken'));
                exit;
            }
            
            // sprawdz czy token w ciastku uzytkownika jest = z ciastkiem w bazie
            if(!empty(Yii::app()->request->cookies[$cookieName]))
            {
                $lvCookieToken = Yii::app()->request->cookies[$cookieName]->value;
                //var_dump($lvCookieToken);
                if($lvCookieToken == $lvUser->desktop_token)
                {
                    //echo 'same as DB';
                    //extends expiry of teh cookie for another year.
                    $cookie = Yii::app()->request->cookies[$cookieName];
                    $cookie->expire = time()+60*60*24*380; // rok w sekundach
                    Yii::app()->request->cookies[$cookieName] = $cookie;
                    return true;
                }else {
                    //echo 'not same token';
                    Yii::app()->getController()->redirect(array('site/wrongDesktopToken'));
                    exit;
                }
            }
            else
            {
                Yii::app()->getController()->redirect(array('site/wrongDesktopToken'));
                
                exit;
                //echo 'should have token but doesn\'t - wrong computer';
                // ciastko sie przeterminowalo
            }
    }
    
    public static function storeDesktopCookie()
    {
        // echo "check on storeDesktopCookie model Uzytkownik ";
        // die(Yii::app()->user->getId());
        $lvUser = Uzytkownik::model()->find(array(
                'condition'=>'id=:id',
                'params'=>array(':id'=>Yii::app()->user->getId())
            ));
        $cookieName = Uzytkownik::getCookieName();

        //echo 'is first time';
        // zapisz nowy token do bazy 
        $lvUser->desktop_token = Mobile::generateToken($lvUser->id);
        // die(Yii::app()->user->getId());
        // $lvUser->update(array('desktop_token')); die;
        if($lvUser->update(array('desktop_token')))
        {
            //echo 'storing cookie: '.$lvUser->desktop_token;
            $cookie = new CHttpCookie($cookieName, $lvUser->desktop_token);
            $cookie->expire = time()+60*60*24*380; // rok w sekundach
            Yii::app()->request->cookies[$cookieName] = $cookie;
            return true;
        }else {
            echo 'couldnt save token to DB - storeDektopToken()';
            return false;
        }

    }
    
}
