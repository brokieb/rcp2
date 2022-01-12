<?php
include('default.php');
echo $sql = "INSERT INTO `offers`(`offer_name`, `offer_max-users`, `offer_max-ip`, `offer_max-devices`, `offer_remote`,  `offer_invoice-exports`, `offer_24h-work`, `offer_break-record`, `offer_more-statuses`, `offer_absense-holiday`,`offer_pay-per-user`,`offer_price`)
 VALUES (
     '".$_GET['name']."',
     '".$_GET['max-users']."',
     '".$_GET['max-ip']."',
     '".$_GET['max-dev']."',
     '".$_GET['payment-remote']."',
     '".$_GET['payment-invoice']."',
     '".$_GET['payment-24h']."',
     '".$_GET['payment-break']."',
     '".$_GET['payment-new-status']."',
     '".$_GET['payment-holidays']."',
     '".$_GET['payment-user']."',
     '".$_GET['price']."'
     )";
     if(mysqli_query($conn,$sql)){
         echo '{"ans":"1"}';
     }
?>