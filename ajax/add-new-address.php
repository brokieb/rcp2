<?php
include "default.php";
$sql = "SELECT * FROM `con_accepted_ip` WHERE `con_accept_ip_ip`='".$_GET['address']."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
if(empty($row)){
    $sql = "INSERT INTO `con_accepted_ip`(`con_accept_ip_ip`,`accepted_ip_created`) VALUES ('".$_GET['address']."','".$_SESSION["user_id"]."');
    INSERT INTO `logs`( `log_value`, `user_id`, `log_type`) VALUES ('Dodał nowy akceptowany adres IP do bazy ".$_GET['address']." ','".$_SESSION['user_id']."','0');
    ";
    if(mysqli_multi_query($conn, $sql)){
        echo $_GET['address'];
    }
}else{
    echo "BLAD";
}

?>