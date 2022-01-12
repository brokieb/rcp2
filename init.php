<?php

//sprawdzanie czy sesja jest już aktywna
if(isset($_POST['pw'])){
echo $sql = "SELECT `user_pass` FROM `users` WHERE `user_email` = ".$_POST['emil'];
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

    if(password_verify($_POST['pw'],$row['user_pass'])==1){

    }else{
        echo "złe hasło";
    }


}



//sprawdzanie podanego loginu i hasła

print_r($_SESSION);
echo "</br>";
print_r($_COOKIE);
?>
