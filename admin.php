<? session_start(); ?>
<? require('config.php'); ?>
<? require('funciones.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>

    <?
        
        if(isset($_POST[user]) && isset($_POST[password])){

            //Recojo user/pass
            $user = addslashes($_POST['user']);
            $pass = addslashes($_POST['password']);

            //Compruebo usuario
            if($user == $user_admin && $pass == $pass_admin){

                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                
                echo "<script language=javascript>document.location.href='bienvenida.php'</script>";
            }
            else
                $error = 1;
        }

?>

	<title>Panel de administraci&oacute;n</title>

	<meta http-equiv="content-type" content="text/html; charset=iso-8859-15" />
	<meta http-equiv="content-style-type" content="text/css" />

	<link rel="stylesheet" type="text/css" media="all" href="css/estilo.css" />
    <script type="text/javascript" src="js/ajax.js"></script>
    
	</head>
	<body>
		<div id="contenedor">
		  <div id="cabecera">
			<div id="navegacionPpal">

			  <strong><a class=logo href=bienvenida.php><h1 id="logo" style="font-size:42px; color:#DDD; margin-top:40px;margin-left:50px;">Autoexam <?echo $revision;?></h1></a></strong>
			  
			</div>
		  </div>

		  <div id="wrapper">
			<div id="contenido" class="clear">
			  <div id="secundario">
				
			  </div>

			  <div id="principal" class="contacto">
				<div class="cuerpo">
					<h2>Acceso exclusivo para administrador:</h2>
                    <p>
                        <div id="error">

                            <? if(($error == 1) || ($_GET[error] == 1))
                                  echo "<div class=\"mensajeInformativo error errorseo\"><div class=\"top\"><div class=\"bottom\"><p><span class=\"icono\">Informacion: </span>Ha introducido mal su usuario o contrase&ntilde;a</p></div></div>";
                               else{
                            ?>
                            <div class="mensajeInformativo informacion">
                                <div class="top">
                                    <div class="bottom">
                                        <p><span class="icono">Informacion: </span>Introduzca usuario y contrase&ntilde;a de administraci&oacute;n</p>
                                    </div>
                                </div>
                            </div>
                            <?}?>
                        </div>

                    <div class='pantallaLogin'>
                        <fieldset>
                              <form action="admin.php" method="post">
                                <input type="hidden" name="process" value="true" />
                                    <table id="qls_table">
                                    <tr>
                                        <td>
                                            <strong>Nombre de usuario: </strong>
                                        </td>
                                        <td>
                                            <input type="text" size="18" name="user" maxlength="15" id="user"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Contrase&ntilde;a: </strong>
                                        </td>
                                        <td>
                                            <input type="password" size="18" name="password" maxlength="15" id="password"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <br><input type="submit" value="Acceder al panel" />
                                        </td>
                                    </tr>
                                </table>
                             </form>
                        </fieldset>
                        </p>                        
                    </div>
				</div>
			  </div>
			</div>
		  </div>

		  <div id="pie">
			<div class="clear">
			  <div id="infoCopyright">
				<p>
					Autoexam <? echo $revision; ?> - Desarrollado por <a href="#"><strong>V.Ferrero</strong> - 2010</a>
				</p>
			  </div>
			  <div class="links">				
			  </div>
			</div>
		  </div>
		</div>
	</body>
</html>