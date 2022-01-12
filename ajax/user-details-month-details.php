 <table class='month-details table table-bordered table-sm'>
        <thead>
            <tr>
                <td>log</td>
                <td>Dzień</td>
                <td>Godziny</td>
                <td>Poprawki</td>
                <td>Moderator</td>
                <td>Akceptowano</td>
                <td>przez</td>
                <td>Komentarz</td>
            </tr>
        </thead>
        <tbody>
            <?php
            include('default.php');
                $i =1;
                $arr = [];
                while($i<=cal_days_in_month(CAL_GREGORIAN, $_GET['month'], Date("Y"))){
$x = Date("Y-".str_pad($_GET['month'],2,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT));
    if(date('N',strtotime($x))<=5){
        
 $sql2 = "SELECT *,`accepted_days`.`accept_id` as `id_prim` FROM accepted_days LEFT JOIN add_time ON accepted_days.accept_id=add_time.accept_id WHERE user_id=".$_GET['id']." AND accept_date='".$x."'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
        if(count($row2)>0){

                            ?>
            <tr>
                <td>
                    <form method='post' action='nav/checks-log.php'>
                        <input type='hidden' name='id' value='<?=$row2['user_id']?>'>
                        <input type='hidden' name='date' value='<?=$row2['accept_date']?>'>
                        <button class='btn btn-primary btn-sm'><i class="fas fa-list"></i></button>
                    </form>
                </td>
                <td><?=$x?></td>
                <td class='hours '><?=$godzinki = $row2['accept_hours']?></td>
                <td>
                    <?php
            $sql3 = "SELECT * FROM add_time WHERE accept_id=".$row2['accept_id'];
            $result = mysqli_query($conn, $sql3);
            $dodatki = NULL;
            while($row3 = mysqli_fetch_array($result)){
                $pyt = [];
                if($row3['znak']=='0'){
                    echo "-";
                    $pyt[] = $godzinki;
                    $pyt[] = $row3['addtime_time'];
                    $godzinki = minusTimes($pyt);
                }else{
                    echo "+";
                    $pyt[] = $godzinki;
                    $pyt[] = $row3['addtime_time'];
                    $godzinki =  addTime($pyt);
                }
            $dodatki = $row3['addtime_time'];
            }
            if($dodatki == NULL && $row2['accept_type']=='1'){
                ?>
                    <button type='button' class='reject-accepted-day btn btn-warning btn-sm'
                        data-accept='<?=$row2['accept_type']?>' data-id='<?=$row2['id_prim']?>'>ODRZUĆ</button>

                    <?php
            }elseif($dodatki == NULL && $row2['accept_type']=='0'){
                echo "do poprawy";
            }else{
                echo $dodatki;
            }
            ?>

                </td>
                <td><a
                        href='index.php?site=admin&user=<?=$row2['addtime_accept_mod']?>'><?=$row2['addtime_accept_mod']?></a>
                </td>
                <td><?=$row2['accept_occured']?></td>
                <td><a href='index.php?site=admin&user=<?=$row2['accept_mod']?>'><?=$row2['accept_mod']?></a>
                </td>
                <td style='width:200px'><?=$row2['accept_comment']?></td>
            </tr>
            <?php
                            $arr[$row2['accept_date']] = $godzinki;
            

                            
                        }else{
                            $date = new DateTime($x);
                            $date->modify('-1 month');
                          $sql4 ="SELECT * FROM records_new WHERE user_id=".$_GET['id']." AND record_date='".$x."'  ";
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_array($result4,MYSQLI_ASSOC);
                            if(empty($row4)){
                                ?>
                                <tr>
                                    <td></td>
                                    <td><?=$x?></td>
                                    <td class='hours'></td>
                                    <td colspan='5 d-grid'>
                                        <div class='row'>
                                            <div class='col-3'>
                                                <input class='form-control' type='time' name='work-time' min="00:00" value='00:00'>
                                            </div>
                                            <div class='col-2'>
                                                <button type='button' class='btn btn-success btn-sm create-work-day'><i class="far fa-check-circle"></i></button>
                                            </div>
                                            <input type='hidden' name='user-id' value='<?=$_GET['id']?>'>
                                            <input type='hidden' name='date' value='<?=$x?>'>
                    
                                        </div>
                    
                                    </td>
                                </tr>
                                <?php
                            }else{
                                if($row4['record_date']==Date("Y-m-d")){
?>
            <tr>
                <td></td>
                <td><?=$x?></td>
                <td colspan='6'>Dziś</td>

            </tr>

            <?php


                                }else{
                                    ?>

            <tr>
                <td></td>
                <td><?=$x?></td>
                <td colspan='6'>Do akceptowania</td>
            </tr>
            <?php
                                }
                        
                            }
?>

            <?php
                        }
                           


                    }else{
                        ?>
            <tr>
                <td></td>
                <td><?=$x?></td>
                <td colspan='6'>Weekend</td>
            </tr>
            <?php
                    }
                    $i++;
                }
?>
<tr>
<td colspan='2'><pre><?=print_r($arr)?></pre></td>
<td colspan='5'><strong><?=AddTime($arr)?></strong></td>
</tr>
        </tbody>
    </table>
   
