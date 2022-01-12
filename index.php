<!DOCTYPE html>
<html lang="en">

<head>
    <?php
//define ver
$ver = '1.3.5';
define('MyConst', TRUE);
?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RCP -AAA Rejestracja Czasu Pracy</title>
    <link rel="icon" type="image/png" href="img/suitcase.png" />
    <link rel="stylesheet" href="style/libs/all.min.css?ver=<?=$ver?>">
    <link rel="stylesheet" href="style/libs/evo-calendar.min.css?ver=<?=$ver?>">
    <link rel="stylesheet" href="style/libs/mdb.min.css?ver=<?=$ver?>" />
    <link rel="stylesheet" href="style/main_new.css?ver=<?=$ver?>" />
    <!-- <link rel="stylesheet" href="style/main.css?ver=<?=$ver?>">
    <link rel="stylesheet" href="style/responsive.css?ver=<?=$ver?>"> -->
    <script src="js/libs/jquery-3.5.1.min.js?ver=<?=$ver?>"></script>
    <script src="js/libs/masonry.pkgd.min.js?ver=<?=$ver?>"></script>
    <script src="js/libs/moment.js?ver=<?=$ver?>"></script>
    <script src="js/libs/canvasjs.min.js?ver=<?=$ver?>"></script>
    <script src="js/libs/jquery-ui.min.js?ver=<?=$ver?>"></script>
    <script src="js/libs/evo-calendar.js?ver=<?=$ver?>"></script>

</head>

<body>
    <?php
include('conn.php');

if(isset($_SESSION['uid'])){
        $sql = "
        SELECT * FROM users where user_id='" . $_SESSION['user_id'] . "' LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_array($result);
if(!empty($user)){
    include('nav.php');
    include('main.php');
}else{
    session_destroy();
}

}else{
    if(isset($_COOKIE['hash'])){
       echo $sql = "SELECT * FROM `user_session` INNER JOIN `users` ON `user_session`.`user_id`=`users`.`user_id` WHERE `session_token`= '".$_COOKIE['hash']."' AND `session_expired_in`>'".Date('Y-m-d H:i:s')."' ";
        $result = mysqli_query($conn, $sql);
        $cookies_user = mysqli_fetch_array($result,MYSQLI_ASSOC);
    }    
    include('session_init.php');
}






