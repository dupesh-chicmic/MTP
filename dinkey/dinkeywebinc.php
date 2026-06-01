<?php

/*****************************************************************/
/*********               dinkeywebinc.php                *********/
/*****************************************************************/
/*********          DO NOT modify this file!!!           *********/
/*********          DO NOT modify this file!!!           *********/
/*********          DO NOT modify this file!!!           *********/
/*****************************************************************/
/*********                   NOTICE                      *********/
/*********      No support will be given regarding       *********/
/*********      problems you encounter as a result       *********/
/*********           of modifying this code.             *********/
/*****************************************************************/
/****    Custom settings should go in dinkeywebdefaults.php   ****/
/****           and/or your protected web page(s).            ****/
/*****************************************************************/
/****                Copyright Microcosm Ltd.                 ****/
/*****************************************************************/

require "dinkeywebdefaults.php";

// Settings relating to the microcosm servers
define("PRIMARY_SERVER",    "primary.dinkeyweb.com");       // Primary Microcosm server
define("SECONDARY_SERVER",  "secondary.dinkeyweb.com");     // Secondary Microcosm server
define("SERVER_DIR",        "/DinkeyWeb_v2");
define("SERVER_CGI_BIN",    "/cgi-bin");                    // Location of Encryption & Decryption programs (must have a leading forward slash)
define("SERVER_SSL_PORT",   "442");                         // primary.dinkeyweb.com and secondary.dinkeyweb.com serve HTTPS on port 442 (NOT 443)

// Library names - these are the basic name of the library file without any extension or prefix
define("DP_DLL", "dpWeb");
define("DD_DLL", "DDInet");

// Used when redirecting to their error page
define("DW_ERR_PREFIX",         "DWErr_");
define("DWERRID_GETVAR_NAME",   "__dwerrid");

// Returned by getvar() when it's unable to find the given variable name
define("INVALID_VAR_VALUE", "*!*");

// Version numbers
define("DDINET_VERSION",            0);
define("DPWEB_VERSION",             1);
define("DPWEB_ENCRYPTION_VERSION",  0);

// ERROR NUMBERS
define("DW_MISSING_RETSTRINGLEN_VAR",           1600);
define("DW_MISSING_INSTRING_VAR",               1601);
define("DW_MISSING_DINKEY_RETCODE_VAR",         1602);
define("DW_SDSN_MISMATCH",                      1603);
define("DW_COULDNT_CONNECT",                    1604);
define("DW_RESPONSE_TIMEOUT",                   1605);
define("DW_NO_DATA",                            1606);
define("DW_MISSING_ERROR_VAR",                  1607);
define("DW_HTTP_REQUEST_FAILED",                1608);
define("DW_HTTP_RESPONSE_PROBLEM",              1609);
define("DW_SECURITY_VIOLATION",                 1610);
define("DW_UNSATISFIED_LINK_ERROR",             1611);
define("DW_COULDNT_DOWNLOAD_LIBRARY",           1612);
define("DW_COULDNT_INSTALL_LIBRARY",            1613);
define("DW_OS_UNSUPPORTED",                     1614);
define("DW_64BIT_UNSUPPORTED",                  1615);
define("DW_UNKNOWN_ERROR",                      1616);
define("DW_BAD_RESPONSE_TO_HTTP_REQUEST",       1617);
define("DW_HTTP_RESPONSE_WAS_NOT_200OK",        1618);
define("DW_AUTH_FAILURE",                       1619);
define("DW_REQUEST_TIMEOUT",                    1620);
define("DW_FAILED_TO_SEND_APPLET_PAGE",         1621);
define("DW_SHELLEXEC_PROG_RETURNED_NON_ZERO",   1622);
define("DW_SHELLEXEC_PROG_NOT_ALLOWED",         1623);
define("DW_SHELLEXEC_PROG_FAILED",              1624);
define("DW_RETSTRING_EMPTY",                    1625);

session_cache_limiter('nocache');
//session_start();

// If Java caused this page load then the following POST variables are defined:
//  * _DW_JavaCalled = 1
//  * _DW_JavaRetString
//  * _DW_JavaExtError
//  * _DW_JavaRetCode
//  * _DW_JavaLastDongleTypeFound
//  * _DW_OriginalRequestMethod

// GLOBAL VARIABLES
$g_exterr = "";

function __DpAltProgNameCompat(&$dwParams)
{
    $arr = get_object_vars($dwParams);
    if (!array_key_exists("DP_alt_prog_name", $arr))
        $arr["DP_alt_prog_name"] = $dwParams->DP_alt_licence_name;
    $dwParams = (object) $arr;
}

