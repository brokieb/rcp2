<?php
include('default.php');

$sql = "UPDATE `con_variables` SET `con_value`='".$_GET['new']."' WHERE `con_value`='".$_GET['id']."'";
if(mysqli_query($conn, $sql)){
    echo '{"ans":"1"}';
}
?>