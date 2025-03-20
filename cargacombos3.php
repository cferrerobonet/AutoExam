<? 

session_start();

/** Clases necesarias */
set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
require_once('PHPExcel.php');
require_once('funciones.php');
require_once('PHPExcel/Reader/Excel2007.php');

 //Calculo el curso actual
$anyo = Date('Y');
$mes = Date('n');

if($mes >= 10 )
    $curso = $anyo.'-'.($anyo+1);
else
    $curso = ($anyo-1).'-'.$anyo;

//Acabo de elegir una asignatura y cargo combo de alumnos
if(isset($_POST["asig"]) && !isset($_POST["alu"])){

    //Creo un objeto Excel 2007
    $objReader = new PHPExcel_Reader_Excel2007();

    echo '<h3>Elige un alumno:</h3>
            <SELECT onchange= "FAjax(\'cargacombos3.php\',\'exa\',\'alu=\' + document.forms.notas.alumnos.value + \'&curso='.$curso.'&asig=\' + document.forms.notas.asignaturas.value,\'post\');" NAME="alumnos" style="font-size:13px">
            <OPTION SELECTED VALUE="0">Selecciona alumno';

    //Cargo el excel
    $objPHPExcel = $objReader->load('./cursos/'.$curso.'/alumnos/'.$_POST['asig']);

    //Activo la hoja de calculo
    $objWorksheet = $objPHPExcel->getActiveSheet();

    $i = 4;

    //Leo el nombre del alumno
    while(($cell = $objWorksheet->getCell('A'.$i)) && (strlen($cell->getValue()) > 0)){
        
        //Muestro el nombre
        echo '<OPTION VALUE="'.$cell->getValue().'">'.ucwords($cell->getValue());
        $i++;
    }    
    
    echo '</SELECT>
            <br><br><br>';
}

//Hacemos las comprobaciones necesarias
//Vemos si es la hora del examen
//Si no es la hora, indicamos en un mensaje informativo, a que hora es.
//Al entrar registramos al usuario en el examen
//Si alguien intenta entrar con el mismo nombre, lo prohibimos.

