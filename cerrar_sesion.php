<?

//cierro la sesion
session_start();
session_destroy();
header("location: admin.php");

?>