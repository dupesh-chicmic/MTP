<?php

$dict_had_logo = CmsDictionary::model()->dictionaryGetText('had_logo');
$dict_txt_front_currency = CmsDictionary::model()->dictionaryGetText('txt_front_currency');
$dict_txt_front_payment_cancelled = CmsDictionary::model()->dictionaryGetText('txt_front_payment_cancelled');


echo '<div class="strona">
            <div class="pathProducts"><span><a href="index.php">'.$dict_had_logo.'</a> / Payment cancelled </span></div>';
//echo '<div class="join"></div>';
            echo '<div class="pageProducts">
                <div class="pageTitle">Payment cancelled</div>
                <div class="pageTresc">';

echo $dict_txt_front_payment_cancelled;

echo '</div>';
echo '</div>';
echo '</div>';
?>
