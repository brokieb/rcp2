<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EKSPORT</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
require_once("../conn.php");
?>
    <div class='config'>
    </div>
    <?php
foreach($_POST['ids'] as $z){
    $sql = "SELECT * FROM `users` LEFT JOIN `accepted_months` ON `users`.`user_id`=`accepted_months`.`accept_m_user_id` WHERE user_id=".$z;
    $result = mysqli_query($conn, $sql);
    $row2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $sql = "SELECT * FROM `accepted_days` LEFT JOIN  `add_time` ON `accepted_days`.`addtime_id`=`add_time`.`addtime_id` WHERE `user_id`=".$z." AND `accept_date` REGEXP '".$_POST['month']."' ";
    $result = mysqli_query($conn, $sql);
    $praca = [];
    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        
$godzinki = $row['accept_hours'];
$pyt = [];
switch($row['znak']){
    case '0':
        $pyt[] = $godzinki;
        $pyt[] = $row['addtime_time'];
        $godzinki = minusTimes($pyt);
        break;
    case '1':
            $pyt[] = $godzinki;
            $pyt[] = $row['addtime_time'];
            $godzinki =  addTime($pyt);
        break;
}
$praca[] = $godzinki;
    }

    ?>
    <div class='page'>
        <div style='display:flex;justify-content:space-between'>
            <p>Twój kod potwierdzenia: <?=$rand = rand(10000,99999)?></p>
            <p>Wygenerowano <?=Date('Y-m-d H:m:i')?> przez rcp.o4s.pl</p>
        </div>
        <h1>Potwierdzenie miesięcznych godzin dla pracownika <?=implode(" ",createName($row2['user_email']))?></h1>
        <h2>za miesiąc Marzec 2021 roku.</h2>
        <span class='tresc'>Potwierdzam zarejestrowaną ilość godzin w miesiącu przez System Rejestracji Czasu pracy
            wynoszący
            <?php
        if($_POST['wyrownaj'][$z]){
            ?>
            <b><?=$wynik = $_POST['wyrownaj'][$z]?> h</b></span>
            <?php
        }else{
           
?>
            <b><?=$wynik = substr(AddTimeTest($praca), 0, -3);?> h</b></span>
        <?php
        }
        ?>

        <div class='podpisy'>
            <div class='podpis1 podpis'>
                <h3>Pracodawca</h3>
                <span class='kropki-podpis'>. . . . . . . . . . . . . . . . . . . . . . . </span>
            </div>
            <div class='podpis1 podpis'>
                <h3>Pracownik</h3>
                <span class='kropki-podpis'>. . . . . . . . . . . . . . . . . . . . . . . </span>
            </div>
        </div>

    </div>
    <?php
    if($row2['accept_m_id']==NULL){
       $sql = "INSERT INTO `accepted_months`( `accept_m_user_id`, `accept_month`, `accept_m_hours`, `accept_m_code`, `accept_m_status`) VALUES (
            ".$z.",
            '".$_POST['month']."-01',
            '".$wynik.":00:00',
            '".$rand."',
            '1'
            )
        ";
        if(mysqli_query($conn,$sql)){
            
        }
    }else{
      
    }
  
}
?>
</body>

</html>