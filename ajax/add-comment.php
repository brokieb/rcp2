<?php
include('default.php');
echo $sql = "UPDATE `records` SET
`record_comment`=concat(`record_comment`,' ".$_GET['comment']."')
WHERE `record_id` IN(".$_GET['record_id'].");
INSERT INTO `logs`( `log_value`, `user_id`, `log_type`) VALUES ('Komentarz do rekordu o ID ".$_GET['record_id']."','".$_SESSION['user_id']."','0');
";
if(mysqli_multi_query($conn, $sql)){
    echo "OK";
}

?>