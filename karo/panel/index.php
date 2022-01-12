<!DOCTYPE html>
<html lang="en">
<?php
$ver = 1;
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/libs/all.min.css?ver=<?=$ver?>">
    <link rel="stylesheet" href="../style/libs/evo-calendar.min.css?ver=<?=$ver?>">
    <link rel="stylesheet" href="../style/libs/mdb.min.css?ver=<?=$ver?>"/>
    <link rel="stylesheet" href="../style/main_new.css?ver=<?=$ver?>"/>
    <!-- <link rel="stylesheet" href="style/main.css?ver=<?=$ver?>">
    <link rel="stylesheet" href="style/responsive.css?ver=<?=$ver?>"> -->
    <script src="../js/libs/jquery-3.5.1.min.js?ver=<?=$ver?>"></script>
    <script src="../js/libs/masonry.pkgd.min.js?ver=<?=$ver?>"></script>
    <script src="../js/libs/moment.js?ver=<?=$ver?>"></script>
    <script src="../js/libs/canvasjs.min.js?ver=<?=$ver?>"></script>
    <script src="../js/libs/jquery-ui.min.js?ver=<?=$ver?>"></script>
    <script src="../js/libs/evo-calendar.js?ver=<?=$ver?>"></script>
</head>

<body>
<?php
$sql = "SELECT * FROM `users` WHERE `user_id`='".$_SESSION['user_id']."' ";
$query = mysqli_query($conn,$sql);
$user = mysqli_fetch_array($query,MYSQLI_ASSOC);
?>
    <div class='nav'>
    <?php
include('nav.php');
    ?>
        <!-- <div class='space-around'>
            <div class='col-12  blur'>
                <ul class='nav-list'>
                    <li><a href='#' id='new-instance'>Nowa usługa</a></li>
                    <li><a href='#' id='offers'>Zarządzanie ofertami</a></li>
                    <li><a href='#' id='contact'>Kontakt</a></li>
                    <li><a href='destroy.php'>Wyloguj się</a></li>
                    <li><?=$user['user_email']?></li>

                </ul>
            </div>
        </div> -->
    </div>
    <div class='content'>
        <div class='space-around'>
            <div class='col-3  blur active-services'>
                <h2>Stan aktywnych usług</h2>
                <?php
$sql = "SELECT * FROM `instances` INNER JOIN `offers` ON `instances`.`offer_id`=`offers`.`offer_id` WHERE `user_id`='".$_SESSION['user_id']."' ";
$query = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
    ?>
                <div class='outer-this-service'>
                    <div class='this-service' data-instance='<?=$row['instance_name']?>'>
                        <h3>RCP@<?=$row['instance_name']?></h3>
                        <ul>
                            <li><span>Kod pakietu </span><strong> <?=$row['offer_id']?></strong></li>
                            <li><span>Zarejestrowani użytkownicy </span><strong> 3/<?=$row['offer_max-users']?></strong>
                            </li>
                            <li><span>IP w białej liście </span><strong> 3/<?=$row['offer_max-ip']?></strong></li>
                            <li><span>Ważność </span><strong><?=$row['instance_expired-in']?></strong></li>
                        </ul>
                    </div>
                </div>

                <?php
}
            ?>
            </div>
            <div class='col-9  blur' id='content'>
                #content
            </div>
        </div>
    </div>
    <div class='footer'>
    
    </div>




</body>

</html>