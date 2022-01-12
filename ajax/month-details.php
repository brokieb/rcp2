
<?php
include('default.php');
function AddTime($times) {
    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
    // loop throught all the times
    foreach ($times as $time) {
        list($hour, $minute) = explode(':', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }

    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    // returns the time already formatted
    return sprintf('%02d:%02d', $hours, $minutes);
}

$sql = "SELECT * FROM `records` WHERE `user_id`=".$_SESSION['user_id']." AND DATE_FORMAT(`record_date`,'%m')='".$_GET['monthe']."' GROUP BY `record_date` ORDER BY record_date DESC";
$result = mysqli_query($conn, $sql);

$czas_start = 0;
$czas_stop = 0;
$date = 0;
$status ="";
$podsumowanie = 0;
$times = [];
?>
<table>
<tr>
<td>Data</td>
<td>Czas pracy</td>

<?php
if(date('m')==$_GET['monthe']){
    echo "<td>";
    echo "Twoje Uwagi";
    echo "</td>";
}
?>
</tr>

<?php
while($row = mysqli_fetch_array($result)){
    $czas_start = 0;
    $czas_stop = 0;
    $i=0;
echo "<tr><td>".$row['record_date']."</td>";
$sql2 = "SELECT * FROM `records`  WHERE `user_id`=".$_SESSION['user_id']." AND `record_date`='".$row['record_date']."' AND (`record_type`=1 OR `record_type`=0) ";
$result2 = mysqli_query($conn,$sql2);
while($row2 = mysqli_fetch_array($result2)){
    
    if($row2['record_type']==1&&$i==0){
        $i=1;
        // $czas_start += $row2['record_time'];
        $czas_start += strtotime($row2['record_time']);
    }
    if($row2['record_type']==0&&$i==1){
        $i=0;
        $czas_stop += strtotime($row2['record_time']);
    }
    // echo "   XXX  ".$czas_start;

}
echo "<td>";
if($i==1){
    echo "NIE ZAKONCZONE!";
}else{
    $date1 = New dateTime(Date("H:i:s",$czas_start));
    $date2 = $date1->diff(New dateTime(Date("H:i:s",$czas_stop)));
    // echo ."X".$czas = $date2->h.":".$date2->i.":".$date2->s;
    echo $answer = $date2->format('%H:%I');
    $times[] = $answer;
    print_r($times);
    

}

echo "</td>";


if(date('m')==$_GET['monthe']){
    ?>
<td>
    <input type='text' name='content-comment' value='<?=$row['record_comment']?>'>
    <button class='add-comment' data-record-id='<?=$row['record_id']?>'>Dodaj uwagę</button>
</td>

<?php
}


echo "</tr>";
}
echo "</table>";

echo "przepracowane w tym miesiącu : ".addTime($times);
?>