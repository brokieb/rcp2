<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>

    <section class='shadow-2-strong m-5'>

        <div class='justify-content-center m-3'>
            
            <form method='post'>
                <div class='row mb-12'>
                    <h2>Dodaj nowego użytkownika</h2>
                </div>
                <div class="form-outline mb-4">
                    <input type="email" id="form1Example1" name='email' class="form-control" />
                    <label class="form-label" for="email">Email</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="password" name='pw' id="pw" class="form-control" />
                    <label class="form-label" for="pw">Hasło</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="imie" id="form1Example1" name='imie' class="form-control" />
                    <label class="form-label" for="imie">imie</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="absolute-prv" id="form1Example1" placeholder='admin,mod' name='absolute-prv' class="form-control" />
                    <label class="form-label" for="absolute-prv">Uprawnienia absolutne</label>
                </div>
                <div class="row mb-4 flex-wrap" data-mdb-inline="true">
                    <label class='col-2 form-label'>Uprawnienia</label>
                    <div class='col-10'>
                        <select class="form-control" name='prv'>
                            <option value='-1'>Brak uprawnień</option>
                            <option value='0'>Pracownik</option>
                            <option value='1'>Moderator</option>
                            <option value='2'>Administrator</option>
                        </select>
                    </div>
                </div>
                 <div class='p-2 text-center'>
            <button type='submit' class='btn btn-success btn-lg'>DODAJ UŻYTKOWNIKA</button>
        </div>
                <input type='hidden' name='mode' value='2'>


            </form>
        </div>
    </section>
    
  <section class='shadow-2-strong m-5'>

        <div class='justify-content-center m-3'>
                <div class='row mb-12'>
                    <h2>Zarządzanie użytkownikami</h2>
                </div>
        
        <div class='p-4 text-center'>
            <button class='btn btn-info'>POKAŻ ZABLOKOWANYCH</button>
        </div>
        <div>
            <table class='table table-bordered table-sm'>
                <thead>
                    <tr>
                        <td>ID pracownika</td>
                        <td>login</td>
                        <td>Godziny</td>
                        <td>Szczeg.</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
// echo $sql = "SELECT *, FROM `users` LEFT JOIN accepted_days ON `users`.user_id=`accepted_days`.user_id GROUP BY `accepted_days`.user_id";
if($_SESSION['prv']>2){
    $sql = "SELECT * FROM `users` WHERE `user_privilage` IS NOT NULL ORDER BY `user_email`";
}else{
    $sql = "SELECT * FROM `users` WHERE `user_privilage`<=".$_SESSION['prv']." AND `user_privilage` IS NOT NULL AND `user_privilage`>=0 ORDER BY `user_email`";
}

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result)){
$ans = [];
?>
                    <tr>
                        <td><?=$row['user_id']?></td>
                        <td><?=implode(" ",createName($row['user_email']))?></td>
                        <td>
                            <?php
                         $sql2 = "SELECT accept_hours,accept_id FROM `accepted_days` WHERE user_id='".$row['user_id']."' AND MONTH(accept_date) = MONTH(CURRENT_DATE())";
                         $result2 = mysqli_query($conn,$sql2);
                         while($row2 = mysqli_fetch_array($result2)){
                           
                            $godzinki = $row2['accept_hours'];
                         

                            $sql3 = "SELECT * FROM add_time WHERE accept_id=".$row2['accept_id'];
                            $result3 = mysqli_query($conn, $sql3);
                            $i="";
   while($row3 = mysqli_fetch_array($result3)){
       $pyt = [];
       if($row3['znak']=='0'){
           $pyt[] = $godzinki;
           $pyt[] = $row3['addtime_time'];
           $godzinki = minusTimes($pyt);
       }else{
           $pyt[] = $godzinki;
           $pyt[] = $row3['addtime_time'];
           $godzinki =  addTime($pyt);
       }
   
   }

                $ans[]=$godzinki;

                        
                        }

                         
   
                         ?>

                            <?=addTime($ans)?>


                        </td>
                        <td>

                            <button class='btn btn-info btn-sm user-details' data-mdb-toggle="modal" data-mdb-target="#exampleModal" data-id='<?=$row['user_id']?>' data-imie='<?=$row['user_email']?>'>Szczegóły</button>
                        </td>
                    </tr>

                    <?php


}
?>
                </tbody>
            </table>
        </div>
    </section>
    <section class='bg-image shadow-2-strong m-5'>
         <div class='justify-content-center m-3'>
        <div class='row mb-12'>
                    <h2>Wnioski o nieobecność</h2>
                </div>
        <table class='table table-bordered table-sm'>
            <thead>
                <tr>
                    <td>Pracownik</td>
                    <td>Od</td>
                    <td>Do</td>
                    <td>Komentarz</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>


                <?php
