<?php
include('default.php');
$realIP = $_SERVER['REMOTE_ADDR'];
$sql = "SELECT `user_remote_work` FROM users WHERE `user_id`=".$_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
$row2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
$sql = "SELECT * FROM `con_accepted_ip` WHERE `con_accept_ip_ip`='".$realIP."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
if(!empty($row)||$row2['user_remote_work']=="1"){


    $sql = "SELECT `user_status` FROM `users` WHERE `user_id`='".$_SESSION['user_id']."'";
    $result = mysqli_query($conn, $sql); 
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if($_GET['type']==$_GET['event']){
     $sql_status = "INSERT INTO `records_new` (`user_id`,`record_event`,`record_date`,`record_in_time`,`record_in_create`) VALUES (
                '".$_SESSION['user_id']."',
                '".$_GET['event']."',
                '".Date('Y-m-d')."',
                '".Date('H:i:s')."',
                '".$_SESSION['user_id']."'
            );
            UPDATE users SET `user_status`='".$_GET['event']."' WHERE `user_id`='".$_SESSION['user_id']."';
            ";
            if(mysqli_multi_query($conn,$sql_status)){
                echo "OK!";
            }
    }else{
        $sql_check = "SELECT `record_id` FROM `records_new` WHERE `record_event`='".$row['user_status']."' AND `record_out_time` IS NULL LIMIT 1 ";
        $result_check = mysqli_query($conn, $sql_check);
        $row_check = mysqli_fetch_array($result_check,MYSQLI_ASSOC);
        $sql_status = "UPDATE `records_new` SET 
         `record_out_time`='".Date('H:i:s')."',
         `record_out_create`='".$_SESSION['user_id']."'
         WHERE `record_id`='".$row_check['record_id']."';
            UPDATE users SET `user_status`='".$_GET['type']."' WHERE `user_id`='".$_SESSION['user_id']."';
            ";
            if(mysqli_multi_query($conn,$sql_status)){
                echo "OK!";
            }
    }




}else{
    ?>
    <section >
<h1>Wygląda na to że jesteś w innej lokalizacji,</h1>
<h1>Zaloguj się do firmowej sieci żeby móc kontynuować</h1>
<h2>Jeżeli jest to błąd, i jesteś w sieci - poinformuj o tym administratora</h2>
</section>
    <?php
}


?>