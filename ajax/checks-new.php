<?php
include 'default.php';
$sql = "SELECT * FROM `con_accepted_ip`";
$result = mysqli_query($conn, $sql);
$i==0;
while($row = mysqli_fetch_array($result)){
    if($_SERVER['REMOTE_ADDR']==$row['con_accept_ip_ip']){
        $i = 1;
    }
}
if($i==1){
    $ans = "1";
}else{
    $sql = "SELECT user_remote_work FROM users WHERE user_id=".$_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if($row['user_remote_work']==1){
        $ans = "2";
    }else{
        $ans = "0";
    }
}





$sql = "SELECT `user_status` FROM `users` WHERE `user_id`='".$_SESSION['user_id']."'";
$result = mysqli_query($conn, $sql); 
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
if($_GET['type']==$_GET['event']){
$sql_status = "INSERT INTO `records_new` (`user_id`,`record_event`,`record_date`,`record_in_time`,`record_in_create`,`record_in_remote`) VALUES (
            '".$_SESSION['user_id']."',
            '".$_GET['event']."',
            '".Date('Y-m-d')."',
            '".Date('H:i:s')."',
            '".$_SESSION['user_id']."',
            '".$ans."'
        );
        UPDATE users SET `user_status`='".$_GET['event']."' WHERE `user_id`='".$_SESSION['user_id']."';
        ";
        if(mysqli_multi_query($conn,$sql_status)){
            mysqli_next_result($conn);
            include("checks-reload.php");
        }
}else{
    $sql_check = "SELECT `record_id` FROM `records_new` WHERE `record_event`='".$row['user_status']."' AND `user_id`='".$_SESSION['user_id']."' AND `record_out_time`  IS NULL AND `record_date` = '".Date('Y-m-d')."' LIMIT 1 ";
    $result_check = mysqli_query($conn, $sql_check);
    $row_check = mysqli_fetch_array($result_check,MYSQLI_ASSOC);
    if(count($row_check)>0){


   $sql_status = "UPDATE `records_new` SET 
     `record_out_time`='".Date('H:i:s')."',
     `record_out_create`='".$_SESSION['user_id']."',
     `record_out_remote`='".$ans."'
     WHERE `record_id`='".$row_check['record_id']."';
        UPDATE users SET `user_status`='".$_GET['type']."' WHERE `user_id`='".$_SESSION['user_id']."';
        ";
        if(mysqli_multi_query($conn,$sql_status)){
            mysqli_next_result($conn);
            include("checks-reload.php");
        }
    }else{
        $sql_status = " UPDATE `records_new` SET 
     `record_out_time`='23:59:59',
     `record_out_create`='0',
     `record_out_remote`='0'
     WHERE `record_out_create` IS NULL AND `user_id`='".$_SESSION['user_id']."';
        UPDATE users SET `user_status`='0' WHERE `user_id`='".$_SESSION['user_id']."';
        ";
        if(mysqli_multi_query($conn,$sql_status)){
            mysqli_next_result($conn);
            include("checks-reload.php");
        }
    }
}

?>