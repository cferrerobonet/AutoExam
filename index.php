<? 

session_destroy();
session_start();

require('config.php'); ?>
<? require('funciones.php');
set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
require_once('PHPExcel.php');
require_once('PHPExcel/Reader/Excel2007.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
	<title>Panel de acceso al test</title>

	<meta http-equiv="content-type" content="text/html; charset=iso-8859-15" />
	<meta http-equiv="content-style-type" content="text/css" />

	    <link rel="stylesheet" type="text/css" media="all" href="css/estilo.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/global.css" />
        <script type="text/javascript" src="js/ajax.js"></script>
    <script type="text/javascript" src="js/mis_func.js"></script>
    
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
                              <div class="reloj">
                                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="165" height="150">
                                    <param name="movie" value="reloj.swf"></param>
                                    <param name="quality" value="high"></param>
                              <embed src="reloj.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="165" height="150"></embed>
                              </object>

                              </div>
                              
			  </div>

			  <div id="principal" class="contacto">
				<div class="cuerpo">
					<h2>Acceso para el alumno:</h2>
                    <p>
                        <div id="error">                            
                            <div class="mensajeInformativo informacion">
                                <div class="top">
                                    <div class="bottom">
                                        <p><span class="icono">Informacion: </span>Selecciona una asignatura y tu nombre y dar&aacute; comienzo el test.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <form name="notas">         

                    <div id="asig">
                       <?
                        //Calculo el curso actual
                        $anyo = Date('Y');
                        $mes = Date('n');                        

                        if($mes >= 10 )
                            $curso = $anyo.'-'.($anyo+1);
                        else
                            $curso = ($anyo-1).'-'.$anyo;                        

                        //Creo un objeto Excel 2007
                        $objReader = new PHPExcel_Reader_Excel2007();

                        //Muestro los cursos que hay
                        $directorio = opendir('./cursos/'.$curso.'/alumnos');

                        echo '<h3>Elige una asignatura:</h3>
                                <SELECT onchange= "document.getElementById(\'exa\').innerHTML = \'\'; FAjax(\'cargacombos3.php\',\'alu\',\'curso='.$curso.'&asig=\' + document.forms.notas.asignaturas.value,\'post\');" NAME="asignaturas" style="font-size:13px">
                                <OPTION SELECTED VALUE="0">Selecciona asignatura';

                        while ($file = readdir($directorio)){

                              if ($file != '.' && $file != '..'){

                                    //Cargo el excel
                                    $objPHPExcel = $objReader->load('./cursos/'.$curso.'/alumnos/'.$file);

                                    //Activo la hoja de calculo
                                    $objWorksheet = $objPHPExcel->getActiveSheet();

                                    //Leo el nombre de la asignatura
                                    $cell = $objWorksheet->getCell('B1');

                                    //Muestro el nombre
                                    echo '<OPTION VALUE="'.$file.'">'.utf8_encode($cell->getValue());
                              }
                        }
                        echo '</SELECT>
                                <br><br><br>';

                        closedir('./cursos/'.$curso.'/alumnos');       ?>

                    </div>

                    <div id="alu">

                    </div>

                    <div id="exa">

                    </div>

                    </form>

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