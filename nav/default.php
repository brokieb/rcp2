<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>
<main>
<section class=' d-flex flex-column shadow-2-strong m-5 gap-3 px-5'>
<div class='row'>
<h1>Ta strona nie istnieje :(</h1>
</div>
<div class='row'>
<h6>Spróbuj wykorzystać jedno z działających łączy</h6>
</div>
<div class='row'>
<ul class='list-unstyled d-flex flex-row justify-content-around m-0 w-75'>
<li><a href='index.php'>Strona główna</a></li>
<li><a href='?site=support'>Wsparcie</a></li>
<li><a href='destroy.php'>Wyloguj się</a></li>
</ul>
</div>

</section>

<?php
$sql2 = "SELECT * FROM system_nav WHERE nav_prv<=".$_SESSION['prv']." ";
$result = mysqli_query($conn, $sql2);
while($row = mysqli_fetch_array($result)){
echo "<a href='?site=".$row['nav_href']."'>".$row['nav_subject']."</a> ";
}
?>

</main>