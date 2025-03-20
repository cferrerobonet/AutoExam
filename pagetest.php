<? session_start(); 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
    <? require("head2.php"); ?>
	</head>
        <?
                //en este fichero pondre la hora a la que el alumno entra al test                
                if(isset($_SESSION[utilizado])){
                    $fichero = fopen("./temp/".$_SESSION[utilizado],"w");
                    $_SESSION[hora_entrada] = Date('Y').Date('m').Date('d').Date('H').Date('i').Date('s');
                    fputs($fichero,$_SESSION[hora_entrada]);
                    fclose($fichero);
                    unset($_SESSION[utilizado]);
                }
                ?>
	<body onload="<? if ($_SESSION[duracion] != 0){?> Crono(<?echo $_SESSION[hora_entrada];?>,<?echo Date('Y').Date('m').Date('d').Date('H').Date('i').Date('s');?>,<? echo $_SESSION[duracion];?>); <?}?>">		
                <div id="contenedor">
            <? require("cabecera2.php"); ?>
		  <div id="wrapper">
			<div id="contenido" class="clear">
                  <? require("menu2.php"); ?>
			  <div id="principal" class="contacto">
				<? require("test.php"); ?>
			  </div>              
			</div>
                <? require("pie2.php"); ?>
		  </div>
		</div>
	</body>
</html>