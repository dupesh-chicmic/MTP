<?php
if( isset($adjustedValue) && !empty($adjustedValue) ){
    //echo '<span>';
    echo $adjustedValue;
    //if(!empty($carOrCom)){
        (strlen($adjustedValue)>15) ? $adjustedValue='' : $adjustedValue=$adjustedValue;
        if(!isset($_POST['isMobileCall'])){
            echo '<a href="index.php?r=member/generatePdf&m='.$carOrCom.'&cn='.$codenumber.'&uy='.$userYear.'&ukms='.$userKms.'&v='.$adjustedValue.'&imp='.$import.'"><img src="./images/pdf.png" style="border:none; width:28px; height:28px;" alt="[pdf]" /></a>';
        }
        
    //}
    //echo '</span>';
}else{
    echo 'wrong data';
}
?>