function httpRequest($host, $path, $secure, $method, $data, &$returnData)
{
    $errno = 0;
    $errstr = "";
    $timeout = 5;   // 5 second timeout
    
    if ($secure)
        $sock = @fsockopen("ssl://".$host, 443, $errno, $errstr, $timeout);
    else
        $sock = @fsockopen($host, 80, $errno, $errstr, $timeout);
    
    if (!$sock)    
        return DW_COULDNT_CONNECT;     // error connecting

    stream_set_timeout($sock, $timeout);
        
    // MAKE THE REQUEST
        
    fputs($sock, $method." ".$path." HTTP/1.1\r\n");
    fputs($sock, "Host: ".$host."\r\n");
    fputs($sock, "User-Agent: DinkeyWeb\r\n");
    fputs($sock, "Connection: close\r\n");
    if ($method == "POST")
    {
        fputs($sock, "Content-type: application/x-www-form-urlencoded\r\n");    
        fputs($sock, "Content-length: ".strlen($data)."\r\n");
    }
    fputs($sock, "\r\n");   // end of request headers
    if ($method == "POST")
        fputs($sock, $data);        
    
    // GET THE RESPONSE
    
    // Headers first
    $headers = array();
    while (($str = trim(fgets($sock, 4096))) != "")
    {
        $headers[] = $str;
    }
    
    // Did we timeout trying to read the headers ?
    $info = stream_get_meta_data($sock);
    if ($info['timed_out'])
    {
        fclose($sock);
        return DW_RESPONSE_TIMEOUT;
    }
    
    // Check the headers to make sure we got a HTTP 200 response (eg, "HTTP/1.1 200 OK")
    $parts = explode(" ", $headers[0]);
    $errno = 0;
    if (strpos($parts[0], "HTTP") !== 0)
        $errno = DW_BAD_RESPONSE_TO_HTTP_REQUEST;
    else if (($parts[1] != "200"))
        $errno = DW_HTTP_RESPONSE_WAS_NOT_200OK;

    if ($errno != 0)
    {
        fclose($sock);
        return $errno;
    }

    // Now get the response data
    $returnData = "";
    while (!feof($sock))
    {
        $s = @fread($sock, 4096);   // Suppress errors/warnings from fread() (eg, the "SSL: fatal protocol error" PHP bug)
        $returnData .= $s;
    }
    
    // Check for stream time-out
    $info = stream_get_meta_data($sock);

    fclose($sock);
    
    if ($info['timed_out'])
        return DW_RESPONSE_TIMEOUT;
        
    return 0;
}

function httpRequest2($url, $method, $data, &$returnData)
{    
    $proto = substr($url, 0, strpos($url, "://"));
    $secure = FALSE;
    if (strtolower($proto) == "https")
        $secure = TRUE;
    
    $proto .= "://";        
    $s = substr($url, strlen($proto));                                  // eg, "www.example.com/myfile.abc"
    $host = substr($s, 0, strpos($s, "/"));                             // eg, "www.example.com"
    $path = substr($s, strpos($s, "/"), strlen($s)-strpos($s, "/"));    // eg, "/myfile.abc"    

    return httpRequest($host, $path, $secure, $method, $data, $returnData);
}

function httpPost(&$dwParams, $path, $data, &$returnDataBYREF)
{
    $server = $_SESSION['DinkeyWeb']['CurrentServer'];

    $returnData = "";
    
    $ret = httpRequest($server, $path, FALSE, "POST", $data, $returnData);
    
    if ($ret != 0) 
    {
        // Call to current server failed, let's try the other one
        if ($server == PRIMARY_SERVER) 
            $server = SECONDARY_SERVER;
        else 
            $server = PRIMARY_SERVER;
       
        $ret = httpRequest($server, $path, FALSE, "POST", $data, $returnData);
        
        if ($ret != 0)                    
            return $ret;
    }
        
    if (strlen($returnData) == 0)
        return DW_NO_DATA;    // No data
        
    if (getvar($returnData, "Error") == INVALID_VAR_VALUE)
        return DW_MISSING_ERROR_VAR;    // Couldn't find "Error"    

    $_SESSION['DinkeyWeb']['CurrentServer'] = $server;         
        
    $returnDataBYREF = $returnData;
        
    return 0;
}
 
function getvar($in, $varNameToGet) 
{
    $a1 = explode("<!--", $in);

    foreach ($a1 as $s)
    {
        $n = strpos($s, "-->");
        
        if ($n !== FALSE)
        {
            $str = substr($s, 0, $n);
            
            $nameAndValue = explode(":", $str, 2);

            if (count($nameAndValue) == 2)
            {
                if (trim($nameAndValue[0]) == $varNameToGet)
                    return trim($nameAndValue[1]);
            }
        }
    }

    return INVALID_VAR_VALUE;   
} 

function NewSessionID() 
{    
    $SessionID  = md5( mt_rand(0, mt_getrandmax()) );
    $SessionID .= md5( mt_rand(0, mt_getrandmax()) );
    $SessionID .= md5( mt_rand(0, mt_getrandmax()) );
    $SessionID .= md5( mt_rand(0, mt_getrandmax()) );
    
    return $SessionID;
}

// Create our own session and store initial data in it.
function CreateSession(&$dwParams)
{
    $sessionID = NewSessionID();
    
    $_SESSION["DinkeyWeb"][$sessionID]["TimeoutTime"]           = time() + $dwParams->M_Timeout;
    $_SESSION["DinkeyWeb"][$sessionID]["DD_Function"]           = $dwParams->DD_Function;
    $_SESSION["DinkeyWeb"][$sessionID]["M_DataOffset"]          = $dwParams->M_DataOffset;
    $_SESSION["DinkeyWeb"][$sessionID]["M_DataLength"]          = $dwParams->M_DataLength;
    $_SESSION["DinkeyWeb"][$sessionID]["DP_Function"]           = $dwParams->DP_Function;
    $_SESSION["DinkeyWeb"][$sessionID]["DP_Flags"]              = $dwParams->DP_Flags;
    $_SESSION["DinkeyWeb"][$sessionID]["DP_ExecsDecrement"]     = $dwParams->DP_ExecsDecrement;
    $_SESSION["DinkeyWeb"][$sessionID]["DP_alt_prog_name"]      = $dwParams->DP_alt_prog_name;
    $_SESSION["DinkeyWeb"][$sessionID]["IPAddress"]             = $_SERVER["REMOTE_ADDR"];    
    
    return $sessionID;
}

/*function StoreRetStringInOurSession(&$dwParams, $SessionID, $RetString)
{
    $now = time();    
    
    if ($now > $_SESSION["DinkeyWeb"][$SessionID]["TimeoutTime"])
        return FALSE;
    
    $_SESSION["DinkeyWeb"][$SessionID]["RetString"] = $RetString;
    
    return TRUE;
}*/

