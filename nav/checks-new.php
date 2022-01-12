<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
$sql = "SELECT `user_status` FROM users WHERE `user_id`=".$_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
echo $row['user_status'];
switch($row['user_status']){
case 0:
    echo "nie pracuje";
    ?>
<button class='status-toggle-new' data-event='1' data-type='1'>ZACZYNAM PRACE</button>
<?php
    break;
case 1://PRACA
    echo "w pracy";
    ?>
<button class='status-toggle-new' data-event='2' data-type='2'>ZACZYNAM PRZERWE</button>
<button class='status-toggle-new' data-event='3' data-type='3'>IDĘ NA MAGAZYN</button>
<button class='status-toggle-new' data-event='1' data-type='0'>KOŃCZĘ PRACĘ NA DZIŚ </button>
<?php
    break;
case 2://PRZERWA
    echo "na przerwie";
    ?>
<button class='status-toggle-new' data-event='2' data-type='1'>KONIEC PRZERWY</button>
<?php
    break;
case 3://MAGAZYN
    echo "w magazynie";
    ?>
<button class='status-toggle-new' data-event='3' data-type='1'>WRACAM Z MAGAZYNU</button>
<?php 
    break;
    

}


echo $sql = "SELECT * FROM records_new WHERE `user_id`='".$_SESSION['user_id']."' AND record_date='".Date('Y-m-d')."'";
$result = mysqli_query($conn, $sql);
echo "<div class='check-tab'>";
while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
    switch(($row['record_event'])){
        case 1:
            $ans = "PRACA";
            break;
        case 2:
            $ans = "PRZERWA";
            break;
        case 3:
            $ans = "MAGAZYN";
            break;
    }

echo "<div class='check-el' data-time='2012-01-01T".$row['record_in_time'].".000Z'>";
        echo $row['record_in_time']." START ".$ans;
echo "</div>";
    if($row['record_out_time']!=NULL){
        echo "<div class='check-el' data-time='2012-01-01T".$row['record_out_time'].".000Z'>";
        echo $row['record_out_time']." STOP ".$ans;
echo "</div>";
    }


}
echo "</div>"

?>