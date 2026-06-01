<html>
<head>
<title>Realex Payments HPP - PHP Sample Code - Response Script</title>

<?php

/*
 Note:The below code is used to grab the fields Realex Payments POSTs back
 to this script after a transaction has been processed. Realex Payments need
 to know the full URL of this script in order to POST the data back to this
 script. Please inform Realex Payments of this URL if they do not have it
 already.

 Look at the Realex Documentation to view all hidden fields Realex POSTs back
 for a card transaction.
*/

$timestamp = $_POST['TIMESTAMP'];
$result = $_POST['RESULT'];
$orderid = $_POST['ORDER_ID'];
$message = $_POST['MESSAGE'];
$authcode = $_POST['AUTHCODE'];
$pasref = $_POST['PASREF'];
$realexsha1 = $_POST['SHA1HASH'];

/*
If you are enabled for DCC, these additional fields will also be posted to your response script

$merchantamount = $_POST['DCCAUTHMERCHANTAMOUNT'];
$merchantcurrency = $_POST['DCCAUTHMERCHANTCURRENCY'];
$cardholderamount = $_POST['DCCAUTHCARDHOLDERAMOUNT'];
$cardholdercurrency = $_POST['DCCAUTHCARDHOLDERCURRENCY'];
$cardholderrate = $_POST['DCCAUTHRATE'];
$dccrate = $_POST['DCCAUTHRATE'];
$dccchoice = $_POST['DCCCHOICE'];

*/

// Replace these with the values you receive from Realex Payments.If you have not yet received these values please contact Realex Payments.
$merchantid = "yourMerchantId";
$secret = "yourSecret";

// Below is the code for creating the digital signature using the SHA1 algorithm provided by PHP
// This digital siganture should correspond to the
// one Realex Payments POSTs back to this script and can therefore be used to verify the message Realex sends back.
$tmp = "$timestamp.$merchantid.$orderid.$result.$message.$pasref.$authcode";
$sha1hash = sha1($tmp);
$tmp = "$sha1hash.$secret";
$sha1hash = sha1($tmp);

//Check to see if hashes match or not
if ($sha1hash != $realexsha1) {
	echo "Hashes don't match - response not authenticated!";
}

/*
 You can send yourself an email or send the customer an email or update a database or whatever you want to do here.

 The next part is important to understand. The result field sent back to this
 response script will indicate whether the transaction was successful or not.
 The result 00 indicates it was successful while anything else indicates it failed.
 Refer to the Realex Payments documentation to get a full list to response codes.

 IMPORTANT: Whatever this response script prints is grabbed by Realex Payments
 and placed in the template again. It is placed wherever the <hpp:body/> tag
 is in the template you provide. This is the case so that from a customer's perspective, they are not suddenly removed from
 a secure site to an unsecure site. This means that although we call this response script the
 customer is still on Realex Payment's site and therefore it is recommended that a HTML link is
 printed in order to redirect the customrer back to the merchants site.
*/

?>

<body bgcolor="#FFFFFF">
<font face=verdana,helvetica,arial size=2>

<?php
// The transaction has been successful
if ($result == "00") {
?>
<!-- You can replace this text with whatever you wish to display to your customers following a successful transaction-->
Thank you
<br/><br/>
To continue browsing please <a href="http://yourdomain.com"><b><u>click here</u></b></a>
<br/><br/>

<?php
// The transaction was not successful. You can ask the customer to amend their details or try a different payment method
} elseif ($result == "101") {
?>
<!-- You can replace this text with whatever you wish to display to your customers following an unsuccessful transaction-->
Your transaction has not been successful, please try another payment method.

<br/><br/>
To continue browsing please <a href="http://yourdomain.com"><b><u>click here</u></b></a>
<br/><br/>

<?php
}

elseif ($result == "103") {
?>
<!-- You can replace this text with whatever you wish to display to your customers following an unsuccessful transaction-->
This card has been reported lost or stolen, please contact your bank.

<br/><br/>
To continue browsing please <a href="http://yourdomain.com"><b><u>click here</u></b></a>
<br/><br/>

<?
}

elseif ($result == "205") {
?>
<!-- You can replace this text with whatever you wish to display to your customers following an unsuccessful transaction-->
There has been a communications error, please try again later.

<br/><br/>
To continue browsing please <a href="http://yourdomain.com"><b><u>click here</u></b></a>
<br/><br/>

<?php
}

else {
?>
<!-- You can replace this text with whatever you wish to display to your customers following an unsuccessful transaction-->
<br/><br/>
There was an error processing your subscription.
To try again please <a href="http://yourdomain.com"><b><u>click here</u></b></a><br><BR>
Please contact our customer care department at <a href="mailto:custcare@yourdomain.com"><b><u>custcare@yourdomain.com</u></b></a>
or if you would prefer to subscribe by phone, call on 01 2839428349
NOTE: This link should bring the customer back to a place where an new orderid is
created so that they can try to use another card. It is important that a new orderid
is created because if the same orderid is sent in a second time Realex Payments will
reject it as a duplicate order even if the first transaction was declined.


<?php
}
?>

</font>

</body>
</html>

<?php
/*

Pay and Shop Limited (Realex Payments) - Licence Agreement.
� Copyright and zero Warranty Notice.

Merchants and their internet, call centre, and wireless application
developers (either in-house or externally appointed partners and
commercial organisations) may access Realex Payments technical
references, application programming interfaces (APIs) and other sample
code and software ("Programs") either free of charge from
www.realexpayments.com or by emailing info@realexpayments.com.

Realex Payments provides the programs "as is" without any warranty of
any kind, either expressed or implied, including, but not limited to,
the implied warranties of merchantability and fitness for a particular
purpose. The entire risk as to the quality and performance of the
programs is with the merchant and/or the application development
company involved. Should the programs prove defective, the merchant
and/or the application development company assumes the cost of all
necessary servicing, repair or correction.

Copyright remains with Realex Payments, and as such any copyright
notices in the code are not to be removed. The software is provided as
sample code to assist internet, wireless and call center application
development companies integrate with the Realex Payments service.

Any Programs licensed by Realex Payments to merchants or developers are
licensed on a non-exclusive basis solely for the purpose of availing
of the Realex Payments service in accordance with the
written instructions of an authorised representative of Realex Payments.
Any other use is strictly prohibited.

*/
?>

