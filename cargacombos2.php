<?

/** Clases necesarias */
set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
require_once('PHPExcel.php');
require_once('funciones.php');
require_once('PHPExcel/Reader/Excel2007.php');

//Acabo de elegir un curso y cargo combo de asignaturas
if(isset($_POST["curso"]) && !isset($_POST["asig"])){

    //Creo un objeto Excel 2007
    $objReader = new PHPExcel_Reader_Excel2007();

    //Muestro los cursos que hay
    $directorio = opendir('./cursos/'.$_POST["curso"].'/alumnos');

    echo '<h3>Elige una asignatura:</h3>
            <SELECT onchange= "FAjax(\'cargacombos2.php\',\'exa\',\'curso='.$_POST["curso"].'&asig=\' + document.forms.notas.asignaturas.value,\'post\');" NAME="asignaturas" style="font-size:13px">
            <OPTION SELECTED VALUE="0">Selecciona asignatura';
    
    while ($file = readdir($directorio)){

          if ($file != '.' && $file != '..' && $file[0] != '.'){

                //Cargo el excel
                $objPHPExcel = $objReader->load('./cursos/'.$_POST["curso"].'/alumnos/'.$file);

                //Activo la hoja de calculo
                $objWorksheet = $objPHPExcel->getActiveSheet();

                //Leo el nombre de la asignatura
                $cell = $objWorksheet->getCell('B1');

                //Muestro el nombre
                echo '<OPTION VALUE="'.$file.'">'.$cell->getValue();
          }           
    }
    echo '</SELECT>
            <br><br><br>';
    
    closedir('./cursos/'.$_POST["curso"].'/alumnos');       
}

//Acabo de elegir un curso y cargo combo de asignaturas
if(isset($_POST["curso"]) && isset($_POST["asig"])){

    //Creo un objeto Excel 2007
    $objReader = new PHPExcel_Reader_Excel2007();

    //Si no es porque quiero ver el examen de un alumno en concreto
    $directorio = opendir('./cursos/'.$_POST["curso"].'/examenes');

    echo '<h3>Elige un ex&aacute;men:</h3>';
    
    //Cargamos en el combo de examenes todas las coincidencias de examenes
    while ($file = readdir($directorio)){

          if ($file != '.' && $file != '..'){

               $nomfich = substr($_POST["asig"],0,strlen($_POST["asig"])-5);                              
               
               if(substr_count($file, $nomfich)>0){
                   $examen = explode('_', $file);
                   $fecha_examen = $examen[count($examen)-1];
                   $fecha_examen = substr($fecha_examen,0,strlen($fecha_examen)-5);
                   $fecha_examen = $fecha_examen[6].$fecha_examen[7].'-'.$fecha_examen[4].$fecha_examen[5].'-'.$fecha_examen[0].$fecha_examen[1].$fecha_examen[2].$fecha_examen[3].' '.$fecha_examen[8].$fecha_examen[9].':'.$fecha_examen[10].$fecha_examen[11];
                   $fecha_entrada = strtotime($fecha_examen);
                   $fecha_examen = "Test ".$fecha_examen;

                   $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));                  

                   //Miramos la duración del examen para añadirsela a la hora del examen
                    $objPHPExcel = $objReader->load('./cursos/'.$_POST["curso"].'/examenes/'.$file);

                    //Activo la hoja de calculo
                    $objWorksheet = $objPHPExcel->getActiveSheet();

                    //Leo la duración del examen
                    $cell = $objWorksheet->getCell('B8');

                    $tiempo_examen = $cell->getValue();

                   //Miramos si el examen ya se ha hecho, y si se ha hecho mostramos las estadisticas
                   if($fecha_actual - ($fecha_entrada + $tiempo_examen * 60) >= 0){                       
                        echo '<li><a href="./cursos/'.$_POST["curso"].'/examenes/'.$file.'">'.$fecha_examen.'</a>&nbsp;&nbsp;&nbsp;<a href="./cursos/'.$_POST["curso"].'/examenes/'.$file.'"><img title=\'Descargar excel\' src=./iconos/excel.jpg></a>&nbsp;&nbsp;<img title="Test ya realizado" src=./iconos/hecho.jpg></li>';
                   }
                   else
                        echo '<li><a href="./cursos/'.$_POST["curso"].'/examenes/'.$file.'">'.$fecha_examen.'</a>&nbsp;&nbsp;&nbsp;<a href="./cursos/'.$_POST["curso"].'/examenes/'.$file.'"><img title=\'Descargar excel\' src=./iconos/excel.jpg></a>&nbsp;&nbsp;<img title="Test programado" src=./iconos/nohecho.jpg></li>';
               }
          }
    }
    echo '<br><br><br>';

    closedir('./cursos/'.$_POST["curso"].'/examenes');
}


?>