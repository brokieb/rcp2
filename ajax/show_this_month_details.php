<?php
include('default.php');
$sql = "SELECT * FROM `accepted_days` 
INNER JOIN `users` ON `accepted_days`.`user_id`=`users`.`user_id` 
LEFT JOIN add_time ON `accepted_days`.`addtime_id`=`add_time`.`addtime_id` 
LEFT JOIN `accepted_months` ON `accepted_months`.`accept_m_user_id`=`users`.`user_id` AND DATE_FORMAT(`accept_month`,'%Y-%m')='".$_GET['month']."'  
WHERE DATE_FORMAT(`accept_date`,'%Y-%m')='".$_GET['month']."' 
GROUP BY  `accepted_days`.`user_id` 
ORDER BY `users`.`user_email`";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
$times = [];
$arr = [];
$sql2 = "SELECT * FROM `accepted_days` LEFT JOIN add_time ON `accepted_days`.`addtime_id`=`add_time`.`addtime_id` WHERE `user_id`=".$row['user_id']." AND DATE_FORMAT(`accept_date`,'%Y-%m')='".$_GET['month']."' AND accept_type=1 ORDER BY accept_date";
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
    <td><?=$row['user_email']?></td>
    <td><?="a"?></td>
    <td><?=$a = addTime($arr)?></td>
    <td><?=$b = addTimeTest($arr)?></td>
    <td><?=timeDiff($a,$b)?></td>
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
    <td>
        <input form='export' name='wyrownaj[<?=$row['user_id']?>]' value='184' type='checkbox'>
    </td>
    <td>
        <input form='export' name='ids[]' value='<?=$row['user_id']?>' type='checkbox' class='this-export'>
    </td>
</tr>
<?php
}
?>
