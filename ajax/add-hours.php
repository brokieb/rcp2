<?php
include('default.php');
echo $sql = "INSERT INTO `add_time` (accept_id,addtime_accept_mod,addtime_time,znak) VALUES (
    '".$_GET['accept_id']."',
    '".$_SESSION['user_id']."',
    '".$_GET['czas']."',
    '".$_GET['znak']."'
);
UPDATE `accepted_days` SET addtime_id=LAST_INSERT_ID(),accept_type=1 WHERE `accept_id`='".$_GET['accept_id']."';
INSERT INTO `logs`( `log_value`, `user_id`, `log_type`) VALUES ('Poprawił godziny do rekordu ".$_GET['accept_id']."','".$_SESSION['user_id']."','0');
";

if(mysqli_multi_query($conn, $sql)){
 echo "OK";
    }
?>