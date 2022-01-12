<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>
<main class='wall'>
<section>
<h1>Twoje nie potwierdzone godziny pracy</h1>
<div class='table-p'>
<table>
<thead>
<tr>
<td>Dzień </td>
<td>Ilość godzin</td>
<td>Komentarz</td>
</tr>
</thead>
<tbody>


<?php
$sql2 = "SELECT * FROM `records` LEFT JOIN accepted_days ON records.user_id=accepted_days.user_id AND records.record_date=accepted_days.accept_date WHERE records.`user_id`=".$_SESSION['user_id'] ." AND record_date!=CURDATE() AND accept_id IS NULL GROUP BY record_date" ;
$result2 = mysqli_query($conn, $sql2);
while($row2 = mysqli_fetch_array($result2)){


$sql = "SELECT *  FROM `records` WHERE records.`user_id`=".$_SESSION['user_id'] ." AND record_date='".$row2['record_date']."' AND (`record_type`=1 OR `record_type`=0)";
$result = mysqli_query($conn, $sql);
$j = 0;
$czas_start =[];
$czas_stop =[];

while($row = mysqli_fetch_array($result)){

    if($row['record_type']==1&&$j==0){
        $j=1;
        // $czas_start += $row2['record_time'];
        $czas_start []= $row['record_time'];
    }
    if($row['record_type']==0&&$j==1){
        $j=0;
        $czas_stop[]= $row['record_time'];
    }



}

?>
<tr>
<td><?=$row2['record_date']?></td>
<td><?=czas_pracy($czas_start,$czas_stop)?></td>

<td>
<form method='post'>
<input type='text' name='komentarz' value='<?=$row2['record_comment']?>'>
<input type='hidden' name='mode' value='5'>
<input type='hidden' name='date' value='<?=$row2['record_date']?>'>
<button>Aktualizuj</button>
</form>
</td>


</tr>

<?php



}
?>
</tbody>
</table>
</div>
</section>
<section>
<h1>Potwierdzone dni pracy</h1>
<div class='table-p'>
<table>
<thead>
<tr>
<td>Data</td>
<td>Ilość godzin</td>
<td>Komentarz</td>
</tr>
</thead>
<tbody>
<?php

$sql = "SELECT * FROM `accepted_days` LEFT JOIN add_time ON `accepted_days`.accept_id=`add_time`.accept_id WHERE `user_id`=".$_SESSION['user_id']." ORDER BY accept_date ASC";
$result = mysqli_query($conn, $sql);
$dni_pracy=0;
$times = [];
while($row = mysqli_fetch_array($result)){
    $sum = [];
    $sum[] = $row['accept_hours'];
    $sum[] = $row['addtime_time'];
?>
<tr>
    <td><?=$row['accept_date']?></td>
    <td><?=addTime($sum)?></td>
    <td><?=$row['accept_comment']?></td>
</tr>
<?php
$dni_pracy++;
$times[] = $row['accept_hours'];
}
?>
</tbody>
</table>
<p>Aktualnie zliczone godziny pracy <b><?=AddTime($times)?></b></p>
<p>Nie jest to wynik końcowy, zależny od twojej wypłaty</p>
<input type='hidden' name='dni' value='<?=$dni_pracy?>'>
</div>


</section>
<section>
    <h1>Aktualizacja danych</h1>
    <?php
    $sql = "SELECT * FROM `users` WHERE user_id = '".$_SESSION['user_id']."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
?>
    <form method='POST'>
        <label for='imie'>Twoje wyświetlane imie</label>
        <input type='text' name='imie' value='<?=$row['user_name']?>'>
        <label for='npw'>Nowe hasło</label>
        <input type='password' name='npw' >
        <label for='rnpw'>powtórz nowe hasło</label>
        <input type='password' name='rnpw'>
        <input type='hidden' name='mode' value='3'>
        <button>Aktualizuj swoje dane</button>
    </form>
    </section>
    <section>
    <script>
window.onload = function() {
var przepracowane = $("input[name=dni]").val();
var month = new Date().getMonth()+1;
var workingDays = {1:19,
2:20,
3:23,
4:21,
5:19,
6:21,
7:22,
8:22,
9:22,
10:21,
11:20,
12:22
}
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	exportEnabled: false,
	animationEnabled: true,
	title: {
		text: "Statystyki miesięczne"
	},
	data: [{
		type: "doughnut",
		startAngle: 25,
		toolTipContent: "<b>{label}</b>: {y} dni",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - {y} dni",
        responsive: "false",
		dataPoints: [
			{ y: przepracowane, label: "Przepracowane" },
            { y: workingDays[month]-przepracowane, label: "Pozostało dni pracujących" }
		]
	}]
});
chart.render();

}
</script>
<div id="chartContainer" style="width:100%"></div>
    </section>
    </main>