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
if ($dwParams->M_ReturnCode==1612){
?>
<h1>Access restricted!!</h1>
<p>No protection dongle recognized. Please insert the Dinkey Dongle into your USB.</p> 
<?php
}else if ($dwParams->M_ReturnCode==447){
?>
<h1>ERROR!!</h1>
<p>You have tried to start more than one network user for the same program within the same process.</p> 
<p>This could happen if you removed the dongle while working on the protected website.</p>
<p>Please restart the browser.</p>
<?php
}else {?>
    <h1>ERROR!!</h1>

    <p>An error occurred during the protection check.</p>           
    
    <p>Error Code: <?php echo $dwParams->M_ReturnCode; ?></p>
    <p>Extended Error: <?php echo $dwParams->M_ExtendedError; ?></p>
    
    
    
<?php
    if (empty($dwParams->M_DongleInfo))
        echo "<p>We know nothing about the dongle!</p>";
    else
    {
        echo "<p>Below is all the information we have about the dongle:</p>";
        echo "<p>";
        echo "Dongle Number = ". $dwParams->M_DongleInfo['dongle_no'] ."<br>";
        echo "SDSN = ". $dwParams->M_DongleInfo['sdsn'] ."<br>";
        echo "Product Code = ". $dwParams->M_DongleInfo['prodcode'] ."<br>";
        echo "Executions = ". $dwParams->M_DongleInfo['execs'] ."<br>";
        echo "Expiry Day = ". $dwParams->M_DongleInfo['exp_day'] ."<br>";
        echo "Expiry Month = ". $dwParams->M_DongleInfo['exp_month'] ."<br>";
        echo "Expiry Year = ". $dwParams->M_DongleInfo['exp_year'] ."<br>";
        echo "Features = ". $dwParams->M_DongleInfo['features'] ."<br>";
        echo "Update = ". $dwParams->M_DongleInfo['update'] ."<br>";
        echo "Model = ". $dwParams->M_DongleInfo['model'] ."<br>";
        echo "Maximum Network Users = ". $dwParams->M_DongleInfo['maxnetusers'] ."<br>";
        echo "USB = ". $dwParams->M_DongleInfo['usb'] ."<br>";
        echo "Data = ". $dwParams->M_DongleInfo['data'] ."<br>";    
        echo "Type = ". $dwParams->M_DongleInfo['type'] ."<br>";
        echo "DinkeyFD Capacity = ". $dwParams->M_DongleInfo['fd_capacity'] ."<br>";
        echo "</p>";
    }
    
?>    
    
    <p><?php echo "Result of protection check = " . $dwParams->M_ReturnCode; ?></p>
<?php } ?>