function CheckValidSession(&$dwParams, $SessionID, &$RetStringBYREF) 
{
    if (($dwParams->DP_Flags & DEC_ONE_EXEC) || ($dwParams->DP_Flags & DEC_MANY_EXECS)) 
        return FALSE;   // If either of the above two flags are set, we need to call a protection check regardless of the session's validity
        
    $now = time();

    // Has the session expired?
    if ($now > $_SESSION["DinkeyWeb"][$SessionID]["TimeoutTime"])
        return FALSE;        
    
    // If we're here in CheckValidSession() as a result of redirecting to a GET request following a successful 
    // protection check then we don't do the "if writing data, always return FALSE" bit because this would cause
    // it to loop forever.
    if (isset($_SESSION["DinkeyWeb"][$SessionID]["ProtCheckRedirectForGET"]))
    {
        unset($_SESSION["DinkeyWeb"][$SessionID]["ProtCheckRedirectForGET"]);
    }
    else
    {               
        if ($dwParams->DD_Function == 1)
            return FALSE;
            
        if ($dwParams->DP_Function == WRITE_DATA_AREA)
            return FALSE;    
    }       
        
    if ($dwParams->DD_Function != $_SESSION["DinkeyWeb"][$SessionID]["DD_Function"])
        return FALSE;
        
    if ($dwParams->M_DataOffset != $_SESSION["DinkeyWeb"][$SessionID]["M_DataOffset"])
        return FALSE;
        
    if ($dwParams->M_DataLength != $_SESSION["DinkeyWeb"][$SessionID]["M_DataLength"])
        return FALSE;
        
    if ($dwParams->DP_Function != $_SESSION["DinkeyWeb"][$SessionID]["DP_Function"])
        return FALSE;
        
    if ($dwParams->DP_Flags != $_SESSION["DinkeyWeb"][$SessionID]["DP_Flags"])
        return FALSE;
        
    if ($dwParams->DP_ExecsDecrement != $_SESSION["DinkeyWeb"][$SessionID]["DP_ExecsDecrement"])
        return FALSE;
        
    if ($dwParams->DP_alt_prog_name != $_SESSION["DinkeyWeb"][$SessionID]["DP_alt_prog_name"])
        return FALSE;
        
    if (empty($_SESSION["DinkeyWeb"][$SessionID]["RetString"]))
        return FALSE;
        
    if ($_SERVER['REMOTE_ADDR'] != $_SESSION["DinkeyWeb"][$SessionID]["IPAddress"])
        return FALSE;
        
    // Session is OK, give back the stored RetString 
        
    $RetStringBYREF = $_SESSION["DinkeyWeb"][$SessionID]["RetString"];
    
    return TRUE;
}

function DecryptReturn(&$dwParams, $SessionID, $RetString) 
{
    $lastDongleType = $_SESSION['DinkeyWeb']['LastDongleTypeFound'];   
    
    $returnData = "";
    
    if ($dwParams->M_DinkeyWebSelfHostingPackage == FALSE) 
    {
        $WebsitePage = SERVER_CGI_BIN;
        if ($lastDongleType == DONGLETYPE_DINKEY) 
            $WebsitePage .= "/ddinet_decrypt.exe";
        else
            $WebsitePage .= "/dpweb_decrypt.exe";    

        if ($lastDongleType == DONGLETYPE_DINKEY) 
        {
            $data  = "WebSDSN=" . $dwParams->M_SDSN;
            $data .= "&RetString=" . $RetString;
            $data .= "&SessionID=" . $SessionID;
            
            $ret = httpPost($dwParams, $WebsitePage, $data, $returnData);
            if ($ret != 0)
                return $ret;
        } 
        else
        {
            $data  = "WebSDSN=" . $dwParams->M_SDSN;
            $data .= "&RetString=" . $RetString;
            $data .= "&SessionID=" . $SessionID;
            $data .= "&RetStringLen=" . strlen($RetString);
            $data .= "&encryption_version=" . DPWEB_ENCRYPTION_VERSION;
            
            $ret = httpPost($dwParams, $WebsitePage, $data, $returnData);        
            if ($ret != 0)
                return $ret;
        }
    } 
    else 
    {
        if ($lastDongleType == DONGLETYPE_DINKEY)       
            $returnData = shell_exec($dwParams->M_EncDecPath."/ddinet_decrypt.exe $RetString $SessionID");
        else         
            $returnData = shell_exec($dwParams->M_EncDecPath."/dpweb_decrypt.exe $SessionID ".DPWEB_ENCRYPTION_VERSION." ".strlen($RetString)." $RetString");
    } 

    $Error = getvar($returnData, "Error");
    
    if ($Error == INVALID_VAR_VALUE) 
        return DW_MISSING_ERROR_VAR;
        
    $Error = intval($Error);
    if ($Error != 0)
        return $Error;
    
    if ($lastDongleType == DONGLETYPE_DINKEY) 
    {
        $ret = getvar($returnData, "retcode");
        
        if ($ret == INVALID_VAR_VALUE)
            return DW_MISSING_DINKEY_RETCODE_VAR;        
        
        $ret = intval($ret);
        if ($ret != 0)
            return $ret;
    }
    
    $dwParams->M_DongleInfo['dongle_no']     = getvar($returnData, "dongle_no");
    $dwParams->M_DongleInfo['sdsn']          = getvar($returnData, "sdsn");
    $dwParams->M_DongleInfo['prodcode']      = getvar($returnData, "prodcode");
    $dwParams->M_DongleInfo['execs']         = getvar($returnData, "execs");
    $dwParams->M_DongleInfo['exp_day']       = getvar($returnData, "exp_day");
    $dwParams->M_DongleInfo['exp_month']     = getvar($returnData, "exp_month");
    $dwParams->M_DongleInfo['exp_year']      = getvar($returnData, "exp_year");
    $dwParams->M_DongleInfo['features']      = getvar($returnData, "features");
    $dwParams->M_DongleInfo['update']        = getvar($returnData, "update");
    $dwParams->M_DongleInfo['model']         = getvar($returnData, "model");
    $dwParams->M_DongleInfo['maxnetusers']   = getvar($returnData, "maxnetusers");
    $dwParams->M_DongleInfo['usb']           = (($str = getvar($returnData, "usb")) == INVALID_VAR_VALUE) ? ("") : $str;
    $dwParams->M_DongleInfo['data']          = (($str = getvar($returnData, "data")) == INVALID_VAR_VALUE) ? ("") : $str;
    $dwParams->M_DongleInfo['type']          = (($str = getvar($returnData, "type")) == INVALID_VAR_VALUE) ? ("") : $str;
    $dwParams->M_DongleInfo['fd_capacity']   = (($str = getvar($returnData, "fd_capacity")) == INVALID_VAR_VALUE) ? ("") : $str;
    
    return 0;
}