$sql = "SELECT * FROM `absent` INNER JOIN `users` ON `absent`.`user_id`=`users`.`user_id`";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
?>
                <tr>
                    <td><?=$row['user_email']?></td>
                    <td><?=$row['abs_from']?></td>
                    <td><?=$row['abs_to']?></td>
                    <td><?=$row['abs_comment']?></td>
                    <td>
                    </td>
                </tr>
                <?php
}
    ?>
            </tbody>
        </table>
</div>
    </section>
    <section class='bg-image shadow-2-strong m-5'>
        <div class='justify-content-center m-3'>
        <div class='row mb-12'>
                    <h2>Odrzucone godziny</h2>
                </div>
         <table class='table table-bordered table-sm'>
            <thead>
                <tr>
                    <td>Pracownik</td>
                    <td>Dzień</td>
                    <td>Godziny</td>
                    <td>Wyrównaj</td>
                    <td>Odrzucił</td>
                    <td>Odrzucono</td>
                    <td>Komentarz</td>
                </tr>
            </thead>
            <tbody>

                <?php
$sql = "SELECT `accept_id`,`accept_hours`,`accept_date`,`main`.`user_email` as `email_main`,`mod`.`user_email` as `email_mod` FROM `accepted_days` 
INNER JOIN `users` as `main` ON `accepted_days`.user_id=`main`.user_id 
INNER JOIN `users` as `mod` ON `accepted_days`.`accept_mod`=`mod`.user_id WHERE accept_type=0 AND addtime_id=0 AND `accept_calculated-from`!='MAN' ORDER BY `accept_date` DESC";
$result = mysqli_query($conn, $sql);
$ctr = 0;
while($row = mysqli_fetch_array($result)){
  
?>

                <tr>
                    <td><?=implode(" ",createName($row['email_main']))?></td>
                    <td><?=$row['accept_date']?></td>
                    <td class='saved-time' data-time='<?=$row['accept_hours']?>'><span><?=$row['accept_hours']?></span>
                    </td>
                    <!-- <button class='button-form'><i class="fas fa-history"></i></button> -->
                    <td class='form'>
                        <form method='post' class='add-time row'>

                            <div class='col-2 align-items-center'>
                                 <input type='checkbox' id='minus<?=$ctr?>' name='minus' value='1' title='minus' class="btn-check">
                               <label for='minus<?=$ctr?>' class="btn btn-secondary btn-sm h-100" for="minus">-</label>
                            </div>
                             <div class='col-6'>
                                <input type='time' name='added-time' min="00:00" value='00:00' class="form-control">
                            </div>
                             <div class='col-4'>
                               <button type='button' class='btn btn-success btn-sm far fa-check-circle h-100'></button>
                            </div>
                            <input type='hidden' name='accept-id' value='<?=$row['accept_id']?>'>
                            
                        </form>
                    </td>
                    <td>
                    <button class='btn btn-info btn-sm user-details' data-mdb-toggle="modal" data-mdb-target="#exampleModal" data-id='<?=$row['accept_mod']?>' data-imie='<?=$row['email_mod']?>'><?=implode(createName($row['email_mod'])," ")?></button>
                    <td><?=$row['accept_occured']?></td>
                    <td><?=$row['accept_comment']?></td>
                </tr>


                <?php
                $ctr++;
}
?>
            </tbody>
        </table>
</div>
    </section>

