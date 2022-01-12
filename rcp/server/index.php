<?php
$conn = new mysqli("localhost","phpmyadmin","Damian#3","ecp");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

for($i = 3;$i>=1;$i--){
    echo $i;


    echo $sql = "SELECT * FROM records_new WHERE `record_out_time` IS NULL AND `record_event`='".$i."';";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)){


        echo $sql_status = "UPDATE `records_new` SET 
        `record_out_time`='".Date('H:i:s')."',
        `record_out_create`='0',
        `record_out_remote`='2'
        WHERE `record_id`='".$row['record_id']."';
           UPDATE users SET `user_status`='".($i-1)."' WHERE `user_id`='".$row['user_id']."';
           ";
           if(mysqli_multi_query($conn,$sql_status)){
               mysqli_next_result($conn);
           }


    }
}

//    $sql2 = "INSERT INTO records (`user_id`,`record_type`,`record_status`,`record_date`,`record_time`,`record_create`)
//     VALUES 
//     (
//         '".$row['user_id']."',
//         '".$row['user_status']."',
//         'OUT',
//         '".date('Y-m-d')."',
//         '".date('H:i:s')."',
//         '0'
//     ),
//     (
//         '".$row['user_id']."',
//         '0',
//         'IN',
//         '".date('Y-m-d')."',
//         '".date('H:i:s')."',

//         '0'
//     );
//     UPDATE `users` SET `user_status`='0' WHERE `user_id`='".$row['user_id']."';
//     ";
//     if(mysqli_multi_query($conn,$sql2)){
//        echo "<br>->OK<br>";
//        mysqli_next_result($conn);
//     }
// }
?>
