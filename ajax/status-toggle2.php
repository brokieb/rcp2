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
$sql = "SELECT `user_status` FROM users WHERE `user_id`=".$_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$sql_l = "SELECT * FROM `records` WHERE `user_id`='".$_SESSION['user_id']."' ORDER BY record_id DESC LIMIT 1 ";
$result_l = mysqli_query($conn, $sql_l);
$row_l = mysqli_fetch_array($result_l,MYSQLI_ASSOC);
    $sql2 = "UPDATE users SET 
    `user_status` = '".$_GET['action-new']."',
    `user_last-device` = '".$_COOKIE['device']."',
    `user_last-edit` = '".Date('Y-m-d H:i:s')."'
    WHERE `user_id`=".$_SESSION['user_id'];
    if(mysqli_query($conn, $sql2)){

    if($_GET['action-new']!=$_GET['action-old']){//date('Y-m-d')
       $sql3 = "INSERT INTO records (`user_id`,`record_type`,`record_status`,`record_date`,`record_time`,`record_comment`,`record_create`)
        VALUES 
        (
            '".$_SESSION['user_id']."',
            '".$_GET['action-old']."',
            'OUT',
            '".date('Y-m-d')."',
            '".date('H:i:s')."',
            '',
            '".$_SESSION['user_id']."'
        ),
        (
            '".$_SESSION['user_id']."',
            '".$_GET['action-new']."',
            'IN',
            '".date('Y-m-d')."',
            '".date('H:i:s')."',
            '',
            '".$_SESSION['user_id']."'
        )
        
        
        
        
        ;";
    }else{
        $sql3 = "INSERT INTO records (`user_id`,`record_type`,`record_date`,`record_time`,`record_comment`,`record_create`)
            VALUES 
            (
                '".$_SESSION['user_id']."',
                '".$_GET['action-new']."',
                '".date('Y-m-d')."',
                '".date('H:i:s')."',
                '',
                '".$_SESSION['user_id']."'
            );";
    }

    
            
        if(mysqli_query($conn, $sql3)){
            include("checks-reload.php");
        }
    }else{
        echo "BLAD";
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