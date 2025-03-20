<?

//cierro la sesion
session_start();
session_destroy();

//Borramos fichero temporal de acceso del alumno
//unlink("./temp/$_SESSION[utilizado]");

header("location: index.php");

?>