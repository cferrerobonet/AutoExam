<?

ini_set('session.gc_maxlifetime', 7200);
ini_set("session.cookie_lifetime",7200);
session_start();
/** Clases necesarias */
set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
require_once('PHPExcel.php');
require_once('funciones.php');
require_once('PHPExcel/Reader/Excel2007.php');
require_once('PHPExcel/Writer/Excel2007.php');

//Creamos el archivo de la correccion del examen
$nom = explode('/', $_SESSION[examen]);
$nom = $nom[count($nom)-1];
$nom = substr($nom,0,strlen($nom)-5);
$alu = strtolower(LimpiarCadena($_SESSION[alu]));
$alu = str_replace(" ", "_", $alu);
$nom = explode('_', $nom);
$fecha = $nom[count($nom)-1];

$z = 0;
while($z < count($nom)-1){
    if($z != 0)
        $nomasig .= "_".$nom[$z];
    else
        $nomasig .= $nom[$z];
    $z++;
}
$alu = $alu."_".$fecha;

echo '<div align=Center><img src=./iconos/epla.gif></div>';

//Copiamos la plantilla de la correccion de examen
copy ('./plantillas/plantilla_correccion.xlsx',"./cursos/$_SESSION[curso]/correcciones/".$nomasig."_".$alu.".xlsx");

//Cargo la plantilla para editarla
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load("./cursos/$_SESSION[curso]/correcciones/".$nomasig."_".$alu.".xlsx");

//Voy rellenando los campos de configuración
$objPHPExcel->getActiveSheet()->SetCellValue('B2', $_SESSION['asig']);
$objPHPExcel->getActiveSheet()->SetCellValue('B3', count($_SESSION['preguntas']));
$objPHPExcel->getActiveSheet()->SetCellValue('B4', count($_SESSION['preguntas'][0])-1);
$objPHPExcel->getActiveSheet()->SetCellValue('B5', $_SESSION['penalizacion']);
$objPHPExcel->getActiveSheet()->SetCellValue('B6', $_SESSION['duracion']);

//Enunciados
foreach($_SESSION['preguntas'] as $x => $y){
    $objPHPExcel->getActiveSheet()->getStyle("A".($x+10))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->SetCellValue("A".($x+10), utf8_encode($_SESSION['preguntas'][$x][0]));
}

/*//Respuestas correctas
foreach($_SESSION['preguntas'] as $xx => $yy){
    foreach($_SESSION['preguntas'][$xx] as $x => $y){
        if($x == 0){
            $objPHPExcel->getActiveSheet()->getStyle("H".($xx+10))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->SetCellValue("H".($xx+10), utf8_encode($y));
        }
    }
}*/

//Opciones 1...5
foreach($_SESSION['preguntas'] as $xx => $yy){
    foreach($_SESSION['preguntas'][$xx] as $x => $y){

            $objPHPExcel->getActiveSheet()->getStyle("B".($xx+10))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("C".($xx+10))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("D".($xx+10))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("E".($xx+10))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("F".($xx+10))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            if($x == 1){
                $objPHPExcel->getActiveSheet()->SetCellValue("B".($xx+10), utf8_encode($y));
                //La respuesta correcta es tb la respuesta 1
                $objPHPExcel->getActiveSheet()->getStyle("H".($xx+10))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->SetCellValue("H".($xx+10), utf8_encode($y));
            }
            if($x == 2)
                $objPHPExcel->getActiveSheet()->SetCellValue("C".($xx+10), utf8_encode($y));
            if($x == 3)
                $objPHPExcel->getActiveSheet()->SetCellValue("D".($xx+10), utf8_encode($y));
            if($x == 4)
                $objPHPExcel->getActiveSheet()->SetCellValue("E".($xx+10), utf8_encode($y));
            if($x == 5)
                $objPHPExcel->getActiveSheet()->SetCellValue("F".($xx+10), utf8_encode($y));

    }
}

$num = 0;
$blancos = 0;
$mal = 0;
$bien = 0;

//Respuestas elegidas
while($num < count($_SESSION['preguntas'])){
    $objPHPExcel->getActiveSheet()->getStyle("G".($num+10))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->SetCellValue("G".($num+10), $_POST["option".$num]);

    //En blanco
    if(!isset($_POST["option".$num]))
        $blancos++;
    else{
        //Respuestas correctas (la buena esta en la posicion 0)
        if(utf8_decode($_POST["option".$num]) == $_SESSION['preguntas'][$num][1])
           $bien++;
        else
            $mal++;
    }
    $num++;
}

//Calificacion del test
//Correctas
$objPHPExcel->getActiveSheet()->getStyle("E2")->getFont()->getColor()->setARGB('006500');
$objPHPExcel->getActiveSheet()->SetCellValue("E2", $bien);
//En blanco
$objPHPExcel->getActiveSheet()->SetCellValue("E3", $blancos);
//Erroneas
$objPHPExcel->getActiveSheet()->getStyle("E4")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
$objPHPExcel->getActiveSheet()->SetCellValue("E4", $mal);
//NOTA
$objPHPExcel->getActiveSheet()->getStyle("E6")->getFont()->setBold(true);

if(redondear_dos_decimal(($bien - ($mal*$_SESSION['penalizacion']))/(count($_SESSION['preguntas'])/10)) < 0)
    $objPHPExcel->getActiveSheet()->SetCellValue("E6",0);
else
    $objPHPExcel->getActiveSheet()->SetCellValue("E6", redondear_dos_decimal(($bien - ($mal*$_SESSION['penalizacion']))/(count($_SESSION['preguntas'])/10)));

//Rellenos de celda
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FAC090');
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FAC090');
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FAC090');
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FAC090');
$objPHPExcel->getActiveSheet()->getStyle('A9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FAC090');
$objPHPExcel->getActiveSheet()->getStyle('A2:A6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FDE9D9');
$objPHPExcel->getActiveSheet()->getStyle('D2:D6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FDE9D9');
$objPHPExcel->getActiveSheet()->getStyle('B9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DBE5F1');
$objPHPExcel->getActiveSheet()->getStyle('C9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DBE5F1');
$objPHPExcel->getActiveSheet()->getStyle('D9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DBE5F1');
$objPHPExcel->getActiveSheet()->getStyle('E9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DBE5F1');
$objPHPExcel->getActiveSheet()->getStyle('F9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DBE5F1');
$objPHPExcel->getActiveSheet()->getStyle('G9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E3');
$objPHPExcel->getActiveSheet()->getStyle('H9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C2BC5E');

//Guardamos la correccion
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save(str_replace('.php', '.xlsx',"./cursos/$_SESSION[curso]/correcciones/".$nomasig."_".$alu.".xlsx"));


?>