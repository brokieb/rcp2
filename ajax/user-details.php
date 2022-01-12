<?php
include("default.php");
$sql = "SELECT * FROM users WHERE user_id=".$_GET['id']." AND (`user_privilage`<=".$_SESSION['prv']." OR `user_privilage` IS NULL)";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
if(empty($row)){
    ?>
<h1>Nie masz dostępu do tej zawartości</h1>
<?php
}else{

?>
<div class='row'>
    <div class='col-6'>
        <form method='POST' autocomplete='off'>
            <h2>Zmiana hasła</h2>
            <div class="form-outline mb-4 w-50">
                <input type="password" id="form1Example1" name='npw' class="form-control" required='required' />
                <label class="form-label" for="npw">Nowe hasło</label>
            </div>
            <div class="form-outline mb-4 w-50">
                <input type="password" id="form1Example1" name='rnpw' class="form-control" required='required' />
                <label class="form-label" for="rnpw">Powtórz nowe hasło</label>
            </div>
            <div class='mb-4'>
                <input type='hidden' name='id' value='<?=$row['user_id']?>'>
                <input type='hidden' name='mode' value='7'>
                <button role='submit' class='btn btn-primary'>ZMIEŃ HASŁO</button>
            </div>

        </form>
    </div>
    <div class='col-6'>
        <div class='switches'>
            <h2>Ustawionka</h2>
            <form method='POST'>
                <div class='row'>
                    <div class='col-4'>
                        <div class="form-outline">
                            <input type='number' class='form-control' name='prv' min='0' max='2'
                                value='<?=$row['user_privilage']?>'>
                            <label class="form-label" for="prv">Uprawnienia</label>
                        </div>
                    </div>
                    <div class='col-auto'>
                        <button class='btn btn-primary'>ZMIEŃ</button>
                    </div>
                </div>
                <input type='hidden' name='id' value='<?=$row['user_id']?>'>
                <input type='hidden' name='mode' value='6'>
            </form>
            <form method='POST'>
                <div class="form-check form-switch">
                    <?php
switch($row['user_remote_work']){
    case 0:
        ?>

                    <input class="form-check-input remote-toggle" type="checkbox" id="flexSwitchCheckDefault"
                        data-id="<?=$row['user_id']?>" />
                    <?php
        break;
    case 1:
        ?>
                    <input class="form-check-input remote-toggle" type="checkbox" id="flexSwitchCheckDefault"
                        data-id="<?=$row['user_id']?>" checked />
                    <?php
        break;
}
            ?>
                    <label class="form-check-label" for="flexSwitchCheckDefault">Praca zdalna</label>
            </form>
        </div>
        <form method='POST'>
            <div class="form-check form-switch">
                <?php
if($row['user_privilage']!=NULL){
    ?>
                <input class="form-check-input remote-toggle" type="checkbox" id="flexSwitchCheckDefault"
                    checked='checked' />
                <input type='hidden' name='prv' value='0'>
                <?php
}else{
    ?>
                <input class="form-check-input remote-toggle" type="checkbox" id="flexSwitchCheckDefault" />
                <input type='hidden' name='prv' value='NULL'>



        </form>
        </td>
        <?php
}
                                ?>
        <input type='hidden' name='id' value='<?=$row['user_id']?>'>
        <input type='hidden' name='mode' value='6'>
        <label class="form-check-label" for="flexSwitchCheckDefault">Konto aktywne</label>



    </div>
</div>
</div>


<div class='row d-grid gap-2'>
    <h2>Podsumowanie czasów</h2>
    <div class='btn-group p-0' role='group' aria-label="Basic">
    <?php
$months = [
'1'=>'styczeń',
'2'=>'Luteń',
'3'=>'Marzeń',
'4'=>'Kwiecień',
'5'=>'Majeń',
'6'=>'Czerwień',
'7'=>'Lipień',
'8'=>'Sierpień',
'9'=>'Wrzesień',
'10'=>'Październień',
'11'=>'Listopadeń',
'12'=>'Grudzień'
];
echo Date('n');
foreach($months as $key=>$value){
    if($key<=Date('n')){
        ?>

<a href='#' class='btn btn-primary another-month' data-month='<?=$key?>' data-id='<?=$row['user_id']?>'><?=$value?></a>

        <?php
    }
}
    ?>
    </div>

    <?php
?>
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
                $i =1;
                $arr = [];
                while($i<=Date('t')){
                $x = Date("Y-".str_pad(Date('m'),2,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT));
                    if(date('N',strtotime($x))<=5){
                        
                   $sql2 = "SELECT *,`accepted_days`.`accept_id` as `id_prim` FROM accepted_days LEFT JOIN add_time ON accepted_days.accept_id=add_time.accept_id WHERE user_id=".$_GET['id']." AND accept_date='".$x."'";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
                        if(count($row2)>0){

                            ?>
            <tr>
                <td>
                    <form method='post' action='nav/checks-log.php'>
                        <input type='hidden' name='id' value='<?=$row['user_id']?>'>
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
                            $arr[] = $godzinki;
            

                            
                        }else{

                            $sql4 ="SELECT * FROM records_new WHERE user_id=".$row['user_id']." AND record_date='".$x."'";
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_array($result4,MYSQLI_ASSOC);
                            if(empty($row4)){
                                if($x==Date("Y-m-d")){
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
                <td class='hours'></td>
                <td colspan='5 d-grid'>
                    <div class='row'>
                        <div class='col-3'>
                            <input class='form-control' type='time' name='work-time' min="00:00" value='00:00'>
                        </div>
                        <div class='col-2'>
                            <button type='button' class='btn btn-success btn-sm create-work-day'><i class="far fa-check-circle"></i></button>
                        </div>
                        <input type='hidden' name='user-id' value='<?=$row['user_id']?>'>
                        <input type='hidden' name='date' value='<?=$x?>'>

                    </div>

                </td>
            </tr>
            <?php
     }
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

        </tbody>
    </table>

</div>
</div>
<?php
}
?>