<?php
$uzytkownik = Uzytkownik::model()->find('id=?',array(Yii::app()->user->getId()));
?>

<div style="padding-top:30px; width:544px;">
    <h1>Licence Expired</h1>
Your licence has expired. This may be due to a number of reasons:
<br /><br />
1) Your trial period has ended. If you wish to continue using this product online, please contact our office via the <a style="text-decoration: none; color:#68b5c2;" href="<?php echo Yii::app()->createUrl('/cms/cmsPage/displayPage',array('url'=>'contact')); ?>">Contact</a> tab at the top of the screen or call our office on 01-8775460.
<br /><br />
2) Your annual subscription has expired. We authorise all users with an additional 30 days access to allow for payment to be arranged.
<br /><br />
If neither reason applies to you please contact our office and we will sort out this issue for you.    
<br />
</div>