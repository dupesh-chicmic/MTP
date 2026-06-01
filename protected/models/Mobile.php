<?php
/**
 * 
 *******************************************************************************
 * <hr>
 * Plik: <b>Mobile.php</b><br> 
 * Autor: <b>Mariusz Winiarz</b><br>
 * Firma: <b>Qbix-Soft</b><br>
 * Data utworzenia: <b>10-07-2013</b><br>
 * <hr>
 *******************************************************************************
 * Klasa posiada kluczowe metody dostepu do danych dla wersji mobilnej strony
 *******************************************************************************
 * <hr> 
 * @author mariusz
 *******************************************************************************
 */
Class Mobile extends CActiveRecord
{
    public static $MOBILE_VERSION_PARENT_ID = 100; // ID od ktorego zostanie generowane menu glowne
    
    /**
     * Metoda zwraca czy User ma wlaczona opcje mobile
     * @return boolean
     */
    public static function getUserIsMobileOn()
    {
        if(!Yii::app()->user->isGuest)
        {
            $lvUser = Uzytkownik::model()->find(array(
                'condition'=>'id=:id',
                'params'=>array(':id'=>Yii::app()->user->getId())
            ));          
            if($lvUser->mobile_on == 1)
                return true;            
        }
        return false;
    }
    function object2array($object) { return @json_decode(@json_encode($object),1); } 
    public static function getDisplayYears($file)
    {
        $yearsArr = array();
        //$file = 'Yrs2Display_ByMake.xml';
        $dir = Yii::app()->params['import_folder'];
        $yearsFile = file_get_contents($dir.'/years/'.$file);
       // echo ' kms file path:'.'./'.$dir.'/'.$file;
        $yearsFile = htmlspecialchars($yearsFile);
        //$kms = simplexml_load_string(html_entity_decode(htmlentities($kms_file)), 'SimpleXMLElement', LIBXML_NOCDATA); // tak nie dziala import
        $links = simplexml_load_string(html_entity_decode($yearsFile), 'SimpleXMLElement', LIBXML_NOCDATA);
        
        $json = json_encode($links);
        $links = json_decode($json, true);
        
        foreach ($links as $row)
        {
            foreach ($row as $key=>$val)
            {
                $yearsArr[$val['@attributes']['year']] = $val['@attributes']['year'];
            }
        }
        return $yearsArr;
    }
    
    /**
     * Metoda sprawdza czy uzytkownik posiada dostep do zastrzezonych zasobow.
     * Sprawdzany jest token zapisany w ciastku uzytkownika.
     * Podczas pierwszego wejscia token zostaje wygenerowany i zapisany w
     * ciastku oraz w bazie danych w tabeli uzytkownik w kolumnie mobile_token.
     * Ciastko jest wazne przez rok.
     * @return boolean
     */
       
    public static function loginByCookie(){
        $cookieName = Mobile::getCookieName();
        $cookieLog = 'name:'.$cookieName.' - ';
        if(!empty(Yii::app()->request->cookies[$cookieName]))
        {  
            $cookieLog .= '!empty - ';
            
            //echo 'not empty cooks';
            $lvCookieToken = Yii::app()->request->cookies[$cookieName]->value;
            $cookieLog .= 'value:'.$lvCookieToken.' - ';
            $lvUser = Uzytkownik::model()->find(array(
                'condition'=>'guide_mobile_token=:token OR guide_mobile_token_ios=:token',
                'params'=>array(':token'=>$lvCookieToken)
            ));
            if(!empty($lvUser)){
                $cookieLog .= 'has user in DB '.$lvUser->id.'- ';
                //echo 'not empty user in cooks';
                $cookie = Yii::app()->request->cookies[$cookieName];
                $cookie->expire = time()+60*60*24*380; // rok w sekundach
                Yii::app()->request->cookies[$cookieName] = $cookie;
                
                $model = new LoginForm;
                $model->login = $lvUser->login;
                $model->password = $lvUser->haslo;
                $valid = $model->authenticateByCookie($lvUser->login,$lvUser->haslo);
                if($valid){
                    $cookieLog .= 'authenticated - ';
                }else {
                    // echo 'NOT VALID';
                    // echo 'err.'.$model->errorNumber;
                    $cookieLog .= 'Not authenticated - ';
                }
                file_put_contents('protected/runtime/cookieTracking.log', $cookieLog."\r\n", FILE_APPEND);
                return $valid;
                //add check if the user has licence.

            }else {
                $cookieLog .= 'Userempty in cooks - ';
                file_put_contents('protected/runtime/cookieTracking.log', $cookieLog."\r\n", FILE_APPEND);
                return false;
            }
        }else {
            $cookieLog .= 'is empty - ';
            
        }
        file_put_contents('protected/runtime/cookieTracking.log', $cookieLog."\r\n", FILE_APPEND);
        /*1. check if there is a cookie byu cookie name 
            2.if yes lookup user and log him in.
                3. if no let the login page render.*/
    }
    public static function checkCookie($isStandalone=0)
    {
        if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){
        return true; //TODO MW DEPLOY FIX
        exit;
        }

        //1. check 
        $lvUser = Uzytkownik::model()->find(array(
                'condition'=>'id=:id',
                'params'=>array(':id'=>Yii::app()->user->getId())
            ));
        //return true; //TODO MW DEPLOY FIX
        //exit;
        $cookieName = Mobile::getCookieName();
        $cookieLog = 'CHECK Cookie name: '.$cookieName.' - ';
        $cookieLog = 'user: '.$lvUser->id.' - ';
        
        if($lvUser->mobile_on == 1)
        {
            $cookieLog .= 'mobile ON - ';
            if($isStandalone==0){
                $cookieLog .= 'not standalone - ';
                //echo ' -- ios=0';
                // user pierwszy raz wchodzi do mobile || usunal ciastko w telefonie   
                if((empty($lvUser->guide_mobile_token)))//|| (!empty($lvUser->mobile_token) && empty(Yii::app()->request->cookies[mtp_mobile_token])) )
                {
                    $cookieLog .= 'GUIDE token EMPTY - ';
                    //echo ' -- new token';
                    // zapisz nowy token do bazy 
                    $lvUser->guide_mobile_token = Mobile::generateToken($lvUser->id);
                    if($lvUser->update(array('guide_mobile_token')))
                    {
                        $cookieLog .= 'SAVING to DB: '.$lvUser->guide_mobile_token.' - ';
                        //echo ' -- saved token in db';
                        // zapisz token w ciastku
                        $cookie = new CHttpCookie($cookieName, $lvUser->guide_mobile_token);
                        $cookie->expire = time()+60*60*24*380; // rok w sekundach
                        Yii::app()->request->cookies[$cookieName] = $cookie;
                        file_put_contents('protected/runtime/cookieTracking.log', $cookieLog."\r\n", FILE_APPEND);
                        return true;
                    }else {
                        $cookieLog .= 'Couldnt save token '.$lvUser->guide_mobile_token.' - ';
                        //echo ' -- error'; exit;
                    }
                }

                // sprawdz czy token w ciastku uzytkownika jest = z ciastkiem w bazie
                if(!empty(Yii::app()->request->cookies[$cookieName]))
                {
                    //echo ' -- not empty cookie ';
                    $lvCookieToken = Yii::app()->request->cookies[$cookieName]->value;
                    $cookieLog .= 'Cookie NOT EMPTY '.$lvCookieToken.' - ';
                    //var_dump($lvCookieToken);
                    if($lvCookieToken == $lvUser->guide_mobile_token)
                    {
                        $cookieLog .= 'cookie MATCH '.$lvCookieToken.' - ';
                        //echo ' -- cookie same as db ';
                        $cookie = Yii::app()->request->cookies[$cookieName];
                        $cookie->expire = time()+60*60*24*380; // rok w sekundach
                        Yii::app()->request->cookies[$cookieName] = $cookie;
                        
                        file_put_contents('protected/runtime/cookieTracking.log', $cookieLog."\r\n", FILE_APPEND);
                        return true;
                    }
                }
                else
                {
                    $cookieLog .= 'cookie EMPTY or EXPIRED - ';
                    // file_put_contents('protected/runtime/cookieTracking.log', $cookieLog."\r\n", FILE_APPEND);
                    // ciastko sie przeterminowalo
                }
            }else {// standalone app on ios
                $cookieLog .= 'is standalone - ';
                if((empty($lvUser->guide_mobile_token_ios)))//|| (!empty($lvUser->mobile_token) && empty(Yii::app()->request->cookies[mtp_mobile_token])) )
                {
                    $cookieLog .= 'no DB token - ';
                    //echo ' -- no ios token in db ';
                    // zapisz nowy token do bazy 
                    $lvUser->guide_mobile_token_ios = Mobile::generateToken($lvUser->id);
                    if($lvUser->update(array('guide_mobile_token_ios')))
                    {
                        $cookieLog .= 'saving token to DB '.$lvUser->guide_mobile_token_ios.' - ';
                        //echo ' -- updating ios DB token';
                        // zapisz token w ciastku
                        $cookie = new CHttpCookie($cookieName, $lvUser->guide_mobile_token_ios);
                        $cookie->expire = time()+60*60*24*380; // rok w sekundach
                        Yii::app()->request->cookies[$cookieName] = $cookie;
                        file_put_contents('protected/runtime/cookieTracking.log', $cookieLog."\r\n", FILE_APPEND);
                        return true;
                    }else {
                        $cookieLog .= 'couldnt save cooks2 '.$lvUser->guide_mobile_token_ios.' - ';
                    }
                }
            
                // sprawdz czy token w ciastku uzytkownika jest = z ciastkiem w bazie
                if(!empty(Yii::app()->request->cookies[$cookieName]))
                {
                    $cookieLog .= 'saving token to DB '.$lvUser->guide_mobile_token_ios.' - ';
                    //echo ' -- iso cookie ise set';
                    $lvCookieToken = Yii::app()->request->cookies[$cookieName]->value;
                    //var_dump($lvCookieToken);
                    if($lvCookieToken == $lvUser->guide_mobile_token_ios)
                    {
                        $cookieLog .= 'tokens MATCH '.$lvUser->guide_mobile_token_ios.' - ';
                        //echo ' -- iso cookie == db';
                        $cookie = Yii::app()->request->cookies[$cookieName];
                        $cookie->expire = time()+60*60*24*380; // rok w sekundach
                        Yii::app()->request->cookies[$cookieName] = $cookie;
                        file_put_contents('protected/runtime/cookieTracking.log', $cookieLog."\r\n", FILE_APPEND);
                        return true;
                    }
                }
            }
        }
        $cookieLog .= 'action ends - ';
        file_put_contents('protected/runtime/cookieTracking.log', $cookieLog."\r\n", FILE_APPEND);
        //echo ' -- no mobile?';
        return false;
    }

    /**
     * Metoda zwraca nazwe ciastka.
     * Nazwa jest zalezna od wersji aplikacji: Produkcja/Test
     * @return cookieName
     */
    public static function getCookieName()
    {
        if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){
            return (Yii::app()->params['is_test_version']) ? 'guide_test_version_mobile_token_2' : 'guide_mobile_token_2';
        }else{
            return 'guide_test_version_mobile_token_2';
        }
    }

    /**
     * Metoda zwraca strony dla podanego jako parametr parentId lub 
     * dla menu glownego (MOBILE_VERSION_PARENT_ID)
     * @return model
     */
    public static function getMobileSites($pmParentId=null)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('`parent_id`', ($pmParentId==null) ? self::$MOBILE_VERSION_PARENT_ID : $pmParentId);
        $criteria->compare('`display`',1);
        $criteria->order = '`order`';
        return CmsPage::model()->findAll($criteria);
    }

    /**
     * Metoda zwraca wszystkie newsy
     * @return model
     */    
    public static function getAllNews()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('`display`',1);
        $criteria->order = '`order`';
        return CmsNews::model()->findAll($criteria);
    }
    
    /**
     * Metoda pobiera po url tresc strony
     * @param type $pmSiteUrl
     * @return model
     */
    public static function getSiteContent($pmSiteUrl)
    {
        if(empty($pmSiteUrl))
        {
            return null;
        }else{
            $criteria = new CDbCriteria;
            $criteria->compare('`url`',$pmSiteUrl);
            $criteria->compare('`display`',1);
            $criteria->order = '`order`';
            return CmsPage::model()->find($criteria);
        }
    }

    public static function isNumber($value){        
        if(strpos($value, '€')===false){            
            return false;
        }else {            
            return true;
        }
    }
    
    public static function displayValue($value)
    {
        $out = str_replace('€', '', $value);
        $out = number_format ( $out , 0 , "." , "," );
        return $out;
    }
    
    public static function displayKms($kms){
        $out = RegistrationService::multiplyUserKm($kms);
        $out = number_format ( $out , 0 , "." , "," );
        return $out;
    }
    
    public static function displayFullYearForRegYear($regYear){
        $decade = substr($regYear, 0, 2);
        $year = '20'.$decade;
        return $year;
        
    }
    
    /**
     * USED CARS
     * Metoda zwraca liste marek z ostatniego importu
     * @return model
     */
    public static function getUsedCarsMark()
    {
        return Yii::app()->db->createCommand("
                 SELECT `uc`.`id`, `uc`.`id_import`, `uc`.`name`, `imp`.`nazwa`, `imp`.`data` 
                 FROM `used_cars` `uc`
                 INNER JOIN `import` `imp` ON `imp`.`id` = `uc`.`id_import`
                 WHERE `imp`.`id` = ( SELECT MAX(`id_import`) FROM `used_cars` )
                 ORDER BY `uc`.`name`
                ")->queryAll();
    }

    public static function filterForChosenYear($cars, $regYear)
    {
        $out = array();
        foreach($cars as $vehicle){
            $yearsArr = explode('/', $vehicle->years);

            if(is_array($yearsArr)){
                if($yearsArr[1]=='-'){
                    $yearsArr[1]=10000;
                }
                
                if($regYear<=$yearsArr[1] && $regYear>=$yearsArr[0]){
                    $out[]=$vehicle;
                }
            }
        }

        return $out;
    }

    /**
     * USED CARS
     * Metoda zwraca liste modeli dla danej marki
     * @return model
     */
    public static function getModelsForTheBandForCars($pmMakeId)
    {
        return UsedCarsModel::model()->findAll(array(
            'condition'=>'id_used_cars=:id',
            'params'=>array(':id'=>$pmMakeId)
        ));
    }
    
    public static function getModelsByRangeForTheBandForCars($pmMakeId, $rangeCode)
    {
        return UsedCarsModel::model()->findAll(array(
            'condition'=>'id_used_cars=:id AND rangecode=:rangecode',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode)
        ));
    }
    
    public static function getFuelForCars($pmMakeId, $rangeCode, $model_txt)
    {
        $cars = UsedCarsModel::model()->findAll(array(
            'condition'=>'id_used_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt)
        ));
        $fuelTypes = array();
        foreach($cars as $car){
            $fuelTypes[$car['fuel']]=self::getFuelText($car['fuel']);
        }
        return array_unique($fuelTypes);
    }
    
    public static function getFuelForComms($pmMakeId, $rangeCode, $model_txt)
    {
        $cars = UsedComCarsModel::model()->findAll(array(
            'condition'=>'id_used_com_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt)
        ));
        $fuelTypes = array();
        foreach($cars as $car){
            $fuelTypes[$car['fuel']]=self::getFuelText($car['fuel']);
        }
        return array_unique($fuelTypes);
    }
    
    public static function getTransmissionForCars($pmMakeId, $rangeCode, $model_txt, $fuel)
    {
        $cars = UsedCarsModel::model()->findAll(array(
            'condition'=>'id_used_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt AND fuel=:fuel',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt, 'fuel'=>$fuel)
        ));
        $transmissionTypes = array();
        foreach($cars as $car){
            $transmissionTypes[$car['transmission']]=$car['transmission'];//self::getTransmissionText($car['transmission']);
        }
        return array_unique($transmissionTypes);
    }
    public static function getTransmissionForComms($pmMakeId, $rangeCode, $model_txt, $fuel)
    {
        $cars = UsedComCarsModel::model()->findAll(array(
            'condition'=>'id_used_com_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt AND fuel=:fuel',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt, 'fuel'=>$fuel)
        ));
        $transmissionTypes = array();
        foreach($cars as $car){
            $transmissionTypes[$car['transmission']]=$car['transmission'];//self::getTransmissionText($car['transmission']);
        }
        return array_unique($transmissionTypes);
    }
    
    public static function getBodyForComms($pmMakeId, $rangeCode, $model_txt, $fuel, $transmission)
    {
        $cars = UsedComCarsModel::model()->findAll(array(
            'condition'=>'id_used_com_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt AND fuel=:fuel AND transmission=:trans',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt, 'fuel'=>$fuel, 'trans'=>$transmission)
        ));
        $types = array();
        foreach($cars as $car){
            $types[$car['bod']]=$car['bod'];//self::getTransmissionText($car['transmission']);
        }
        return array_unique($types);
    }
    public static function getBodyForCars($pmMakeId, $rangeCode, $model_txt, $fuel, $transmission)
    {
        $cars = UsedCarsModel::model()->findAll(array(
            'condition'=>'id_used_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt AND fuel=:fuel AND transmission=:trans',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt, 'fuel'=>$fuel, 'trans'=>$transmission)
        ));
        $types = array();
        foreach($cars as $car){
            $types[$car['bod']]=$car['bod'];//self::getTransmissionText($car['transmission']);
        }
        return array_unique($types);
    }
    public static function getDoorsForCars($pmMakeId, $rangeCode, $model_txt, $fuel, $transmission, $body)
    {
        $cars = UsedCarsModel::model()->findAll(array(
            'condition'=>'id_used_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt AND fuel=:fuel AND transmission=:trans AND bod=:body',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt, 'fuel'=>$fuel, 'trans'=>$transmission, 'body'=>$body)
        ));
        $types = array();
        foreach($cars as $car){
            $types[$car['drs']]=$car['drs'];//self::getTransmissionText($car['transmission']);
        }
        return array_unique($types);
    }
    
    public static function getDoorsForComms($pmMakeId, $rangeCode, $model_txt, $fuel, $transmission, $body)
    {
        $cars = UsedComCarsModel::model()->findAll(array(
            'condition'=>'id_used_com_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt AND fuel=:fuel AND transmission=:trans AND bod=:body',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt, 'fuel'=>$fuel, 'trans'=>$transmission, 'body'=>$body)
        ));

        $types = array();
        foreach($cars as $car){
            $types[$car['drs']]=$car['drs'];
        }
        return array_unique($types);
    }
    
    public static function getBadgeTypeForCars($pmMakeId, $rangeCode, $model_txt, $fuel, $transmission, $body, $doors)
    {
        $cars = UsedCarsModel::model()->findAll(array(
            'condition'=>'id_used_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt AND fuel=:fuel AND transmission=:trans AND bod=:body AND drs=:doors',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt, 'fuel'=>$fuel, 'trans'=>$transmission, 'body'=>$body, 'doors'=>$doors)
        ));
        $types = array();
        foreach($cars as $car){
            $types[$car['badgetype']]=$car['badgetype'];//self::getTransmissionText($car['transmission']);
        }
        return array_unique($types);
    }
    
    public static function getFinalDetailsCars($pmMakeId, $rangeCode, $model_txt, $fuel, $transmission, $body, $doors, $badge)
    {
        $cars = UsedCarsModel::model()->findAll(array(
            'condition'=>'id_used_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt AND fuel=:fuel AND transmission=:trans AND bod=:body AND drs=:doors AND badgetype=:badge',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt, 'fuel'=>$fuel, 'trans'=>$transmission, 'body'=>$body, 'doors'=>$doors, 'badge'=>$badge)
        ));
        return $cars;
    }
    
    public static function getFinalDetailsComms($pmMakeId, $rangeCode, $model_txt, $fuel, $transmission, $body, $doors, $badge)
    {
        $cars = UsedComCarsModel::model()->findAll(array(
            'condition'=>'id_used_com_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt AND fuel=:fuel AND transmission=:trans AND bod=:body AND drs=:doors AND badgetype=:badge',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt, 'fuel'=>$fuel, 'trans'=>$transmission, 'body'=>$body, 'doors'=>$doors, 'badge'=>$badge)
        ));
        return $cars;
    }
    
    public static function getBadgeTypeForComms($pmMakeId, $rangeCode, $model_txt, $fuel, $transmission, $body, $doors)
    {
        $cars = UsedComCarsModel::model()->findAll(array(
            'condition'=>'id_used_com_cars=:id AND rangecode=:rangecode AND vehicle=:model_txt AND fuel=:fuel AND transmission=:trans AND bod=:body AND drs=:doors',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt, 'fuel'=>$fuel, 'trans'=>$transmission, 'body'=>$body, 'doors'=>$doors)
        ));
        $types = array();
        foreach($cars as $car){
            $types[$car['badgetype']]=$car['badgetype'];//self::getTransmissionText($car['transmission']);
        }
        return array_unique($types);
    }

    public static function getFuelText($fuelLetter){
        $texts = array('P'=>'Petrol', 'D'=>'Diesel', 'E'=>'Electric');
        return $texts[$fuelLetter];
    }
    
    public static function getModelsByRangeForTheBandForComms($pmMakeId, $rangeCode)
    {
        return UsedComCarsModel::model()->findAll(array(
            'condition'=>'id_used_com_cars=:id AND rangecode=:rangecode',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode)
        ));
    }
    
    public static function getRangesForTheBandForCars($pmMakeId)
    {
        $importId = UsedCarsModel::findByPk($pmMakeId);
        $startRangeCode = null;
        $rangeName = '';

        if (isset($_GET['rangecode'])) {
            $startRangeCode = $_GET['rangecode'];
        }
        
        return UsedCarsModel::model()->findAll(array(
            'condition'=>'id_used_cars=:id',
            'params'=>array(':id'=>$pmMakeId)
        ));
    }

    /**
     * USED CARS
     * Metoda zwraca dane dla danego modelu
     * @return model
     */    
    public static function getDetailsDataForUsedCars($pmId)
    {
        return UsedCarsModel::model()->find(array(
            'condition'=>'id=:id',
            'params'=>array(':id'=>$pmId)
        ));        
    }    

    /**
     * USED COMMERCIAL
     * Metoda zwraca liste marek z ostatniego importu
     * @return model
     */    
    public static function getUsedCommercialMark()
    {
        return Yii::app()->db->createCommand("
                 SELECT `ucc`.`id`,`ucc`.`id_import`,`ucc`.`name`, `imp`.`nazwa`, `imp`.`data`
                 FROM `used_com_cars` `ucc`
                 INNER JOIN `import` `imp` ON `imp`.`id` = `ucc`.`id_import`
                 WHERE `imp`.`id` = ( SELECT MAX(`id_import`) FROM `used_com_cars` )
                 ORDER BY `ucc`.`name`
                ")->queryAll(); 
    }

    /**
     * USED COMMERCIAL
     * Metoda zwraca liste modeli dla danej marki
     * @return model
     */
    public static function getModelsForTheBandForCommercial($pmMakeId)
    {
        return UsedComCarsModel::model()->findAll(array(
            'condition'=>'id_used_com_cars=:id',
            'params'=>array(':id'=>$pmMakeId)
        ));
    }    
    
    /**
     * USED CARS
     * Metoda zwraca dane dla danego modelu
     * @return model
     */     
    public static function getDetailsDataForUsedCommercial($pmId)
    {
        return UsedComCarsModel::model()->find(array(
            'condition'=>'id=:id',
            'params'=>array(':id'=>$pmId)
        ));        
    }
    

    /**
     * Metoda generuje i zwraca token zlozony z losowych znakow
     * @param type $pmUserId
     * @return String
     */
    public static function generateToken($pmUserId=""){

        $lvToken = $pmUserId;
        for ($i=0; $i<10; $i++) 
        {
            $losuj=rand(1,30)%2; //T/F
            if($losuj)
            {
                //if(true) ? A-Z : a-z;
                $lvToken .= (rand(1,30)%2) ? chr(rand(65,90)) : chr(rand(97,122));
            }
            else
            {
                $lvToken .= chr(rand(48,57)); //0-9
            }
        }
        return $lvToken;
    }     
    
    /**
     * Metoda zwraca dane z pliku man.xml dla Cars
     * @return array(model=>pathToFile)
     */
    public static function getNewPricesCarsManData()
    {
        $man_file = file_get_contents('./data/cars/man.xml');
        $man_file = htmlspecialchars($man_file);
        $cars = simplexml_load_string(html_entity_decode($man_file), 'SimpleXMLElement', LIBXML_NOCDATA);        

        $xmlManFileData = array();
        foreach ($cars as $row)
        {    
            $xmlManFileData += array($row['distributor'].' ('.$row['effective'].')'=>urldecode($row['file']));//'./data/cars/'.
        }
        return $xmlManFileData;
    }
    
    public static function getCleanManufacturer($distributorWithDate)
    {
        $out = null;
        $manArr = explode('(', $distributorWithDate);
        if(is_array($manArr)){
            $out = trim($manArr[0]);
        }else {
            $out = trim($distributorWithDate);
        }
        return $out;
    }
    
    /**
     * Metoda zwraca tablice z danymi dla CARS uzywana w widoku
     * @param type $carXml
     * @return type
     */
    public static function getCarData($carXml)
    {
        $xmlCarData = array();
        $output = array();
        $reader = new XMLReader();
        $file = './data/cars/'.$carXml;
        if(file_exists($file))
        {
            if (!$reader->open($file))
            {
                die("Failed to open ".$carXml);
            }
            while($reader->read())
            {
                if($reader->getAttribute('model') == null) 
                    continue;

                $xmlCarData = array(
                    'manufacturer'=>$reader->getAttribute('manufacturer'),
                    'model'=>$reader->getAttribute('model'),
                    'doors'=>$reader->getAttribute('doors'),
                    'body'=>$reader->getAttribute('body'),
                    'retail'=>$reader->getAttribute('retail'),
                    'engine'=>$reader->getAttribute('engine'),
                    'bhp'=>$reader->getAttribute('bhp'),
                    'vrt'=>$reader->getAttribute('vrt'),
                    'band'=>$reader->getAttribute('band'),
                    'co2'=>$reader->getAttribute('co2'),
                    'fuel'=>$reader->getAttribute('fuel'),
                    'tax'=>$reader->getAttribute('tax'),
                    'rangecode'=>$reader->getAttribute('rangecode')
                );
                $output[] = $xmlCarData;
            }
            $reader->close();
        }
        return $output;
    }

    /**
     * Metoda zwraca dane z pliku man.xml dla Commercial
     * @return array(model=>pathToFile)
     */
    public static function getNewPricesCommManData()
    {
        $man_file = file_get_contents('./data/commercial/man.xml');
        $man_file = htmlspecialchars($man_file);
        $cars = simplexml_load_string(html_entity_decode($man_file), 'SimpleXMLElement', LIBXML_NOCDATA);        

        $xmlManFileData = array();
        foreach ($cars as $row)
        {
            $xmlManFileData += array($row['distributor'].' ('.$row['effective'].')'=>urldecode($row['file']));//'./data/cars/'.
        }
        return $xmlManFileData;
    }

    /**
     * Metoda zwraca tablice z danymi dla COMMERCIAL uzywana w widoku
     * @param type $carXml
     * @return type
     */
    public static function getCommData($carXml)
    {
        $xmlCarData = array();
        $output = array();
        $reader = new XMLReader();
        $file = './data/commercial/'.$carXml;
        if(file_exists($file))
        {
            if (!$reader->open($file))
            {
                die("Failed to open ".$carXml);
            }
            while($reader->read())
            {
                if($reader->getAttribute('model') == null) 
                    continue;

                $xmlCarData = array(
                    'manufacturer'=>$reader->getAttribute('manufacturer'),
                    'model'=>$reader->getAttribute('model'),
                    'body'=>$reader->getAttribute('body'),
                    'retail'=>$reader->getAttribute('retail'),
                    'gvw'=>$reader->getAttribute('gvw'),
                    'cc'=>$reader->getAttribute('cc'),
                    'cat'=>$reader->getAttribute('cat'),
                    'vrt'=>$reader->getAttribute('vrt'),
                    'band'=>$reader->getAttribute('band'),
                    'co2'=>$reader->getAttribute('co2'),
                    'fuel'=>$reader->getAttribute('fuel'),
                    'tax'=>$reader->getAttribute('tax'),
                    'rangecode'=>$reader->getAttribute('rangecode')
                    
                );
                $output[] = $xmlCarData;
            }
            $reader->close();
        }
        return $output;
    }


    /*Fresh methods for Search by Make n Model page*/
    public static function getFuelOptions($pageModel ="UsedCarsModel", $pmMakeId, $rangeCode)
    {
        $id_used = ($pageModel == "UsedCarsModel" ) ? 'id_used_cars' :'id_used_com_cars';

        $cars = $pageModel::model()->findAll(array(
            'condition'=> $id_used.'=:id AND rangecode=:rangecode',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode)
        ));

        $fuelTypes = array();
        foreach($cars as $car){
            $fuelTypes[$car['fuel']]=self::getFuelText($car['fuel']);
        }

        return array_unique($fuelTypes);
    }

    public static function getTransmissionOptions($pageModel ="UsedCarsModel", $pmMakeId, $rangeCode, $fuel, $year = null)
    {
        $id_used = ($pageModel == "UsedCarsModel" ) ? 'id_used_cars' :'id_used_com_cars';

        $cars = $pageModel::model()->findAll(array(
            'condition'=>$id_used.'=:id AND rangecode=:rangecode AND fuel=:fuel',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode,'fuel'=>$fuel)
        ));

        $cars   =   Mobile::filterForChosenYear($cars, $year);

        $transmissionTypes = array();
        foreach($cars as $car){
            $transmissionTypes[$car['transmission']]=$car['transmission'];
        }
        return array_unique($transmissionTypes);
    }

    public static function getModelsByRangeForTheBand($pageModel ="UsedCarsModel", $pmMakeId, $rangeCode, $fuel, $transmission, $doors, $bodytype)
    {
        $id_used = ($pageModel == "UsedCarsModel" ) ? 'id_used_cars' :'id_used_com_cars';

        $condition  =   $id_used.'=:id AND rangecode=:rangecode AND fuel=:fuel AND transmission=:trans AND bod=:bodytype ';

        $parameters = array(':id'=>$pmMakeId, 
                            'rangecode'=>$rangeCode,
                            'fuel'  =>  $fuel,
                            'trans' =>  $transmission,
                            'bodytype' => $bodytype
                        );

        $condition  =   $condition. ' AND drs=:doors';
        $parameters['doors']  =   $doors;

        return $pageModel::model()->findAll(array(
            'condition'=> $condition,
            'params'=>$parameters
        ));
    }

    public static function getBodyDoors($pageModel, $pmMakeId, $rangeCode, $model_txt, $fuel, $transmission, $badgetype)
    {
        $id_used = ($pageModel == "UsedCarsModel" ) ? 'id_used_cars' :'id_used_com_cars';

        $cars = $pageModel::model()->findAll(array(
            'condition'=> $id_used.'=:id AND rangecode=:rangecode AND vehicle=:model_txt AND fuel=:fuel AND transmission=:trans AND badgetype=:badgetype',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'model_txt'=>$model_txt, 'fuel'=>$fuel, 'trans'=>$transmission, 'badgetype' => $badgetype)
        ));
        $types = array();
        
        foreach($cars as $car){
            $types[$car['drs']]=$car['bod'];//self::getTransmissionText($car['transmission']);
        }

        return array_unique($types);
    }

    public static function getBodyDoorsWithoutModel($pageModel, $pmMakeId, $rangeCode, $fuel, $transmission, $year = null)
    {
        $id_used = ($pageModel == "UsedCarsModel" ) ? 'id_used_cars' :'id_used_com_cars'; 

        $cars = $pageModel::model()->findAll(array(
            'condition'=> $id_used.'=:id AND rangecode=:rangecode AND fuel=:fuel AND transmission=:trans',
            'params'=>array(':id'=>$pmMakeId, 'rangecode'=>$rangeCode, 'fuel'=>$fuel, 'trans'=>$transmission)
        ));
        $types = array();
        
        $cars   =   Mobile::filterForChosenYear($cars, $year);

        foreach($cars as $car){
            $types[][$car['drs']]=$car['bod'];
        }

        if($pageModel == "UsedCarsModel"){
            $types = array_values(array_map("unserialize", array_unique(array_map("serialize", $types))));
        }else{
            $types = array_unique($types);
        }

        return $types;
    }

}
?>
