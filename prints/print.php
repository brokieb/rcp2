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
include("../conn.php");
?>
    <div class='config'>
    </div>
    <?php
    $times = [];
foreach($_POST['ids'] as $z){


    $sql = "SELECT * FROM `users` LEFT JOIN `accepted_months` ON `users`.`user_id`=`accepted_months`.`accept_m_user_id`AND `accepted_months`.`accept_month`='".$_POST['month']."-01' WHERE user_id=".$z;
    $result = mysqli_query($conn, $sql);
    $row2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
$sql = "SELECT * FROM `accepted_days` LEFT JOIN add_time ON `add_time`.`accept_id`=`accepted_days`.`accept_id` WHERE `user_id`=".$z." AND DATE_FORMAT(`accept_date`,'%Y-%m')='".$_POST['month']."' AND accept_type=1 ";
    $result = mysqli_query($conn, $sql);
    $praca = [];
    $times = [];
    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $plus = [];
        if($row['addtime_id']!=NULL){
        switch($row['znak']){
             case '0':
                 $plus[] = $row['accept_hours'];
                 $plus[] = $row['addtime_time'];
                  $this_czas  = minusTimes($plus);//minus
                  $times[]  = $this_czas;
             break;
             case '1':
                 $plus[] = $row['accept_hours'];
                 $plus[] = $row['addtime_time'];
                 $this_czas = addTime($plus);
                 $times[]  = $this_czas;
             break;
             default:
             $this_czas = $row['accept_hours'];
                $times[]  = $this_czas;
             break;
        }
        }else{
         $this_czas = $row['accept_hours'];
         $times[]  = $row['accept_hours'];
        }
    }

    ?>
    <div class='page'>
        <div style='display:flex;justify-content:space-between'>
            <p>Twój kod potwierdzenia: <?=$rand = rand(10000,99999)?></p>
            <p>Wygenerowano <?=Date('Y-m-d H:m:i')?> przez rcp.o4s.pl</p>
        </div>
        <h1>Potwierdzenie miesięcznych godzin dla pracownika <?=implode(" ",createName($row2['user_email']))?></h1>
        <h2>za miesiąc <?=$_POST['month']?>.</h2>
        <span class='tresc'>Potwierdzam zarejestrowaną ilość godzin w miesiącu przez System Rejestracji Czasu pracy
            wynoszący
            <?php
        if($_POST['wyrownaj'][$z]){
            ?>
            <b><?=$wynik = $_POST['wyrownaj'][$z]?> h</b></span>
        <?php
        }else{
            $wynik = AddTimeTest($times);
?>
        <b><?=explode(":",$wynik)[0]?> h</b></span>
        <?php
        }
        ?>

        <div class='podpisy'>
            <div class='podpis1 podpis'>
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