function DDEncryptData(&$dwParams, $SessionID, &$EncryptedDDInStringBYREF)
{
    $returnData = "";
 
    if ($dwParams->M_DinkeyWebSelfHostingPackage == FALSE) 
    {
        $data  = 'SessionID='       . $SessionID;
        $data .= '&WebSDSN='        . $dwParams->M_SDSN;
        $data .= '&DataArea='       . $dwParams->M_DataArea;
        $data .= '&rw_length='      . $dwParams->M_DataLength;
        $data .= '&rw_offset='      . $dwParams->M_DataOffset;
        $data .= '&ddinet_version=' . DDINET_VERSION;
        
        $ret = httpPost($dwParams, SERVER_CGI_BIN . "/ddinet_encrypt.exe", $data, $returnData);
        
        if ($ret != 0)
            return $ret;
    }
    else
    {
        $dataArea = (strlen($dwParams->M_DataArea) == 0) ? "0" : $dwParams->M_DataArea;
        $str = $dwParams->M_EncDecPath . "/ddinet_encrypt.exe $SessionID " . $dwParams->M_DataLength . " " . $dwParams->M_DataOffset . " " . $dataArea . " 0";
        $returnData = shell_exec ($str);
    }
    
    $error = getvar($returnData, "Error");    
    
    if ($error == INVALID_VAR_VALUE)
        return DW_MISSING_ERROR_VAR;
    
    $error = intval($error);
    if ($error != 0)
        return $error;
    
    $str = getvar($returnData, "instring"); 
    if ($str == INVALID_VAR_VALUE) 
        return DW_MISSING_INSTRING_VAR;
    
    $EncryptedDDInStringBYREF = $str;
    
    return 0;    
}

function DPEncrypt(&$dwParams, $SessionID, &$EncryptedDPInStringBYREF, &$DPRetStringLenBYREF) 
{
    $ret = 0;
    $returnData = "";
 
    $dataCryptKeyNum = 1;
 
    if ($dwParams->M_DinkeyWebSelfHostingPackage == FALSE)
    {
        $data  = 'SessionID=' . $SessionID;
        $data .= '&WebSDSN=' . $dwParams->M_SDSN;
        $data .= '&DataArea=' . $dwParams->M_DataArea;
        $data .= '&rw_length=' . $dwParams->M_DataLength;
        $data .= '&rw_offset='. $dwParams->M_DataOffset;
        $data .= '&dpweb_version=' . DPWEB_VERSION;
        $data .= '&dpweb_function=' . $dwParams->DP_Function;
        $data .= '&dpweb_flags=' . $dwParams->DP_Flags;
        $data .= '&encryption_version=' . DPWEB_ENCRYPTION_VERSION;
        $data .= '&execs_decrement=' . $dwParams->DP_ExecsDecrement;
        $data .= '&data_crypt_key_num=' . $dataCryptKeyNum;
        $data .= '&alt_prog_name=' . $dwParams->DP_alt_prog_name;
        
        $ret = httpPost($dwParams, SERVER_CGI_BIN . "/dpweb_encrypt.exe", $data, $returnData);
        if ($ret != 0)
            return $ret;
    } 
    else 
    {
        $altProgName = (strlen($dwParams->DP_alt_prog_name) == 0) ? "0" : $dwParams->DP_alt_prog_name;
        $dataArea = (strlen($dwParams->M_DataArea) == 0) ? "0" : $dwParams->M_DataArea;        
        $str = $dwParams->M_EncDecPath . "/dpweb_encrypt.exe $SessionID ".$dwParams->M_DataLength." ".$dwParams->M_DataOffset." ".DPWEB_VERSION." ".$dwParams->DP_Function." ".$dwParams->DP_Flags." ".$dwParams->DP_ExecsDecrement." ".$dataCryptKeyNum." ".$altProgName." ".DPWEB_ENCRYPTION_VERSION." ".$dataArea;        
        $returnData = shell_exec($str);
    }

    $error = getvar($returnData, "Error");
    
    if ($error == INVALID_VAR_VALUE)
        return DW_MISSING_ERROR_VAR;
        
    $error = intval($error);
    if ($error != 0)
        return $error;
    
    $str = getvar($returnData, "instring"); 
    if ($str == INVALID_VAR_VALUE) 
        return DW_MISSING_INSTRING_VAR;
    
    $r = getvar($returnData, "retstring_length"); 
    if ($r == INVALID_VAR_VALUE)
        return DW_MISSING_RETSTRINGLEN_VAR;
    
    $EncryptedDPInStringBYREF = $str;
    $DPRetStringLenBYREF = $r;
    
    return 0;
}

