<?php
if($_POST['mode']==1){//próba logowania

   $sql = "
    SELECT * FROM users WHERE user_email = '".$_POST['email']."' LIMIT 1 ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
if(password_verify($_POST['pw'],$row['user_pass'])){
    if($row['user_privilage']!=NULL){
    $y = uniqid();
$x = password_hash($_SERVER['REMOTE_ADDR'].":".$y,PASSWORD_DEFAULT);

$sql2 = "
                SELECT * FROM `con_variables` WHERE `con_name`='device_limit' ";
                $result2 = mysqli_query($conn, $sql2);
                $settings = mysqli_fetch_array($result2,MYSQLI_ASSOC);
     $check = 0;
     $i = 0;
     $sql = "
                 SELECT * FROM user_session where user_id='" . $row['user_id'] . "' ORDER BY `user_session`.`session_id`";
     $result = mysqli_query($conn, $sql);
     while($session = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $i++;
        if($i>=$settings['con_value']||Date("Y-m-d H:i:s")>$settings['session_expired_in']){
            echo $sql3 = "DELETE FROM `user_session` WHERE `session_id`=".$session['session_id'];
            if(mysqli_query($conn,$sql3)){
                echo "OK";
            }
        }else{





        }

     }


     if($_POST['remember']==1){
        setcookie('hash', $x,  time()+86400*3);
    }



  echo $sql = "INSERT INTO `user_session` (`user_id`,`session_token`,`session_saved`,`session_expired_in`) VALUES (
       '".$row['user_id']."',
       '".$x."',
       '".$_POST['remember']."',
       NOW() + INTERVAL 3 DAY
   )";

    

    if(mysqli_query($conn, $sql)){
        $_SESSION["uid"] = $y;
        $_SESSION["user_id"] = $row['user_id'];
        $_SESSION['prv'] = $row['user_privilage'];
        header('Location: index.php');
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}else{
    $alert = 'closed-account';
}
}else{
    $alert = 'error-pw';
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
  
   
    
}




}else{
    include('login.php');
}

?>