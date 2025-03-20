<?
/** Clases necesarias */
set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
require_once('PHPExcel.php');
require_once('funciones.php');
require_once('PHPExcel/Reader/Excel2007.php');

//Acabo de elegir un curso y cargo combo de asignaturas
if(isset($_POST["curso"]) && !isset($_POST["asig"]) && !isset($_POST["alu"])){

    //Creo un objeto Excel 2007
    $objReader = new PHPExcel_Reader_Excel2007();

    //Muestro los cursos que hay
    $directorio = opendir('./cursos/'.$_POST["curso"].'/alumnos');

    echo '<h3>Elige una asignatura:</h3>
            <SELECT onchange= "document.getElementById(\'exa\').innerHTML = \'\'; FAjax(\'cargacombos.php\',\'alu\',\'curso='.$_POST["curso"].'&asig=\' + document.forms.notas.asignaturas.value,\'post\');" NAME="asignaturas" style="font-size:13px">
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

//Acabo de elegir una asignatura y cargo combo de alumnos
if(isset($_POST["curso"]) && isset($_POST["asig"]) && !isset($_POST["alu"])){

    //Creo un objeto Excel 2007
    $objReader = new PHPExcel_Reader_Excel2007();

    echo '<h3>Elige un alumno:</h3>
            <SELECT onchange= "FAjax(\'cargacombos.php\',\'exa\',\'alu=\' + document.forms.notas.alumnos.value + \'&curso='.$_POST["curso"].'&asig=\' + document.forms.notas.asignaturas.value,\'post\');" NAME="alumnos" style="font-size:13px">
            <OPTION SELECTED VALUE="0">Selecciona alumno';

    //Cargo el excel
    $objPHPExcel = $objReader->load('./cursos/'.$_POST["curso"].'/alumnos/'.$_POST['asig']);

    //Activo la hoja de calculo
    $objWorksheet = $objPHPExcel->getActiveSheet();

    $i = 4;

    //Leo el nombre del alumno
    while(($cell = $objWorksheet->getCell('A'.$i)) && (strlen($cell->getValue()) > 0)){
        //Muestro el nombre
        echo '<OPTION VALUE="'.$cell->getValue().'">'.ucwords($cell->getValue());
        $i++;
    }
    echo '<OPTION VALUE="TODOS" onclick= "FAjax(\'cargacombos.php\',\'exa\',\'alu=\' + document.forms.notas.alumnos.value + \'&curso='.$_POST["curso"].'&asig=\' + document.forms.notas.asignaturas.value,\'post\');">TODOS';
    
    echo '</SELECT>
            <br><br><br>';
}

//Acabo de elegir un curso y cargo combo de asignaturas
if(isset($_POST["curso"]) && isset($_POST["asig"]) && isset($_POST["alu"])){

    //Aqui vemos los examenes que han terminado y construimos las notas que todavia no esten.
    if($_POST["alu"] == "TODOS")
        CreaNotas();

    //Creo un objeto Excel 2007
    $objReader = new PHPExcel_Reader_Excel2007();

    //Si he elegido todos los alumnos es porque quiero ver la lista entera de notas de un examen
    if($_POST["alu"] == "TODOS"){
        //Muestro los cursos que hay
        $directorio = opendir('./cursos/'.$_POST["curso"].'/notas');
    }
    else{
        //Si no es porque quiero ver el examen de un alumno en concreto
        $directorio = opendir('./cursos/'.$_POST["curso"].'/correcciones');
    }

    echo '<h3>Elige un ex&aacute;men:</h3>';
    //Cargamos en el combo de examenes todas las coincidencias de examenes
    while ($file = readdir($directorio)){

          if ($file != '.' && $file != '..'){

               $nomfich = substr($_POST["asig"],0,strlen($_POST["asig"])-5);
               
               if($_POST["alu"]!="TODOS"){
                   $nom = strtolower(LimpiarCadena($_POST["alu"]));
                   $nom = str_replace(" ", "_", $nom);
                   $nomfich = $nomfich."_".$nom;
               }
               
               if(substr_count($file, $nomfich)>0){
                   $examen = explode('_', $file);
                   $fecha_examen = $examen[count($examen)-1];
                   
                   $fecha_examen = substr($fecha_examen,0,strlen($fecha_examen)-5);

                   if($_POST["alu"]!="TODOS")
                        $fecha_examen = $fecha_examen[6].$fecha_examen[7].'-'.$fecha_examen[4].$fecha_examen[5].'-'.$fecha_examen[0].$fecha_examen[1].$fecha_examen[2].$fecha_examen[3]." ".$fecha_examen[8].$fecha_examen[9].":".$fecha_examen[10].$fecha_examen[11];
                   else
                       $fecha_examen = $fecha_examen[6].$fecha_examen[7].'-'.$fecha_examen[4].$fecha_examen[5].'-'.$fecha_examen[0].$fecha_examen[1].$fecha_examen[2].$fecha_examen[3]." ".$fecha_examen[8].$fecha_examen[9].":".$fecha_examen[10].$fecha_examen[11];

                   $fecha_examen = "Test ".$fecha_examen;

                   if($_POST["alu"] == "TODOS")
                        echo '<li><a href="./cursos/'.$_POST["curso"].'/notas/'.$file.'">'.$fecha_examen.'</a>&nbsp;&nbsp;&nbsp;<a href="./cursos/'.$_POST["curso"].'/notas/'.$file.'"><img src=./iconos/excel.jpg title=\'Descargar excel\'></a></li>';                   
                   else
                        echo '<li><a href="./cursos/'.$_POST["curso"].'/correcciones/'.$file.'">'.$fecha_examen.'</a>&nbsp;&nbsp;&nbsp;<a href="./cursos/'.$_POST["curso"].'/correcciones/'.$file.'"><img src=./iconos/excel.jpg title=\'Descargar excel\'></a></li>';                   
               }
          }
    }
    echo '<br><br><br>';

    if($_POST["alu"] == "TODOS")
        closedir('./cursos/'.$_POST["curso"].'/notas');
    else
        closedir('./cursos/'.$_POST["curso"].'/correcciones');
}


?>