function PageURL()
{
    $getVars = "";
    foreach ($_GET as $getvarname => $getvarvalue)
    {
        if ($getVars != "")
            $getVars .= "&";
            
        $getVars .= "$getvarname=$getvarvalue";
    }

    if (empty($_SERVER['HTTPS']))
        $url = "http://";
    else if ($_SERVER['HTTPS'] == "off")
        $url = "http://";
    else
        $url = "https://";
    $url .= $_SERVER['SERVER_NAME'];
    if (intval($_SERVER['SERVER_PORT']) != 80)
        $url .= ":".$_SERVER['SERVER_PORT'];
    $url .= $_SERVER["REQUEST_URI"];        

    if (strpos($url, "?") !== FALSE)
        $url = substr($url, 0, strpos($url, "?"));
        
    if (strlen($getVars) != 0)
        $url .= "?" . $getVars;

    return $url;
}

function PageCalledOverHTTPS()
{
    //$url = strtolower(PageURL());    
    //return (substr($url, 0, 5) === "https");
    if (empty($_SERVER['HTTPS']))
        return false;
    if ($_SERVER['HTTPS'] == "off")
        return false;
    return true;
}

// PHP versions prior to 5.1.0 don't support calling, eg, md5_file("http://www.example.com/myfile.abc")
function MD5HttpFile($fileURL)
{
    $returnData = "";
    $result = httpRequest2($fileURL, "GET", "", $returnData);
    if ($result != 0)
        return "";        
    
    return md5($returnData);
}

