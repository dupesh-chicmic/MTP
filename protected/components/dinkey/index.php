<?php 

require "dinkeywebinc.php";         

$dwParams = new DinkeyWebParams();

DDProtCheck($dwParams);   // DDProtCheck() must be called before any output has been generated

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Dinkey Dongle Test Page</title>
</head>
<body> 

    <h1>SUCCESS!</h1>

    <p>If you can see this then the protection check worked.</p>
    
    <p>Below is all the information stored in the dongle:</p>
    
<?php
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
?>    
    
    <p>
    <?php echo "Result of protection check = " . $dwParams->M_ReturnCode; ?>
    </p>

    
</body>
</html>
