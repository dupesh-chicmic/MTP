<html>
<head>
<title>Realex Payments HPP - PHP Sample Code - Request Script</title>

<?php

// Replace these with the values you receive from Realex Payments
$merchantid = "yourMerchantId";
$secret = "yourSecret";

// The code below is used to create the timestamp format required by Realex Payments
$timestamp = strftime("%Y%m%d%H%M%S");
mt_srand((double)microtime()*1000000);

// orderid:Replace this with the order id you want to use.The order id must be unique.
// In the example below a combination of the timestamp and a random number is used.
$orderid = $timestamp."-".mt_rand(1, 999);

// In this example these values are hardcoded. In reality you may pass
// these values from another script or take it from a database.
$curr = "EUR";
$amount = "3000";

// Below is the code for creating the digital signature using the SHA1 algorithm provided by PHP
$tmp = "$timestamp.$merchantid.$orderid.$amount.$curr";
$sha1hash = sha1($tmp);
$tmp = "$sha1hash.$secret";
$sha1hash = sha1($tmp);

?>

</head>

<body bgcolor="#FFFFFF">

<!--
https://hpp.realexpayments.com/pay is the script where the hidden fields
for LIVE transactions are POSTed to.

If the merchant is in TEST mode, the script to post the hidden fields to is:
https://hpp.sandbox.realexpayments.com/pay

The values are sent to Realex Payments via hidden fields in a HTML form POST.
Please look at the documentation to show all the possible hidden fields you
can send to Realex Payments.

Note:
The more data you send to Realex Payments the more details will be available
on our reporting tool, Real Control, for the merchant to view and pull reports
down from.

Note:
If you POST data in hidden fields that are not a Realex hidden field that data
will be POSTed back directly to your response script. This way you can maintain
data even when you are redirected away from your site
-->

<form action=https://hpp.sandbox.realexpayments.com/pay method=post>

<input type=hidden name="MERCHANT_ID" value="<?=$merchantid?>">
<input type=hidden name="ORDER_ID" value="<?=$orderid?>">
<input type=hidden name="CURRENCY" value="<?=$curr?>">
<input type=hidden name="AMOUNT" value="<?=$amount?>">
<input type=hidden name="TIMESTAMP" value="<?=$timestamp?>">
<input type=hidden name="SHA1HASH" value="<?=$sha1hash?>">
<input type=hidden name="AUTO_SETTLE_FLAG" value="1">

<input type=submit value="Proceed to secure server">
</form>

<font face=verdana>
<font size=3><b>Realex Payments HPP - PHP Sample Code</b></font>
<p>
<font size=2>Select View/Source to see the output
<ul>
<li>Realex Payments HPP - PHP Sample Code
<li>You can add the text here which you would like the customer to view before redirecting to
the Realex Payments Hosted Payment Page.
</ul>
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
