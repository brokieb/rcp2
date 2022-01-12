<!DOCTYPE html>
<html lang="en">

<head>
    <?php
//define ver
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$ver = '1.2.4';
?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RCP - Inicjaltor instancji</title>
    <link rel="icon" type="image/png" href="img/suitcase.png" />
    <!-- <link rel="stylesheet" href="style/main.css?ver=<?=$ver?>">
        <link rel="stylesheet" href="style/responsive.css?ver=<?=$ver?>"> -->
    <link rel="stylesheet" href="style/libs/mdb.min.css?ver=<?=$ver?>" />
    <link rel="stylesheet" href="style/main_new.css?ver=<?=$ver?>" />

</head>

<body>
    <?php
include('conn.php'); 
print_r($_POST);
print_r($_SESSION);
if(isset($_SESSION['uid'])){
    if(password_verify($_SERVER['REMOTE_ADDR'].":".$_SESSION['uid']."_". $_SESSION['user_id'] , $_COOKIE['device'] ) ){
    include('init.php');
    }else{
    include('destroy.php');
    }
}else{
    if($_POST['mode']=='1'){
    include('session_init.php');
}

    include('init.php');
}
?>
    <script src="js/libs/jquery-3.5.1.min.js?ver=<?=$ver?>"></script>
    <script src="js/libs/mdb.min.js?ver=<?=$ver?>"></script>
    <script src="js/ajax.js?ver=<?=$ver?>"></script>
</body>

</html>