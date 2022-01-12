<?php
include('default.php');
$sql = "SELECT * FROM `instances` WHERE `instance_name`='".$_GET['instance']."' AND `user_id`='".$_SESSION['user_id']."' ";
$query = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
if(!empty($row)){
    $conn2 = new mysqli("localhost","phpmyadmin","Damian#3","_in.".$row['instance_subdomain']);
    ?>
    <div class='col-12'>
<h2>Szczegóły dotyczące instancji <?=$row['instance_name']?></h2>
    </div>
<div class='space-around'>
<?php
$sql2 = "SELECT count(`user_status`) as `active-users` FROM `users` WHERE `user_status`='1'";
$query2 = mysqli_query($conn2,$sql2);
$row2 = mysqli_fetch_array($query2,MYSQLI_ASSOC);
?>
<div class='col-3'>
<h3>Dodaj pracownika</h3>
<form method='post'>
            <label for='email'>Email</label>
            <input type='text' name='email'>
            <label for='pw'>Hasło</label>
            <input type='text' name='pw'>
            <label for='imie'>Imie</label>
            <input type='text' name='imie'>
            <label for='prv'>Uprawnienie</label>
            <select name='prv'>
            <option value='-1'>Brak uprawnień</option>
            <option value='0'>Pracownik</option>
            <option value='1'>Moderator</option>
            <option value='2'>Administrator</option>
            </select>
            <albel for='absolute-prv'>Absolutne uprawnienie</albel>
            <input type='text' name='absolute-prv' placeholder='admin,mod'>
            <input type='hidden' name='mode' value='2'>
            <button>dodaj użuytkownika</button>


        </form>
</div>
<div class='col-7'>
<p>Aktywni pracownicy <strong><?=$row2['active-users']?></strong> </p>
<p>... <strong><?=$row2['active-users']?></strong> </p>
<p>. <strong><?=$row2['active-users']?></strong> </p>
</div>
<div class='col-3'>
<h3>Wtyczki</h3>
<form method='post'>
<label><input type="checkbox"> Automatyczne potwierdzanie dni</label>
<label><input type="checkbox"> Automatyczne potwierdzanie dni</label>
<label><input type="checkbox"> Automatyczne potwierdzanie dni</label>
<label><input type="checkbox"> Automatyczne potwierdzanie dni</label>
<label><input type="checkbox"> Automatyczne potwierdzanie dni</label>

</form>

</div>
</div>
    <?php
}
?>