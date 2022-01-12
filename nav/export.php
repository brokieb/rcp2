<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>
<section class='shadow-2-strong m-5'>
    <h2>Miesięczne zestawienie obecności</h2>
    <form id='export' method='POST' action='prints/print.php' class='row w-25 m-2 p-2 gap-2 d-flex'>
    <div>
        <label for="month">Wybierz miesiąc:</label>
        <select name="month" id="month" class='form-control select-this-month-details'>
        <?php

$sql = "SELECT DISTINCT(accept_date), LEFT(accept_date, 7) as month FROM accepted_days GROUP BY LEFT(accept_date, 7)";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
    if(date("Y-m", strtotime("-1 months"))==$row['month']){
        ?>
<option value="<?=$row['month']?>" selected><?=$row['month']?></option>
        <?php
    }else{
        ?>
        <option value="<?=$row['month']?>"><?=$row['month']?></option>
        <?php
    }
?>


<?php
}
?>
        </select>
        </div>
        <button type='button' class='btn btn-secondary hide-content'>POKAŻ TABELĘ DO WYPLATY</button>
        <button type='submit' class='btn btn-primary' >GENERUJ</button>
    </form>
    <table class='table table-bordered table-sm month-details-table'>

        <thead>
            <tr>
                <td>ID</td>
                <td>Imie i nazwisko</td>
                <td class='hide-me'>Godzin do przepracowania</td>
                <td class='hide-me'>Godziny bez wyrównania</td>
                <td>Godziny +5 minut</td>
                <td class='hide-me'>różnica</td>
                <td>Status</td>
                <td class='hide-me'>Wyrównaj</td>
                <td class='hide-me'>Druk<input type='checkbox' class='all-export'></td>
            </tr>
        </thead>
        <tbody>
<?php
       $sql = "SELECT * FROM `accepted_days` 
INNER JOIN `users` ON `accepted_days`.`user_id`=`users`.`user_id` 
LEFT JOIN add_time ON `accepted_days`.`addtime_id`=`add_time`.`addtime_id` 
LEFT JOIN `accepted_months` ON `accepted_months`.`accept_m_user_id`=`users`.`user_id` AND DATE_FORMAT(`accept_month`,'%Y-%m')='".date('Y-m', strtotime(' - 1 month'))."'  
WHERE DATE_FORMAT(`accept_date`,'%Y-%m')='".date('Y-m', strtotime(' - 1 month'))."'
GROUP BY  `accepted_days`.`user_id` 
ORDER BY `users`.`user_email`";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
$times = [];
$arr = [];
$sql2 = "SELECT * FROM `accepted_days` LEFT JOIN add_time ON `add_time`.`accept_id`=`accepted_days`.`accept_id` WHERE `user_id`=".$row['user_id']." AND DATE_FORMAT(`accept_date`,'%Y-%m')='".date('Y-m', strtotime(' - 1 month'))."' AND accept_type=1 ORDER BY accept_date";
$result2 = mysqli_query($conn, $sql2);
$dodatki = NULL;
            while($row2 = mysqli_fetch_array($result2)){
                $pyt = [];
                if($row2['znak']=='0'){
                    $pyt[] = $row2['accept_hours'];
                    $pyt[] = $row2['addtime_time'];
                    $godzinki = minusTimes($pyt);
                }else{
                    $pyt[] = $row2['accept_hours'];
                    $pyt[] = $row2['addtime_time'];
                    $godzinki =  addTime($pyt);
                }
            $arr[$row2['accept_date']] = $godzinki;
            }

$godziny_msc["2021-01"]="152";
$godziny_msc["2021-02"]="160";
$godziny_msc["2021-03"]="184";
$godziny_msc["2021-04"]="168";
$godziny_msc["2021-05"]="152";
$godziny_msc["2021-06"]="168";
$godziny_msc["2021-07"]="176";
$godziny_msc["2021-08"]="176";
$godziny_msc["2021-09"]="176";
$godziny_msc["2021-10"]="168";
$godziny_msc["2021-11"]="160";
$godziny_msc["2021-12"]="176"; 
?>
<tr>
    <td><?=$row['user_id']?></td>
    <td><?=implode(" ",createName($row['user_email']))?></td>
    <td class='hide-me'><?="a"?></td>
    <td class='hide-me'><?=$a = addTime($arr)?></td>
    <?php
$b = addTimeTest($arr);
    ?>
    <td><?=substr($b,0,-3)?>:00</td>
    <td class='hide-me'><?=timeDiff($a,$b)?></td>
    <td>
        <?php
switch($row['accept_m_status']){
case NULL:
echo "NIEWYG";
break;
case 1:
echo "GENOK";
break;
case 2:
echo "ODEBR";
break;
}

?>
    <td class='hide-me'>
        <input form='export' name='wyrownaj[<?=$row['user_id']?>]' value='184' type='checkbox'>
    </td>
    <td class='hide-me'>
        <input form='export' name='ids[]' value='<?=$row['user_id']?>' type='checkbox' class='this-export'>
    </td>
</tr>
<?php
}
?>
        </tbody>
    </table>

</section>