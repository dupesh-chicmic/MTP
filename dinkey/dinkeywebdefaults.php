<?php

/*************************************************************/
/*********          dinkeywebdefaults.php            *********/
/*************************************************************/
/*********        You CAN modify this file!          *********/
/*************************************************************/
/****    This file contains your default settings and     ****/
/****       definitions of constants for DinkeyWeb.       ****/
/*************************************************************/

// Dongle-type constants
define ("DONGLETYPE_DINKEY",        0);
define ("DONGLETYPE_PROFD",         1);
define ("DONGLETYPE_BOTH",          2);

// DinkeyPro/DinkeyFD Functions
define ("PROTECTION_CHECK",         1);
define ("WRITE_DATA_AREA",          3);
define ("READ_DATA_AREA",           4);

// DinkeyPro/DinkeyFD Flags
define ("DEC_ONE_EXEC",             1);
define ("DEC_MANY_EXECS",           2);
define ("START_NET_USER",           4);
define ("STOP_NET_USER",            8);
define ("USE_ALT_LICENCE_NAME",     128);
define ("DONT_SET_MAXDAYS_EXPIRY",  256);


// ====== DinkeyWebParams structure ======
// * This structure defines your parameters for DinkeyWeb.
// * Set your default values here (You can change specific ones on a per-page basis later).
// * This structure also contains informative fields which you can read following a call to DDProtCheck().
class DinkeyWebParams
{
    /*************************************************************/
    /***      GENERAL - Set your site-wide defaults here.      ***/   
    /*************************************************************/
    
    // Settings for all dongle types
    var $M_SDSN         = 10101;                // Your SDSN
    var $M_DongleType   = DONGLETYPE_PROFD;     // Must be one of the DONGLETYPE_xxx values defined above
    var $M_Timeout      = 60;                   // Timeout (in seconds) between protection checks being required
    var $M_DataArea     = "";                   // Data area you want to write to the dongle
    var $M_DataOffset   = 0;                    // Data area offset to read to or write from
    var $M_DataLength   = 0;                    // Length of data area to read/write
    
    // Settings for DinkeyPro and DinkeyFD dongles
    var $DP_Function            = PROTECTION_CHECK; // Must be one of the DinkeyPro/DinkeyFD functions shown above
    var $DP_Flags               = 4;                // Bitwise-OR of the DinkeyPro/DinkeyFD flags shown above
    var $DP_ExecsDecrement      = 1;                // How many executions to decrement when using the DEC_MANY_EXECS flag in $DP_Flags    
    var $DP_alt_licence_name    = "";               // Set to check protection for a different licence (not normally used)    
    
    // Settings for the (older) Dinkey Dongles
    var $DD_Function    = 0;            // 0 = protection check, update params & read data area, 1 = write data area (see please see Dinkey Dongle user manual for more function numbers)

    // Settings relating to your site
    var $M_LibrariesURL = "http://localhost/MTP/dinkey/libs/protected";
    var $M_ErrorPageURL = "http://localhost/MTP/index.php?r=member/dinkeyError";
    
    
    /*****************************************************************/
    /***      OUTPUTS - These fields are set by DDProtCheck()      ***/
    /*****************************************************************/
    var $M_ReturnCode;          // The result of calling DDProtCheck()
    var $M_ExtendedError;
    var $M_DongleInfo;          // An array which provides you with information about the Dongle following a call to DDProtCheck().
                                // This array may be filled, even on error (i.e., M_ReturnCode != 0) so you should test it by calling empty().
                                // You can index the array using any of the following strings:
                                //      "dongle_no"
                                //      "sdsn"
                                //      "prodcode"
                                //      "execs"
                                //      "exp_day"
                                //      "exp_month"
                                //      "exp_year"
                                //      "features"
                                //      "update"
                                //      "model"
                                //      "maxnetusers"
                                //      "usb"
                                //      "data"
                                //      "type"
                                //      "fd_capacity"

    /*********************************************************************************************/
    /***   MESSAGES - These are displayed by the Java applet. You can edit them if you wish.   ***/
    /*********************************************************************************************/
    var $M_PerformingDongleCheckMsg = "Performing dongle check. Please wait.....";

    /*******************************************************************************************************************/
    /**    Only change the following values if you are using the DinkeyWeb Self-Hosting Package on your own server    **/
    /*******************************************************************************************************************/
    var $M_DinkeyWebSelfHostingPackage  = FALSE;        // Set this to TRUE only if you're using the complete DinkeyWeb Self-Hosting Package.
    var $M_EncDecPath                   = "";           // Filesystem path of the directory containing the encryption and decryption programs.
    var $M_AppletURL                    = "";           // URL of the directory containing DinkeyWeb.jar. Do not include "DinkeyWeb.jar" in this URL.
                                                        //   eg, http://www.example.com/mysite/subdir
}


// Note: there must be no trailing white-space after the PHP end tag
?>