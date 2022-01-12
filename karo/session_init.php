<?php
//próba logowania
 echo $sql = "
    SELECT * FROM users WHERE user_email = '".$_POST['email']."' LIMIT 1 ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
if(password_verify($_POST['pw'],$row['user_pass'])){
    echo "HASŁO OK!";
     $i = 0;
     $sql = "
                 SELECT * FROM user_session where user_id='" . $row['user_id'] . "' ORDER BY `user_session`.`session_id`";
     $result = mysqli_query($conn, $sql);
     while($session = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $i++;
        if($i>=5){
            $sql3 = "DELETE FROM `user_session` WHERE `session_id`=".$session['session_id'];
            if(mysqli_query($conn,$sql3)){
                echo "OK";
            }
        }else{





        }

     }
    


$y = uniqid();
$x = $_SERVER['REMOTE_ADDR'].":".$y."_".$row['user_id'];
$hash = password_hash($x, PASSWORD_DEFAULT);


  echo $sql = "INSERT INTO `user_session` (`user_id`,`session_token`,`session_expired_in`) VALUES (
       '".$row['user_id']."',
       '".$hash."',
       NOW() + INTERVAL 1 DAY
   )";   

    if(mysqli_query($conn, $sql)){
        echo "WCZYTANOO!!!0";
            

        setcookie('device', $hash,  time()+86400);
        $_SESSION["uid"] = $y;
        $_SESSION["user_id"] = $row['user_id'];
        $_SESSION['prv'] = $row['user_privilage'];
        header('Location: index.php');
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}else{
    $alert ="<p class='center'>Nieprawidłowy login lub hasło</p>";
   
    
}

?>