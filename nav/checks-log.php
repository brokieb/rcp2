<style>
table{
    border-collapse:collapse;
}
td{
    border:1px solid black;
    padding:5px;
}
</style>
<?php
include("../conn.php");
$sql = "SELECT * FROM records WHERE `record_date`='".$_POST['date']."' AND `user_id`=".$_POST['id']." ORDER BY `record_id` ASC";

$result = mysqli_query($conn, $sql);
echo "<h1>logi użytkownika o ID ".$_POST['id']." z dnia ".$_POST['date']."</h1>";
while($row = mysqli_fetch_array($result)){
    if($row['record_status']=="OUT"){
        $css = "\/";
        $stat = "STOP";
    }else{
        $css = "/\\";
        $stat = "START ";
    }
    echo "<p >";
switch($row['record_type']){
    case 1:
        echo "${css} #".$row['record_id']." [".$row['record_time']."] ".$stat." PRACA ";
        break;
    case 2:
        echo "${css} #".$row['record_id']." [".$row['record_time']."] ".$stat." PRZERWA . ";
        break;
    case 3:
        echo "${css} #".$row['record_id']." [".$row['record_time']."] ".$stat." MAGAZYN . ";
        break;
}
echo "</p>";
}



$sql = "SELECT * FROM records_new WHERE `record_date`='".$_POST['date']."' AND `user_id`=".$_POST['id']." ORDER BY `record_id` ASC";

$result = mysqli_query($conn, $sql);
?>
<table >
    <thead>
        <tr>
            <td>EVENT</td>
            <td>WE KIEDY</td>
            <td>WY KIEDY</td>
            <td>WE UTWORZYŁ</td>
            <td>WY UTWORZYŁ</td>
            <td>WE GDZIE</td>
            <td>WY GDZIE</td>
        </tr>
    </thead>
    <tbody>



        <?php

while($row = mysqli_fetch_array($result)){
    ?>

        <tr>
            <td>
            <?php
            switch($row['record_event']){
                case '1':
                    echo "PRACA";
                    break;
                case '2':
                    echo "PRZERWA";
                    break;
                case '3':
                    echo "MAGAZYN";
                    break;
            }
            ?>
            </td>
            <td><?=$row['record_in_time']?></td>
            <td><?=$row['record_out_time']?></td>
            <td><?=$row['record_in_create']?></td>
            <td><?=$row['record_out_create']?></td>
            <td><?php
            switch($row['record_in_remote']){
                case '1':
                    echo "W SIECI";
                    break;
                case '2':
                    echo "ZDALNIE";
                    break;
                case '3':
                    echo "BEZ UPRAWNIEŃ";
                    break;
            }
            ?></td>
            <td><?php
            switch($row['record_out_remote']){
                case '0':
                    echo "BEZ UPRAWNIEŃ";
                    break;
                case '1':
                    echo "W SIECI";
                    break;
                case '2':
                    echo "ZDALNIE";
                    break;
                
            }
            ?></td>
        </tr>
        <?php
}
?>
    </tbody>
</table>
<?php




$sql = "SELECT * FROM logs WHERE `user_id`=".$_POST['id']." AND `log_occured` REGEXP '".$_POST['date']."'";
$result = mysqli_query($conn, $sql);
echo "<h1>logi systemowe</h1>";
while($row = mysqli_fetch_array($result)){
echo "<p>".$row['log_type']." | ".$row['log_occured']." | ".$row['log_value']."</p>";
}




echo "<h1>Policzono dzień z </h1>";

$sql2 = "SELECT * FROM `records` LEFT JOIN `accepted_days` ON `records`.user_id=`accepted_days`.user_id  AND `records`.`record_date`=`accepted_days`.`accept_date` WHERE `records`.`user_id`=".$_POST['id']." AND `record_date`='".$_POST['date']."' AND (`record_type`=1 OR `record_type`=0) ";


$result2 = mysqli_query($conn,$sql2);
$time_start_arr = [];
$time_stop_arr = [];
while($row2 = mysqli_fetch_array($result2)){
    if($row2['record_type']==1&&$i==0){
        $i=1;
        // $czas_start += $row2['record_time'];
        $czas_start += strtotime($row2['record_time']);
        $time_start_arr[] = $row2['record_time'];
    }
    if($row2['record_type']==0&&$i==1){
        $i=0;
        $czas_stop += strtotime($row2['record_time']);
        $time_stop_arr[] = $row2['record_time'];
    }
    $rids['rids'][] = $row2['record_id'];
    $accept_id = $row2['accept_id'];
    $accept_day = $row2['accept_date'];
    $accept_time = $row2['accept_hours'];
    $accept_type = $row2['accept_type'];
}


    $date1 = New dateTime(Date("H:i:s",$czas_start));
    $date2 = $date1->diff(New dateTime(Date("H:i:s",$czas_stop)));
    // echo ."X".$czas = $date2->h.":".$date2->i.":".$date2->s;
    $answer = $date2->format('%H:%I');
    $times[] = $answer;
    echo $sql = "SELECT * FROM `records` WHERE record_id IN (".implode(",",$rids['rids']).") ";
    $result2 = mysqli_query($conn,$sql2);
    ?>
<table>
    <thead>
        <tr>
            <td>ID</td>
            <td>TYP</td>
            <td>DATA</td>
            <td>GODZINA</td>
            <td>STATUS</td>
        </tr>
    </thead>
    <tbody>
        <?php
while($row2 = mysqli_fetch_array($result2)){
?>
        <tr>
            <td><?=$row2['record_id']?></td>
            <td><?=$row2['record_type']?></td>
            <td><?=$row2['record_date']?></td>
            <td><?=$row2['record_time']?></td>
            <td><?=$row2['record_status']?></td>
        </tr>
        <?php
}
?>
    </tbody>
</table>
<?php



czas_pracy($time_start_arr,$time_stop_arr);



?>