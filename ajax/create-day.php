<?php
include('default.php');
$sql = "INSERT INTO `accepted_days`(`user_id`, `accept_date`, `accept_hours`, `accept_mod`, `accept_calculated-from`,`accept_type`) VALUES (
    '".$_GET['id']."',
    '".$_GET['data']."',
    '".$_GET['czas']."',
    '".$_SESSION['user_id']."',
    'MAN',
    '1'
    );
    INSERT INTO `logs`( `log_value`, `user_id`, `log_type`) VALUES ('Utworzył manualnie dzień dla użytkownika o ID ".$_GET['id']."','".$_SESSION['user_id']."','0');
";
    if(mysqli_multi_query($conn, $sql)){
        echo '{"ans":"OK"}';
        }
?>