function ShowJavaAppletPage(&$dwParams, $EncryptedDDInString, $EncryptedDPInString, $DPRetStringLen)
{
    $DD_DLLHash         = "";
    $DD_DLL64Hash       = "";
    $DD_DLLJNILIBHash   = "";
    $DD_DLLJNILIB64Hash = "";
    $DD_DLLSOHash       = "";
    $DD_DLLSO64Hash     = "";
    
    $DP_DLLHash         = "";
    $DP_DLL64Hash       = "";
    $DP_DLLJNILIBHash   = "";
    $DP_DLLJNILIB64Hash = "";
    $DP_DLLSOHash       = "";
    $DP_DLLSO64Hash     = "";
    
    $pageURL = PageURL();        
    
    // Get the MD5 hash of the library files
    
    if (($dwParams->M_DongleType == DONGLETYPE_DINKEY) || ($dwParams->M_DongleType == DONGLETYPE_BOTH))
    {
        $libURL = $dwParams->M_LibrariesURL . "/" . DD_DLL . ".dll";
        $DD_DLLHash = MD5HttpFile($libURL);       

        $libURL = $dwParams->M_LibrariesURL . "/" . DD_DLL . "64.dll";
        $DD_DLL64Hash = MD5HttpFile($libURL);               
        
        $libURL = $dwParams->M_LibrariesURL . "/" . "lib" . DD_DLL . ".jnilib";
        $DD_DLLJNILIBHash = MD5HttpFile($libURL);

        $libURL = $dwParams->M_LibrariesURL . "/" . "lib" . DD_DLL . "64.jnilib";
        $DD_DLLJNILIB64Hash = MD5HttpFile($libURL);        
        
        $libURL = $dwParams->M_LibrariesURL . "/" . "lib" . DD_DLL . ".so";
        $DD_DLLSOHash = MD5HttpFile($libURL);

        $libURL = $dwParams->M_LibrariesURL . "/" . "lib" . DD_DLL . "64.so";
        $DD_DLLSO64Hash = MD5HttpFile($libURL);        
    }
    
    if (($dwParams->M_DongleType == DONGLETYPE_PROFD) || ($dwParams->M_DongleType == DONGLETYPE_BOTH))
    {
        $libURL = $dwParams->M_LibrariesURL . "/" . DP_DLL . ".dll";
        $DP_DLLHash = MD5HttpFile($libURL);       

        $libURL = $dwParams->M_LibrariesURL . "/" . DP_DLL . "64.dll";
        $DP_DLL64Hash = MD5HttpFile($libURL);               
        
        $libURL = $dwParams->M_LibrariesURL . "/" . "lib" . DP_DLL . ".jnilib";
        $DP_DLLJNILIBHash = MD5HttpFile($libURL);

        $libURL = $dwParams->M_LibrariesURL . "/" . "lib" . DP_DLL . "64.jnilib";
        $DP_DLLJNILIB64Hash = MD5HttpFile($libURL);        
        
        $libURL = $dwParams->M_LibrariesURL . "/" . "lib" . DP_DLL . ".so";
        $DP_DLLSOHash = MD5HttpFile($libURL);

        $libURL = $dwParams->M_LibrariesURL . "/" . "lib" . DP_DLL . "64.so";
        $DP_DLLSO64Hash = MD5HttpFile($libURL);                
    }
    
    $eol = "\n";    
    
    $httpProtocol               = "http";
    $dinkeywebDotComHttpPort    = "80";         // default
    if (PageCalledOverHTTPS())
    {
        $httpProtocol               = "https";
        $dinkeywebDotComHttpPort    = SERVER_SSL_PORT;
    }
    
    if ($dwParams->M_DinkeyWebSelfHostingPackage == TRUE)
        $AppletPath = $dwParams->M_AppletURL;
    else
        $AppletPath = $httpProtocol . "://" . $_SESSION['DinkeyWeb']['CurrentServer'] . ":" . $dinkeywebDotComHttpPort .  SERVER_DIR;      
    
    $Applet  = "<applet codebase=\"$AppletPath\" code=\"DinkeyWeb.class\" name=\"DinkeyWeb Applet\" archive=\"DinkeyWeb.jar\" width=\"600\" height=\"20\">" . $eol . $eol;
    
    $Applet .= '  <param name="PHPSessionID" value="'.session_id().'">' . $eol;
    $Applet .= '  <param name="ASP.NETSessionID" value="">' . $eol;
    //$Applet .= '  <param name="JSPSessionID" value="">' . $eol . $eol;
    
    $Applet .= '  <param name="SessionID" value="'.$_SESSION['DinkeyWeb']['SessionID'].'">' . $eol;
    $Applet .= '  <param name="WebSDSN" value="'.$dwParams->M_SDSN.'">' . $eol;
    $Applet .= '  <param name="DongleType" value="'.$dwParams->M_DongleType.'">' . $eol;      
    $Applet .= '  <param name="LastDongleTypeFound" value="'.$_SESSION['DinkeyWeb']['LastDongleTypeFound'].'">' . $eol;
    $Applet .= '  <param name="WebDataOffSet" value="'.$dwParams->M_DataOffset.'">' . $eol;
    $Applet .= '  <param name="WebDataLength" value="'.$dwParams->M_DataLength.'">' . $eol;
    $Applet .= '  <param name="LibsURL" value="'.$dwParams->M_LibrariesURL.'">' . $eol;

    $Applet .= '  <param name="DD_Function" value="'.$dwParams->DD_Function.'">' . $eol;
    $Applet .= '  <param name="DD_instring" value="'.$EncryptedDDInString.'">' . $eol;
    $Applet .= '  <param name="DD_DLL" value="'.DD_DLL.'">' . $eol . $eol;
    
    $Applet .= '  <param name="DD_DLLHash" value="'.$DD_DLLHash.'">' . $eol;
    $Applet .= '  <param name="DD_DLL64Hash" value="'.$DD_DLL64Hash.'">' . $eol;
    $Applet .= '  <param name="DD_DLLJNILIBHash" value="'.$DD_DLLJNILIBHash.'">' . $eol;
    $Applet .= '  <param name="DD_DLLJNILIB64Hash" value="'.$DD_DLLJNILIB64Hash.'">' . $eol;
    $Applet .= '  <param name="DD_DLLSOHash" value="'.$DD_DLLSOHash.'">' . $eol;
    $Applet .= '  <param name="DD_DLLSO64Hash" value="'.$DD_DLLSO64Hash.'">' . $eol . $eol;

    $Applet .= '  <param name="DP_Function" value="'.$dwParams->DP_Function.'">' . $eol;
    $Applet .= '  <param name="DP_instring" value="'.$EncryptedDPInString.'">' . $eol;
    $Applet .= '  <param name="retstring_length" value="'.$DPRetStringLen.'">' . $eol;
    $Applet .= '  <param name="DP_DLL" value="'.DP_DLL.'">' . $eol . $eol;
    
    $Applet .= '  <param name="DP_DLLHash" value="'.$DP_DLLHash.'">' . $eol;
    $Applet .= '  <param name="DP_DLL64Hash" value="'.$DP_DLL64Hash.'">' . $eol;
    $Applet .= '  <param name="DP_DLLJNILIBHash" value="'.$DP_DLLJNILIBHash.'">' . $eol;
    $Applet .= '  <param name="DP_DLLJNILIB64Hash" value="'.$DP_DLLJNILIB64Hash.'">' . $eol;
    $Applet .= '  <param name="DP_DLLSOHash" value="'.$DP_DLLSOHash.'">' . $eol;
    $Applet .= '  <param name="DP_DLLSO64Hash" value="'.$DP_DLLSO64Hash.'">' . $eol . $eol;    

    $Applet .= '  <param name="M_PerformingDongleCheckMsg" value="'.$dwParams->M_PerformingDongleCheckMsg.'">' . $eol . $eol;

    $Applet .= "  <div style=\"width: 1px; height:50%; background-color:#ffffff; margin-bottom:-5em; float:left;\"></div>" . $eol;
    $Applet .= "  <div onclick=\"window.open('http://java.com/java/download/index.jsp?cid=jdp141278');\" style=\"font-family:verdana,arial; font-size:10pt; cursor:pointer; margin:0 auto; position:relative; text-align:left; height:10em; width:45em; clear:left; background-color:#ff9; border:1px solid #c93; border-top-color:#fff; border-left-color:#fff;\">" . $eol;
    $Applet .= "    <img width=\"170\" height=\"100\" border=\"0\" alt=\"GetJava Download Button\" title=\"GetJava\" src=\"$httpProtocol://java.com/en/img/everywhere/getjava_lg.gif?cid=jdp141278\" style=\"float:left; margin:17px;\">" . $eol;
    $Applet .= "    <p>You need to have the Java Runtime Environment (JRE) installed and enabled to access this website. Please click the link below to download and install Java:</p>" . $eol;
    $Applet .= "    <p style=\"text-align: center;\"><a href=\"http://java.com/java/download/index.jsp?cid=jdp141278\" target=\"_blank\">http://www.java.com/getjava/</a></p>" . $eol;
    $Applet .= "    <p style=\"text-align: center;\">Once installed, simply refresh this page to continue.</p>" . $eol;
    $Applet .= "  </div>" . $eol . $eol;    
    
    $Applet .= "</applet>";
    
    $jsPostReload  = "<form id=\"postForm\" name=\"postForm\" action=\"".$pageURL."\" method=\"post\">" . $eol;
    $jsPostReload .= "  <input type=\"hidden\" id=\"_DW_JavaCalled\"                name=\"_DW_JavaCalled\"                 value=\"1\" />" . $eol;
    $jsPostReload .= "  <input type=\"hidden\" id=\"_DW_JavaRetCode\"               name=\"_DW_JavaRetCode\"                value=\"\" />" . $eol;
    $jsPostReload .= "  <input type=\"hidden\" id=\"_DW_JavaExtErr\"                name=\"_DW_JavaExtErr\"                 value=\"\" />" . $eol;
    $jsPostReload .= "  <input type=\"hidden\" id=\"_DW_JavaRetString\"             name=\"_DW_JavaRetString\"              value=\"\" />" . $eol;
    $jsPostReload .= "  <input type=\"hidden\" id=\"_DW_JavaLastDongleTypeFound\"   name=\"_DW_JavaLastDongleTypeFound\"    value=\"\" />" . $eol;
    $jsPostReload .= "  <input type=\"hidden\" id=\"_DW_OriginalRequestMethod\"     name=\"_DW_OriginalRequestMethod\"      value=\"".(empty($_POST) ? "get" : "post")."\" />" . $eol;
    foreach($_POST as $n => $v)
    {
        if (($n != "_DW_JavaCalled")                && 
            ($n != "_DW_JavaRetCode")               &&
            ($n != "_DW_JavaExtErr")                &&
            ($n != "_DW_JavaRetString")             &&
            ($n != "_DW_JavaLastDongleTypeFound")   &&
            ($n != "_DW_OriginalRequestMethod"))
        {
            $jsPostReload .= "  <input type=\"hidden\" name=\"".$n."\" value=\"".$v."\" />" . $eol;
        }
    }
    $jsPostReload .= "</form>" . $eol;
    $jsPostReload .= $eol;
    $jsPostReload .= "<script type=\"text/javascript\">" . $eol;
    $jsPostReload .= "  function dwSubmitForm(retCode, extErr, retString, lastDongleTypeFound)" . $eol;
    $jsPostReload .= "  {" . $eol;
    $jsPostReload .= "    document.getElementById(\"_DW_JavaRetCode\").value                = retCode;" . $eol;
    $jsPostReload .= "    document.getElementById(\"_DW_JavaExtErr\").value                 = extErr;" . $eol;
    $jsPostReload .= "    document.getElementById(\"_DW_JavaRetString\").value              = retString;" . $eol;
    $jsPostReload .= "    document.getElementById(\"_DW_JavaLastDongleTypeFound\").value    = lastDongleTypeFound;" . $eol;
    $jsPostReload .= "    document.getElementById(\"postForm\").submit();" . $eol;
    $jsPostReload .= "  }" . $eol;
    $jsPostReload .= "</script>" . $eol;    
    $jsPostReload .= "<noscript>" . $eol;    
    $jsPostReload .= "  <p>Warning: You must have Javascript enabled in your browser for this page to function properly.</p>" . $eol;    
    $jsPostReload .= "</noscript>";
    
    
    echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">' . $eol;
    echo "<html>" . $eol;
    echo "<head>" . $eol;
    echo '<meta http-equiv="Content-type" content="text/html; charset=UTF-8" >' . $eol;
    echo "<title>Performing Dongle Check...</title>" . $eol;
    echo "</head>" . $eol;
    echo "<body>" . $eol . $eol;
    echo $Applet . $eol . $eol;
    echo $jsPostReload . $eol . $eol;
    echo "</body>" . $eol;
    echo "</html>" . $eol;
    
    exit();     // Give them the applet page
    
    // Doesn't get here
    return;
}

