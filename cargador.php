<? session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
    <? require("head.php"); ?>
	</head>
	<body>
		<div id="contenedor">
            <? require("cabecera.php"); ?>           
		  <div id="wrapper">
			<div id="contenido" class="clear">
                  <? require("menu.php"); ?>
			  <div id="principal" class="contacto">
				<? require("gestion-cargador.php"); ?>
			  </div>              
			</div>
                <? require("pie.php"); ?>
		  </div>
		</div>
	</body>
</html>