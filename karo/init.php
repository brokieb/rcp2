<?php
if(isset($_GET['site'])){
    //include dana strona
    include("site/".$_GET['site'].".php");
}else{
    include('main.php');
}
?>
