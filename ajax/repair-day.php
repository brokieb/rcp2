<?php
include("default.php");
$x = [];
$x[] = $_GET['time'];
$x[] = "00:01:00";
// echo $_GET['record_time'];
echo $sql = "INSERT INTO `records` (`record_id`, `user_id`, `record_type`, `record_date`, `record_time`, `record_comment`, `record_status`, `record_create`) VALUES 
(NULL, '".$_GET['id']."', '1', '".$_GET['date']."', '".AddTime($x).":03', 'Zdebugowano', 'OUT', '0'), 
(NULL, '".$_GET['id']."', '0', '".$_GET['date']."', '".AddTime($x).":03', 'Zdebugowano', 'IN', '0');";
if(mysqli_multi_query($conn,$sql)){
    echo "OK!";
}




?>


