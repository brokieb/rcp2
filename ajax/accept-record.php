<?php
include('default.php');
$sql = "SELECT * FROM `records_new` WHERE record_id IN (".substr(json_encode($_GET['content']['rids']),1,-1).") AND user_id='".$_GET['content']['uid']."' AND `record_event`=1";
$result = mysqli_query($conn,$sql);  
$praca = [];
$ids = [];
while($row = mysqli_fetch_array($result)){
$rids['rids'][] = $row['record_id'];
$date = $row['record_date'];
$comment = $row['record_comment'];
$praca[] = timeDiff($row['record_in_time'],$row['record_out_time']);
}
        $sql = "INSERT INTO accepted_days (`user_id`,`accept_date`,`accept_hours`,`accept_mod`,`accept_calculated-from`,`accept_comment`,`accept_type`)
        VALUES 
        (
            '".$_GET['content']['uid']."',
            '".$date."',
            '".addTime($praca)."',
            '".$_SESSION['user_id']."',
            '".json_encode($_GET['content']['rids'])."',
            '".$comment." <b><i>".$_GET['comment']."</i></b>"."',
            '1'
        );
        INSERT INTO `logs`( `log_value`, `user_id`, `log_type`) VALUES ('Zaakceptował dzień użytkownika ".$_GET['content']['uid']."','".$_SESSION['user_id']."','0');

";


if(mysqli_multi_query($conn, $sql)){
echo "OK";
}else{
echo "BLAD";
}
?>