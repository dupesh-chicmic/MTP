<?php
    if( isset($adjustedValue) && !empty($adjustedValue) ){
        echo $adjustedValue;
            (strlen($adjustedValue)>15) ? $adjustedValue='' : $adjustedValue=$adjustedValue;
            if(!isset($_POST['isMobileCall'])){
                echo '</div>
                <div class="newpdficon">
                <a href="index.php?r=member/generatePdf&m='.$carOrCom.'&cn='.$codenumber.'&uy='.$userYear.'&ukms='.$userKms.'&v='.$adjustedValue.'&imp='.$import.'&make='.$make.'&rangecode='.$rangecode.'" target="_blank"><img src="./images/pdf.png" style="border:none; width:28px; height:28px;" alt="[pdf]" /></a>
                </div>';
            }
    }else{
        echo 'wrong data';
    }
?>
<style>
.newpdficon {
    position: relative;
    left: 43px;
    top: 30px;
}
</style>
