
<?php
include('conn.php');
?>
<!DOCTYPE html>
<html>
<body>

<?php
echo $sql = "DELETE FROM `user_session` WHERE `session_hash`=".$_SESSION['hash']." ";
mysqli_query($conn, $sql);
session_unset();
session_destroy();
header('location:index.php');
// define("CONSTANT",false);

// setcookie("hash","0",time()-3600);
?>

</body>
</html>