if(isset($_POST["asig"]) && isset($_POST["alu"])){

    //Creo un objeto Excel 2007
    $objReader = new PHPExcel_Reader_Excel2007();

    //Si no es porque quiero ver el examen de un alumno en concreto
    $directorio = opendir('./cursos/'.$curso.'/examenes');

    $fecha_correcta = 0;
    //Cargamos en el combo de examenes todas las coincidencias de examenes
    while ($file = readdir($directorio)){

          if ($file != '.' && $file != '..'){

               $nomfich = substr($_POST["asig"],0,strlen($_POST["asig"])-5);

               if(substr_count($file, $nomfich)>0){
                   $examen = explode('_', $file);
                   $fecha_examen = $examen[count($examen)-1];
                   $fecha_examen = substr($fecha_examen,0,strlen($fecha_examen)-5);
                   $fecha_examen2 = $fecha_examen;
                   $fecha_examen = $fecha_examen[6].$fecha_examen[7].'-'.$fecha_examen[4].$fecha_examen[5].'-'.$fecha_examen[0].$fecha_examen[1].$fecha_examen[2].$fecha_examen[3].' '.$fecha_examen[8].$fecha_examen[9].':'.$fecha_examen[10].$fecha_examen[11];
                   
                   $fecha_entrada = strtotime($fecha_examen);
                   $fecha_examen = "Test ".$fecha_examen;

                   $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
                   
                   //Miramos la duración del examen para añadirsela a la hora del examen
                    $objPHPExcel = $objReader->load('./cursos/'.$curso.'/examenes/'.$file);

                    //Activo la hoja de calculo
                    $objWorksheet = $objPHPExcel->getActiveSheet();

                    //Leo la duración del examen
                    $cell = $objWorksheet->getCell('B6');
                    $tiempo_examen = $cell->getValue();                     
                    
                    //Leo la penalizacion del examen
                    $cell = $objWorksheet->getCell('B5');
                    $penalizacion = $cell->getValue();
                    
                   //Miramos si es la hora de algun examen y si no ha caducado el examen
                   //if(($fecha_actual >= $fecha_entrada) && ($fecha_actual < ($fecha_entrada + $tiempo_examen * 60))){
                    if(($fecha_actual >= $fecha_entrada) && ($fecha_actual < ($fecha_entrada + 240 * 60))){
                        $_SESSION[curso] = $curso;
                        $_SESSION[hora] = $fecha_examen2;
                        $_SESSION[duracion] = $tiempo_examen;
                        $_SESSION[penalizacion] = $penalizacion;
                        $_SESSION[examen] = './cursos/'.$curso.'/examenes/'.$file;
                        $fecha_correcta = 1;
                   }
               }
          }
    }

    closedir('./cursos/'.$curso.'/examenes');

    //Ahora registramos al alumno como que entra
    //Creo un fichero temporal con el nombre 'alumno_fechaexamen_asignatura.tmp'
    //Si ya existe es porque alguién se ha metido ya con ese nombre

    //Abro el directorio temporal
    $directorio = opendir('./temp');

    $nomfich = substr($_POST["asig"],0,strlen($_POST["asig"])-5);
    $nom = strtolower(LimpiarCadena($_POST["alu"]));
    $nom = str_replace(" ", "_", $nom);
    $nomfich = $nomfich."_".$nom."_".$fecha_entrada.".tmp";
    $utilizado = 0;
    $existe = 0;
    
    //Leo los ficheros
    while ($file = readdir($directorio)){
         if ($file != '.' && $file != '..' && (strcmp($file,$nomfich) == 0)){
                //Ya existe el fichero, alguién ha utilizado este nombre de alumno
                //Leo a que hora entro el alumno y lo guardo en la sesion
                $fichero = fopen("./temp/".$nomfich,"r");
                $buffer = fgets($fichero,4096);
                $_SESSION[hora_entrada] = $buffer;
                fclose($fichero);
                unset($_SESSION[utilizado]);
                $existe = 1;

               //$fecha_examen = $buffer[6].$buffer[7].'-'.$buffer[4].$buffer[5].'-'.$buffer[0].$buffer[1].$buffer[2].$buffer[3].' '.$buffer[8].$buffer[9].':'.$buffer[10].$buffer[11];
               $fecha_examen = strtotime($buffer);
               $fecha_actual = strtotime(Date('Y').Date('m').Date('d').Date('H').Date('i').Date('s'));

               //echo $fecha_actual - $fecha_examen."<br>".$tiempo_examen;
                 //if(($fecha_examen >= $fecha_entrada) && ($fecha_examen < ($fecha_entrada + $tiempo_examen * 60)))
               if(($fecha_actual - $fecha_examen) > ($tiempo_examen * 60))
                    $utilizado = 1;                                   
         }
    }
    
    //si nadie lo ha utilizado, entonces lo creo.
    if(($existe == 0)){               
        $_SESSION[utilizado] = $nomfich;
    }
    $_SESSION[alu] = $_POST[alu];

    //Necesito guardar el nombre de la asignatura como sesion
    //Cargo el excel
    $objPHPExcel = $objReader->load('./cursos/'.$curso.'/alumnos/'.$_POST["asig"]);

    //Activo la hoja de calculo
    $objWorksheet = $objPHPExcel->getActiveSheet();

    //Leo el nombre de la asignatura
    $cell = $objWorksheet->getCell('B1');

    $_SESSION[asig] = $cell->getValue();

    //Evaluacion de errores
    if($fecha_correcta != 1)
        echo "<div style=\"border:0px; background:#FFF\" class=\"mensajeInformativo error errorseo\"><div class=\"top\"><div class=\"bottom\"><p><span class=\"icono\">Informacion: </span><strong>No hay ning&uacute;n test programado o tal vez todav&iacute;a no es la hora.</strong></p></div></div></div>";
    else{
        if($utilizado == 1){
            echo "<div style=\"border:0px; background:#FFF\" class=\"mensajeInformativo error errorseo\"><div class=\"top\"><div class=\"bottom\"><p><span class=\"icono\"></span><strong>Tu tiempo ya se ha consumido !!.</strong></p></div></div>";
        }
        else{
            //Acceso autorizado
            echo '<input onclick="location.href=\'pagetest.php\'" type="reset" value="Entrar" class="boton" style="font-size:13px;"/>';
        }
    }
}

?>