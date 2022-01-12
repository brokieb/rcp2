<?php
include('default.php');

$sql = "SELECT * FROM `accepted_months` WHERE `accept_m_user_id`='".$_SESSION['user_id']."' AND `accept_m_code`='".$_GET['code']."' LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$ans = [];
if(empty($row)){
    $ans = 0;
}else{
 $sql = "UPDATE `accepted_months` SET `accept_m_status`='2' WHERE `accept_m_id`='".$row['accept_m_id']."' ";
    if(mysqli_query($conn, $sql)){
        $ans = 1;
    }
}

echo '{"ans":'.$ans.'}';
?>