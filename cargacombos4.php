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
            <SELECT onchange= "FAjax(\'cargacombos4.php\',\'alu\',\'curso='.$_POST["curso"].'&asig=\' + document.forms.notas.asignaturas.value,\'post\');" NAME="asignaturas" style="font-size:13px">
            <OPTION SELECTED VALUE="0">Selecciona asignatura';
    
    while ($file = readdir($directorio)){

          if ($file != '.' && $file != '..'){

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

    echo '<h3>Lista de alumnos:</h3>
            <SELECT size=10 NAME="alumnos" style="font-size:13px">';

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
    
    echo '</SELECT>
            <br><br><br>';

    echo '<li><a href="./cursos/'.$_POST["curso"].'/alumnos/'.$_POST['asig'].'">Descargar listado excel de alumnos</a>&nbsp;&nbsp;&nbsp;<a href="./cursos/'.$_POST["curso"].'/alumnos/'.$_POST['asig'].'><img title=\'Descargar excel\' src=./iconos/excel.jpg></a></li>';
}

?>