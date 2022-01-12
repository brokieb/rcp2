<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>
<main class='wall'>
    <?php

?>
    <section>
        <h1>Akceptowanie połączeń IP</h1>
        <?php
$realIP = $_SERVER['REMOTE_ADDR'];
?>
        <h2>Twoje aktualne IP: <?=$realIP?> </h2>
        <h3>Praca na miejscu tylko z adresów: </h3>
        <table>
            <thead>
                <tr>
                    <td>id</td>
                    <td>Adres</td>
                    <td>Usuń</td>
                </tr>
            </thead>
            <tbody>


                <?php
$sql = "SELECT * FROM con_accepted_ip";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result)){
?>
                <tr>
                    <td><?=$row['con_accept_ip_id']?></td>
                    <td><?=$row['con_accept_ip_ip']?></td>
                    <td>
                    <form>
                    <button form='x' class='fas fa-trash-alt remove-address' data-id='<?=$row['con_accept_ip_id']?>'></button>
                    </form>
                    </td>
                    
                </tr>

                <?php
}
?>
                <tr>
                    <td colspan='3'>
                        <form method='post'>
                            <input type='text' name='new-address'>
                            <button form='x' class='add-new-address far fa-check-circle' ></button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <section>
    <h1>Konfiguracja</h1>
    <table>
    <thead>
    <tr>
    <td>ID</td>
    <td>Status</td>
    <td>Wartość</td>
    </tr>
    </thead>
    <tbody>
    <?php
$sql = "SELECT * FROM `con_variables`";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result)){
?>
<tr>
<td><?=$row['con_id']?></td>
<td><?=$row['con_name']?></td>
<td>
<form method='get'>
<input type='hidden' name='status' value='<?=$row['con_id']?>'>
<input type='number' name='new' value='<?=$row['con_value']?>' min='1' max='999'>
<button form='x' class='set-config'>Ustaw</button>
</form>
</td>
</tr>

<?php
}
    ?>
    </tbody>
    </table>

    </section>
    <section>
    <h1>Debugowanie zepsutych dni</h1>
    <table>
    <thead>
    <tr>
    <td>Dzień</td>
    <td>Użytkownik</td>
    <td>Praca</td>
    <td>Przerwa</td>
    <td>Magazyn</td>
    <td>Napraw</td>
    </tr>
    </thead>
    <tbody>
    
    
    <?php
$sql = "SELECT * FROM `records` LEFT JOIN users ON `records`.user_id=`users`.user_id WHERE `record_date`<>'".Date('Y-m-d')."' GROUP BY `records`.user_id,record_date ORDER BY record_date DESC";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result)){
    $czas_start = [];
    $czas_stop = [];    
    $i = 0;

$sql2 = "SELECT * FROM `records` WHERE (`record_type`=1 OR `record_type`=0) AND `record_date`='".$row['record_date']."' AND `user_id`='".$row['user_id']."'";

$result2 = mysqli_query($conn,$sql2);
while($row2 = mysqli_fetch_array($result2)){
    if($row2['record_type']==1&&$i==0){
        $i=1;
        $czas_start[] = $row2['record_time'];
    }
    if($row2['record_type']==0&&$i==1){
        $i=0;
        $czas_stop[] = $row2['record_time'];
    }
}


$sql2 = "SELECT * FROM `records` WHERE `record_type`=2 AND `record_date`='".$row['record_date']."' AND `user_id`='".$row['user_id']."'";
$result2 = mysqli_query($conn,$sql2);
$x=0;
$przerw_start = [];
$przerw_stop = [];
while($row2 = mysqli_fetch_array($result2)){
if($row2['record_status']=='IN'){
    $x=1;
    // $czas_start += $row2['record_time'];
    $przerw_start[]= $row2['record_time'];
}
if($row2['record_status']=="OUT"){
    $x=0;
    $przerw_stop[]= $row2['record_time'];
}
}

$sql2 = "SELECT * FROM `records` WHERE `record_type`=3 AND `record_date`='".$row['record_date']."' AND `user_id`='".$row['user_id']."'";
$result2 = mysqli_query($conn,$sql2);
$j=0;
$magazyn_start = [];
$magazyn_stop = [];
while($row2 = mysqli_fetch_array($result2)){
if($row2['record_status']=='IN'){
    $j=1;
    // $czas_start += $row2['record_time'];
    $magazyn_start[]= $row2['record_time'];
}
if($row2['record_status']=="OUT"){
    $j=0;
    $magazyn_stop[]= $row2['record_time'];
}
$last = $row2['record_time'];
}


if( $i==1 || $x==1 || $j==1){
?>
<tr>
<td><?=$row['record_date']?></td>
<td><?=$row['user_email']?></td>
<td><?=$i?></td>
<td><?=$x?></td>
<td><?=$j?></td>
<td><form><button form='x' data-magazyn='<?=$j?>'data-przerwa='<?=$x?>'  data-last-time='<?=$last?>'data-praca='<?=$i?>' data-date='<?=$row['record_date']?>' data-id='<?=$row['user_id']?>' class='repair-day fas fa-tools'></button></form></td>
</tr>
<?php
}


}
?>
    </tbody>
    </table>
    <script>
// echo $test = file_get_contents("http://192.168.50.51");
//     $.post('http://192.168.50.51', { url:'http://192.168.50.51' }, function(data) {
//     $(".ans").html(data);  
// });
    </script>
    </section>
    <section>
    <h1>Obliczanie czasów</h1>
    <?php
$sql = "SELECT NOW()";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
echo "<p>mysql ".$row['NOW()']."</p>";
echo "<p>php ".Date("Y-m-d H:i:s")."</p>";
echo "<p class='js'></p>";
    ?>
    <script>
    var current = new Date();
    $(".js").html("js "+current.toLocaleString());
    </script>
    </section>
    <section>
    <?php
echo "<pre>";
print_r($_SERVER['HTTP_USER_AGENT']);
echo "</pre>";

setcookie ("TestCookie", $value);
setcookie ("TestCookie", $value,time()+3600);  /* traci ważność za godzinę */
    ?>
    </section>
</main>