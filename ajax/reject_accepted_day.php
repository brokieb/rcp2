<?php
include('default.php');
echo $sql = "UPDATE `accepted_days` SET `accept_type`=0 WHERE `accept_id`=".$_GET['id'].";
INSERT INTO `logs`( `log_value`, `user_id`, `log_type`) VALUES ('Odrzucono już zaakceptowany dzień o ID ".$_GET['id']."','".$_SESSION['user_id']."','0'); ";
if(mysqli_multi_query($conn, $sql)){
    echo "OK";
   }
?>