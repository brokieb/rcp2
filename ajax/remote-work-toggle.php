<?php
include("default.php");
$sql = "
SET @stan = IF((SELECT `user_remote_work` FROM `users` WHERE `user_id`=".$_GET['id'].") =1, 0, 1);
UPDATE `users` SET `user_remote_work`= @stan WHERE `user_id`=".$_GET['id'].";
INSERT INTO `logs`( `log_value`, `user_id`, `log_type`) VALUES (CONCAT('Zmienił stan pracy zdalnej u użytkownika ".$_GET['id']." na ', @stan),'".$_SESSION['user_id']."','0');
";
if(mysqli_multi_query($conn ,$sql)){
    echo "OK";
}else{
    echo "BLAD";
}
?>