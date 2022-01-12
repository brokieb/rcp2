
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// remove all session variables
session_unset();
define("CONSTANT",false);
// destroy the session
session_destroy();
header('location:index.php');
?>

</body>
</html>