function DongleCheck(&$dwParams)
{
    $ret = 0;
    
    $SessionID = CreateSession($dwParams);   
    
    $_SESSION["DinkeyWeb"]['SessionID'] = $SessionID;  // Store session ID in php session
    
    $EncryptedDDInString = "";
    $EncryptedDPInString = "";
    
    $DPRetStringLen = 0;
    
    $DDEncryptRet=0;
    $DPEncryptRet=0;
    
    $dongleType = $dwParams->M_DongleType;
    
    // We only call DDEncryptData() if we're using a Dinkey Dongle and we're going to be writing some data
    if ($dwParams->M_DataArea != "")
    {               
        if (($dongleType == DONGLETYPE_DINKEY) || ($dongleType == DONGLETYPE_BOTH))
            if ($dwParams->DD_Function == 1)
                $DDEncryptRet = DDEncryptData($dwParams, $SessionID, $EncryptedDDInString);  // This fills $EncryptedDDInString   
    }
    
    if (($dongleType == DONGLETYPE_PROFD) || ($dongleType == DONGLETYPE_BOTH))
        $DPEncryptRet = DPEncrypt($dwParams, $SessionID, $EncryptedDPInString, $DPRetStringLen); // This fills $EncryptedDPInString and $DPRetStringLen    
    
    if (($DDEncryptRet == 0) && ($DPEncryptRet == 0))   // success
    {
        // Now do the protection check        
        ShowJavaAppletPage($dwParams, $EncryptedDDInString, $EncryptedDPInString, $DPRetStringLen);
        // Does NOT return here - see the implementation of ShowJavaAppletPage()
    } 
    else    // error
    {
        if ($DDEncryptRet != 0) 
            $ret = $DDEncryptRet; 
        else 
            $ret = $DPEncryptRet;
    }
    
    return $ret;
}

function RedirectToErrorPage(&$dwParams, $errorNum, $extError, $retString)
{
    $dwerrid = "";

    do
    {        
        $dwerrid = md5( mt_rand(1, mt_getrandmax()) );
    } while (isset($_SESSION["DinkeyWeb"][DW_ERR_PREFIX.$dwerrid]));

    $a = array();
    $a[DW_ERR_PREFIX."RetCode"]         = $errorNum;
    $a[DW_ERR_PREFIX."ExtError"]        = $extError;
    $a[DW_ERR_PREFIX."RetString"]       = $retString;

    $_SESSION["DinkeyWeb"][DW_ERR_PREFIX.$dwerrid] = $a;

    header("Location: " . $dwParams->M_ErrorPageURL . "?" . DWERRID_GETVAR_NAME . "=" . $dwerrid);
    exit();
}

function CheckServers()
{
    $ret = PRIMARY_SERVER;
    $sock = @fsockopen(PRIMARY_SERVER, 80);
    if (!$sock)
        $ret = SECONDARY_SERVER;
    else
        fclose($sock);
    return $ret;
}

