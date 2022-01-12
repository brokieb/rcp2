<?php
include("default.php");

    $sql = "DELETE FROM `con_accepted_ip` WHERE `con_accept_ip_id`=".$_GET['id'].";
    INSERT INTO `logs`( `log_value`, `user_id`, `log_type`) VALUES ('Usunął IP o ID  ".$_GET['id']." z dozwolonych adresów','".$_SESSION['user_id']."','0');
    ";
    if(mysqli_multi_query($conn, $sql)){
        echo "1";
    }else{
    echo "0";
}

?>