if(isset($_POST['mode'])){

switch($_POST['mode']){
    case 2:
        $sql = "INSERT INTO users (`user_email`,`user_pass`,`user_privilage`,`user_name`,`user_abs_prv`)
        VALUES 
        (
            '".$_POST['email']."',
            '".password_hash($_POST['pw'], PASSWORD_DEFAULT)."',
            '".$_POST['prv']."',
            '".$_POST['imie']."',
            '".$_POST['absolute-prv']."'
        )";
        if(mysqli_query($conn, $sql)){

        echo '<script type="text/javascript">';
        echo 'alert("Dodano pracownika poprawnie!");';
        echo 'window.location.href = "index.php"';
        echo '</script>';
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
        break;
        case 3:
            if(!empty($_POST['npw'])){
                if($_POST['npw']==$_POST['rnpw']){

                    $sql = "
                    UPDATE `users` SET `user_name` = '".$_POST['imie']."',`user_pass`= '".password_hash($_POST['npw'], PASSWORD_DEFAULT)."' WHERE `users`.`user_id` = ".$row['user_id'].";
                    ";
                    if(mysqli_query($conn, $sql)){

                        echo '<script type="text/javascript">';
                        echo 'alert("Poprawnie zaktualizowano dane!");';
                        echo 'window.location.href = "index.php?site=activity"';
                        echo '</script>';
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                        }
                }else{
                    echo "hasła nie są takie same";
                    }

                }else{
            $sql = "
        UPDATE `users` SET `user_name` = '".$_POST['imie']."' WHERE `users`.`user_id` = ".$row['user_id'].";
        ";
        if(mysqli_query($conn, $sql)){

            echo '<script type="text/javascript">';
            echo 'alert("Poprawnie zaktualizowano dane!");';
            echo 'window.location.href = "index.php?site=activity"';
            echo '</script>';
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
    }
            
            break;
            case 4://date('Y-m-d')

                echo $sql_check = "SELECT `record_id`,`record_date` FROM `records_new` WHERE `user_id`=".$_POST['id']." AND `record_out_time` IS NULL LIMIT 1 ";
                $result_check = mysqli_query($conn, $sql_check);
                $row_check = mysqli_fetch_array($result_check,MYSQLI_ASSOC);
                echo $sql_status = "UPDATE `records_new` SET 
                 `record_out_time`='".Date('H:i:s')."',
                 `record_out_create`='".$_SESSION['user_id']."'
                 WHERE `record_id`='".$row_check['record_id']."';
                    UPDATE users SET `user_status`='0' WHERE `user_id`='".$_SESSION['user_id']."';
                    INSERT INTO `logs`( `log_value`, `user_id`, `log_type`) VALUES ('Manualnie zakończono dzień ".$row_check['record_date']." użytkownikowi ".$_POST['id']."','".$_SESSION['user_id']."','0');
                    ";
                    if(mysqli_multi_query($conn,$sql_status)){
                        // echo '<script type="text/javascript">';
                        // echo 'alert("Poprawnie zakończono pracę u pracownika");';
                        // echo 'window.location.href = "index.php?site=mod"';
                        // echo '</script>';
                    }
                break;
                case 5:
                   $sql = "UPDATE `records` LEFT JOIN accepted_days ON records.user_id=accepted_days.user_id AND records.record_date=accepted_days.accept_date SET `record_comment`=CONCAT(`record_comment`,' ".$_POST['komentarz']."') WHERE records.user_id='".$_SESSION['user_id']."' AND accept_id IS NULL AND record_date='".$_POST['date']."'";
                   if(mysqli_query($conn, $sql)){
                    echo '<script type="text/javascript">';
                    echo 'alert("Poprawnie zaktualizowano komentaz");';
                    echo 'window.location.href = "index.php?site=activity"';
                    echo '</script>';
                   }
                   break;
                case 6:
                    if($_POST['prv']=="NULL"){
                        $sql = "UPDATE `users` SET user_privilage=NULL WHERE user_id='".$_POST['id']."'";
                    }else{
                        $sql = "UPDATE `users` SET user_privilage='".$_POST['prv']."' WHERE user_id='".$_POST['id']."'";
                    }
                    if(mysqli_query($conn, $sql)){
                        echo '<script type="text/javascript">';
                        echo 'alert("Poprawnie zmieniono uprawnienia");';
                        echo 'window.location.href = "index.php?site=admin"';
                        echo '</script>';
                       }
                    break;
                case 7:
                    if($_POST['npw']==$_POST['rnpw']){

                        $sql = "
                        UPDATE `users` SET `user_pass`= '".password_hash($_POST['npw'], PASSWORD_DEFAULT)."' WHERE `users`.`user_id` = ".$_POST['id'].";
                        ";
                        if(mysqli_query($conn, $sql)){
    
                            echo '<script type="text/javascript">';
                            echo 'alert("Poprawnie zaktualizowano dane!");';
                            echo 'window.location.href = "index.php?site=admin"';
                            echo '</script>';
                            } else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }
                    }else{
                        echo "hasła nie są takie same";
                        }
                    break;
                case 8:
                    $sql = "
                    UPDATE `accepted_days` SET `accept_comment`=CONCAT(`accept_comment`,'".$_POST['komentarz']."') WHERE `accept_id`=".$_POST['id'];
                    if(mysqli_query($conn, $sql)){
    
                        echo '<script type="text/javascript">';
                        echo 'alert("Poprawnie zaktualizowano dane!");';
                        echo 'window.location.href = "index.php?site=calendar"';
                        echo '</script>';
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                        }
                    break;
                case 9:
                   echo $sql = "INSERT INTO `absent` (`user_id`,`abs_from`,`abs_to`,`abs_comment`) VALUES (
                        '".$_SESSION['user_id']."',
                        '".$_POST['from']."',
                        '".$_POST['to']."',
                        '".$_POST['comment']."'
                    )";
                    if(mysqli_query($conn, $sql)){
    
                        echo '<script type="text/javascript">';
                        echo 'alert("Poprawnie wyslano informacje o planowanej nieobecności");';
                        echo 'window.location.href = "index.php?site=calendar"';
                        echo '</script>';
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                        }
                    break;
                case 10:
                     $sql = "
                    UPDATE `users` SET `user_avatar`='".$_POST['cat']."' WHERE `user_id`=".$_SESSION['user_id'];
                    if(mysqli_query($conn, $sql)){
    
                        echo '<script type="text/javascript">';
                        echo 'alert("Poprawnie zaktualizowano avatar!");';
                        echo 'window.location.href = "index.php?site=profile"';
                        echo '</script>';
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                        }
                    break;
                case 11:
                    $_SESSION["uid"] = $cookies_user['session_token'];
                    $_SESSION["user_id"] = $cookies_user['user_id'];
                    $_SESSION['prv'] = $cookies_user['user_privilage'];
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "index.php"';
                        echo '</script>';
                    break;



}


}


?>

    <div class='user-info'></div>
    <footer>
        <?php include('footer.php') ?>
    </footer>
</body>
<?php
if(isset($_GET['user'])){
    ?>
<input type='hidden' name='user-desc' value='<?=$_GET['user']?>'>
<?php
    }
?>
<div style='display:none' class="styles" data-ver='<?=$ver?>'>
    <script id="main_js" src="js/main.js?ver=<?=$ver?>"></script>
    <script id="ajax_js" src="js/ajax.js?ver=<?=$ver?>"></script>
    <script id="user_details_js" src="js/user-details.js?ver=<?=$ver?>"></script>
    <script id="mdb_min_js" src="js/libs/mdb.min.js"></script>
</div>


</html>