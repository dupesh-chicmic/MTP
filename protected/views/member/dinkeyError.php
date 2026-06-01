<?php 

require "dinkeywebinc.php";

$dwParams = new DinkeyWebParams();

DDProtCheck($dwParams); // DDProtCheck() must be called before any output has been generated

?>
<!--<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Dinkey Dongle Error Page</title>
</head>
<body>-->

<?php
        $cmsDinkeyError = DinkeyErrorMessage::model()->find(array(
            'condition'=>'error_number=:error',
            'params'=>array(':error'=>$dwParams->M_ReturnCode)
        ));

        if(empty($cmsDinkeyError)){
            // show default error message
                echo CmsDictionary::model()->dictionaryGetText('dinkey_error_default');
?>
            <p>Error Code: <?php echo $dwParams->M_ReturnCode; ?></p>
            <p>Extended Error: <?php echo $dwParams->M_ExtendedError; ?></p>
<?php
        }else{
            // show by error code
            echo $cmsDinkeyError->text;
        }
?>




<!--</body>
</html>-->