// This is the main protection check function
function DDProtCheck(&$dwParams)
{
    // Maintain backwards compatibility with regards to the 'DP_alt_prog_name' -> 'DP_alt_licence_name' change
    __DpAltProgNameCompat($dwParams);

    // Check they've configured their website URLs
    if ( (strpos($dwParams->M_LibrariesURL, "<YOUR WEBSITE>") !== FALSE) ||
         (strpos($dwParams->M_ErrorPageURL, "<YOUR WEBSITE>") !== FALSE) )
    {
        echo "ERROR! You must configure your website settings in the dinkeyweb defaults file.";
        exit();
    }
    
    // Enforce a minimum timeout
    $dwParams->M_Timeout = max($dwParams->M_Timeout, 5);

    if (!isset($_SESSION["DinkeyWeb"]['CurrentServer']))
        if ($dwParams->M_DinkeyWebSelfHostingPackage == FALSE)
            $_SESSION["DinkeyWeb"]['CurrentServer'] = CheckServers();
        
    if (!isset($_SESSION["DinkeyWeb"]['LastDongleTypeFound']))
        $_SESSION["DinkeyWeb"]['LastDongleTypeFound'] = DONGLETYPE_PROFD;
        
    if (!isset($_SESSION["DinkeyWeb"]['SessionID']))
        $_SESSION["DinkeyWeb"]['SessionID'] = "";      // so that empty() is safe to use on it
    
    $javaCalled = 0;
    if (isset($_POST['_DW_JavaCalled']))
        $javaCalled = intval($_POST['_DW_JavaCalled']);
    
    $dinkeyWebErrID = "";
    if (isset($_GET[DWERRID_GETVAR_NAME]))
    {
        $dinkeyWebErrID = $_GET[DWERRID_GETVAR_NAME];
        //unset($_GET[DWERRID_GETVAR_NAME]);
    }
    
    if ($javaCalled == 1)   // Java forced the browser to re-request the page using POST
    {
        $retCode                = $_POST['_DW_JavaRetCode'];
        $extErr                 = $_POST['_DW_JavaExtErr'];
        $retString              = $_POST['_DW_JavaRetString'];
        $lastDongleTypeFound    = $_POST['_DW_JavaLastDongleTypeFound'];
        $originalRequestMethod  = $_POST['_DW_OriginalRequestMethod'];
        
        $_SESSION["DinkeyWeb"]['LastDongleTypeFound'] = $lastDongleTypeFound;
        
        $sessionID = $_SESSION["DinkeyWeb"]['SessionID'];
        
        if ($retCode != 0)
            RedirectToErrorPage($dwParams, $retCode, $extErr, $retString);     // Java gave an error so redirect to the error page now
        
        if (empty($retString))
            RedirectToErrorPage($dwParams, DW_RETSTRING_EMPTY, 0, "");
        
        // Store the RetString in our session
        $_SESSION["DinkeyWeb"][$sessionID]["RetString"] = $retString;
        
        $ret = DecryptReturn($dwParams, $sessionID, $retString);        
        if ($ret != 0)
            RedirectToErrorPage($dwParams, $ret, 0, "");
        else
        {
            // Set the protcheck timeout now that we know everythings ok
            $_SESSION["DinkeyWeb"][$sessionID]["TimeoutTime"] = time() + $dwParams->M_Timeout;
            
            if (strtolower($originalRequestMethod) == "get")
            {
                $_SESSION["DinkeyWeb"][$sessionID]["ProtCheckRedirectForGET"] = true;
                header("Location: " . PageURL());
                exit();
            }
            else
            {
                return;
            }
        }
    }
    
    if (isset($_SESSION["DinkeyWeb"][DW_ERR_PREFIX.$dinkeyWebErrID]))
    {
        $a = $_SESSION["DinkeyWeb"][DW_ERR_PREFIX.$dinkeyWebErrID];
        //unset($_SESSION["DinkeyWeb"][DW_ERR_PREFIX.$dinkeyWebErrID]);
        
        $retCode                = $a[DW_ERR_PREFIX.'RetCode'];
        $extErr                 = $a[DW_ERR_PREFIX.'ExtError'];
        $retString              = $a[DW_ERR_PREFIX.'RetString'];
        
        $sessionID = $_SESSION["DinkeyWeb"]['SessionID'];
        
        if (!empty($retString))
            DecryptReturn($dwParams, $sessionID, $retString);

        $dwParams->M_ReturnCode      = $retCode;
        $dwParams->M_ExtendedError   = $extErr;
        
        return;             
    }
    
    // If we're here then we haven't had Java check the dongle        
    
    if (empty($_SESSION["DinkeyWeb"]['SessionID']))
    {
        // We have no SessionID so call DongleCheck() which will create one and then produce the applet page.
        $ret = DongleCheck($dwParams);
        if ($ret != 0)
            RedirectToErrorPage($dwParams, $ret, $g_exterr, "");
    }
    else
    {
        $RetString = "";
        
        $sessionID = $_SESSION["DinkeyWeb"]['SessionID'];
        
        // We have a session ID so check it's valid
        $ok = CheckValidSession($dwParams, $sessionID, $RetString);   // This fills in $RetString

        if ($ok) 
        {                       
            $ret = DecryptReturn($dwParams, $sessionID, $RetString);
            
            if ($ret != 0)             
                RedirectToErrorPage($dwParams, $ret, $g_exterr, "");
            else
            {
                // Compare SDSNs to check that the correct dongle is being used
                if ($dwParams->M_SDSN != $dwParams->M_DongleInfo['sdsn'])
                    RedirectToErrorPage($dwParams, ERR_SDSN_MISMATCH, 0, "");
                    
                $dwParams->M_ReturnCode      = 0;
                $dwParams->M_ExtendedError   = "";
            }
        }
        else
        {
            // Session expired/changed etc
            
            $ret = DongleCheck($dwParams);
            if ($ret != 0)
                RedirectToErrorPage($dwParams, $ret, $g_exterr, "");
        }
    } 
}

// Note: there must be no trailing white-space after the PHP end tag
?>