<?php
echo "X";
if($_POST['mode']==1){//próba logowania

   $sql = "
    SELECT * FROM users WHERE user_email = '".$_POST['email']."' LIMIT 1 ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
if(password_verify($_POST['pw'],$row['user_pass'])){
    echo "HASŁO OK!";
    $y = uniqid();
$x = $_SERVER['REMOTE_ADDR'].":".$y;
$hash = password_hash($x, PASSWORD_DEFAULT);
if(!isset($_COOKIE['device'])){
    setcookie('device', $hash,  time()+86400);
}





$x = $_SERVER['REMOTE_ADDR'] . ":" . $_SESSION['uid'];

$sql2 = "
                SELECT * FROM `con_variables` WHERE `con_name`='device_limit' ";
                $result2 = mysqli_query($conn, $sql2);
                $settings = mysqli_fetch_array($result2,MYSQLI_ASSOC);
     $check = 0;
     $i = 0;
     echo $sql = "
                 SELECT * FROM user_session where user_id='" . $row['user_id'] . "' ORDER BY `user_session`.`session_id`";
     $result = mysqli_query($conn, $sql);
     while($session = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $i++;
        if($i>=$settings['con_value']){
            echo $sql3 = "DELETE FROM `user_session` WHERE `session_id`=".$session['session_id'];
            if(mysqli_query($conn,$sql3)){
                echo "OK";
            }
        }else{





        }

     }
     print_r($session);






  echo $sql = "INSERT INTO `user_session` (`user_id`,`session_token`,`session_expired_in`) VALUES (
       '".$row['user_id']."',
       '".$hash."',
       NOW() + INTERVAL 1 DAY
   )";
//     $sql2 = "SELECT user_email FROM users WHERE `user_last-device`='".$_COOKIE['device']."' AND `user_id`<>".$row['user_id']."";
//     $result = mysqli_query($conn, $sql2);
// $row2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
// if(!empty($row2)){

//     $sql3 = "INSERT INTO logs (`user_id`,`log_type`,`log_value`)
// VALUES
// (
// '".$row['user_id']."',
// '1',
// 'Użytkownik logując się, użył ciastka użytkownika ".$row2['user_email']."'
// )";
// mysqli_query($conn, $sql3);
// }
    

    if(mysqli_query($conn, $sql)){
        $_SESSION["uid"] = $y;
        $_SESSION["user_id"] = $row['user_id'];
        $_SESSION['prv'] = $row['user_privilage'];
        header('Location: index.php');
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}else{
    include('login.php');
    $sql2 = "SELECT user_id FROM users WHERE user_email='".$_POST['email']."'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);
    if(!empty($row2)){
        $sql = "INSERT INTO logs (log_value,log_type,user_Id) VALUES (
            'Nastąpiła próba logowania na konto',
            '0',
            '".$row2['user_id']."'
            )";
        mysqli_query($conn, $sql);
    }
    echo "<p class='center'>Nieprawidłowy login lub hasło</p>";
   
    
}




}else{
    include('login.php');
}

?>