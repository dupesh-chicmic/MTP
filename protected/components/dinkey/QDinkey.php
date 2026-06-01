<?php

/**
 * Description of QDinkey
 * klasa do obsługi sprawdzania obecności zabezpieczenia USB Dinkey
 * @author Mike
 */
class QDinkey {
    public static function checkDinkeyAccess(){
        $dinkey = Uzytkownik::model()->dinkeyRequired();
        if (!empty($dinkey)){
            require "dinkeywebinc.php"; 
            $dwParams = new DinkeyWebParams();
            DDProtCheck($dwParams);   // DDProtCheck() must be called before any output has been generated
            return $dwParams->M_ReturnCode;
        }else {
            return true;
        }
    }
    
}

?>
