<?
set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
require_once('PHPExcel.php');
require_once('PHPExcel/Reader/Excel2007.php');
require_once('PHPExcel/Writer/Excel2007.php');
?>

<?
//Limpio una cadena de acentos y caracteres raros
//Se encarga de que todo sea alfanumerico
function LimpiarCadena($cadena, $espacios=1){

    //Quitamos acentos, eñes y dieresis
    $cadena = str_replace("á", "a", $cadena);
    $cadena = str_replace("é", "e", $cadena);
    $cadena = str_replace("í", "i", $cadena);
    $cadena = str_replace("ó", "o", $cadena);
    $cadena = str_replace("ú", "u", $cadena);
    $cadena = str_replace("Á", "A", $cadena);
    $cadena = str_replace("É", "E", $cadena);
    $cadena = str_replace("Í", "I", $cadena);
    $cadena = str_replace("Ó", "O", $cadena);
    $cadena = str_replace("Ú", "U", $cadena);
    $cadena = str_replace("ñ", "n", $cadena);
    $cadena = str_replace("Ñ", "N", $cadena);
    $cadena = str_replace("ç", "c", $cadena);
    $cadena = str_replace("Ç", "C", $cadena);
    $cadena = str_replace("ä", "a", $cadena);
    $cadena = str_replace("ë", "e", $cadena);
    $cadena = str_replace("ï", "i", $cadena);
    $cadena = str_replace("ö", "o", $cadena);
    $cadena = str_replace("ü", "u", $cadena);
    $cadena = str_replace("Ä", "A", $cadena);
    $cadena = str_replace("Ë", "E", $cadena);
    $cadena = str_replace("Ï", "I", $cadena);
    $cadena = str_replace("Ö", "O", $cadena);
    $cadena = str_replace("Ü", "U", $cadena);

    if($espacios == 1){
        //limpiamos todos los caracteres invalidos
        $nueva_cadena = preg_replace("[^ A-Za-z0-9_-]", "", $cadena);
    }
    else
        $nueva_cadena = preg_replace("[^ A-Za-z0-9_-]", "", $cadena);

    return $nueva_cadena;

}

//Compruebo si la pass y user es correcta
function ComprobarLogin(){
    
    if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
        echo "<script language=javascript>document.location.href='index.php?error=1'</script>";
    }
}

//Construye las preguntas de test a partir de la ruta de un examen
function PreguntasTest($examen){
	
    echo "<form name=\"test\" action=\"#\" method=\"POST\">";

    //Creo un objeto Excel 2007
    $objReader = new PHPExcel_Reader_Excel2007();

    //Cargo el excel
    $objPHPExcel = $objReader->load($examen);

    //Activo la hoja de calculo
    $objWorksheet = $objPHPExcel->getActiveSheet();

    $i = 10;
    $x = 0;

    unset($_SESSION['preguntas']);

    //el test es una lista doblemente enlazada, donde L1 son las preguntas del
    //test y L2 tiene en la cabeza el enunciado y en la cola las opciones
    $_SESSION['preguntas'] = Array();

    //Carga del test (solo las que tienen el campo CARGA = SI
    while(($cell = $objWorksheet->getCell('A'.$i)) && (strlen($cell->getValue()) > 0)){

        $cell2 = $objWorksheet->getCell('G'.$i);
        $carga = $cell2->getValue();

        if(strtoupper($carga) == "SI"){
        
            $_SESSION['preguntas'][$x] = Array();

            //Enunciados de preguntas
            $_SESSION['preguntas'][$x][] = utf8_decode($cell->getValue());

            //Respuesta OK
            if(($cell = $objWorksheet->getCell('B'.$i)) && (strlen($cell->getValue()) > 0))
                    $_SESSION['preguntas'][$x][] = utf8_decode($cell->getValue());


            //Respuesta KO1
            if(($cell = $objWorksheet->getCell('C'.$i)) && (strlen($cell->getValue()) > 0))
                    $_SESSION['preguntas'][$x][] = utf8_decode($cell->getValue());


            //Respuesta KO2
            if(($cell = $objWorksheet->getCell('D'.$i)) && (strlen($cell->getValue()) > 0))
                    $_SESSION['preguntas'][$x][] = utf8_decode($cell->getValue());

            //Respuesta KO3
            if(($cell = $objWorksheet->getCell('E'.$i)) && (strlen($cell->getValue()) > 0))
                    $_SESSION['preguntas'][$x][] = utf8_decode($cell->getValue());

            //Respuesta KO4
            if(($cell = $objWorksheet->getCell('F'.$i)) && (strlen($cell->getValue()) > 0))
                    $_SESSION['preguntas'][$x][] = utf8_decode($cell->getValue());

        }
            $i++;
            $x++;
    }
    
    mt_srand (time());

    foreach($_SESSION['preguntas'] as $x=>$y){
        $valor = $x;
        break;
    }
    //estas variables las necesito para cuando termina el tiempo y hay que contruir la cadena ajax
    echo '<script language=javascript>numpreg='.count($_SESSION['preguntas']).'; numresp='.(count($_SESSION['preguntas'][$valor])-1).';</script>';

    shuffle($_SESSION['preguntas']);

    //Preparo las respuestas de forma aleatoria
    foreach($_SESSION['preguntas'] as $x=>$y){
        
        echo "<h3 style=\"font-size:18px;\"><strong>".($x+1).") </strong>".utf8_encode($_SESSION['preguntas'][$x][0])."</h3><br>";
                
        
        $numrand = mt_rand(1,count($_SESSION['preguntas'][$x]) - 1);
        
        $i = 1;
        
        while($i < count($_SESSION['preguntas'][$x])){

            if($numrand == count($_SESSION['preguntas'][$x]))
                $numrand++;
                        
            echo "<h4><input type=\"radio\" name=\"option".($x+1)."\" value=\"".utf8_encode($_SESSION['preguntas'][$x][$numrand % count($_SESSION['preguntas'][$x])])."\">&nbsp;&nbsp;".utf8_encode($_SESSION['preguntas'][$x][$numrand % count($_SESSION['preguntas'][$x])])."</h4><br>";
            $numrand++;
            $i++;
        }

        //Código para desmarcar cualquier opción de la pregunta (contestar en blanco)
        $z = 1;
        $zz = 0;

        echo "<a onclick=\"";
        while($z < count($_SESSION['preguntas'][$x])){
            echo "document.forms['test'].elements[".($zz + ((count($_SESSION['preguntas'][$x])-1)*($x)))."].checked = false;";
            $z++;
            $zz++;
        }
        echo "\" style=\"font-size:12px;text-decoration:underline;cursor:pointer;\">Pulsa para desmarcar la opci&oacute;n</a><br><br><br>";
        
    
     $cuenta++;
    }
  
    echo '<div align=center><INPUT style="font-size:18px;" TYPE=button NAME=envio VALUE="Finalizar Test" onclick="quedan_mins=-1; numpreg='.count($_SESSION['preguntas']).'; numresp='.(count($_SESSION['preguntas'][0])-1).'; Tempo();"></div>';
    echo "</form>";
}

//Procedimiento para crear las notas globales
function CreaNotas(){

    //Creo un objeto Excel 2007
    $objReader = new PHPExcel_Reader_Excel2007();

    $directorio = opendir('./cursos/'.$_POST["curso"].'/examenes');

    //Cargamos en el combo de examenes todas las coincidencias de examenes
    while ($file = readdir($directorio)){

          if ($file != '.' && $file != '..'){

               $nomfich = substr($_POST["asig"],0,strlen($_POST["asig"])-5);

               if(substr_count($file, $nomfich)>0){
                   $examen = explode('_', $file);
                   $fecha_examen = $examen[count($examen)-1];
                   $fecha_examen = substr($fecha_examen,0,strlen($fecha_examen)-5);
                   $aux = $fecha_examen;
                   $hora = substr($aux,8,strlen($aux));                                      
                   $fecha_examen = $fecha_examen[6].$fecha_examen[7].'-'.$fecha_examen[4].$fecha_examen[5].'-'.$fecha_examen[0].$fecha_examen[1].$fecha_examen[2].$fecha_examen[3].' '.$fecha_examen[8].$fecha_examen[9].':'.$fecha_examen[10].$fecha_examen[11];
                   $fecha_entrada = strtotime($fecha_examen);
                   $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));

                   //Miramos la duración del examen para añadirsela a la hora del examen
                    $objPHPExcel = $objReader->load('./cursos/'.$_POST["curso"].'/examenes/'.$file);

                    //Activo la hoja de calculo
                    $objWorksheet = $objPHPExcel->getActiveSheet();

                    //Leo la duración del examen
                    $cell = $objWorksheet->getCell('B6');
                    $tiempo_examen = $cell->getValue();

                    //leo el nombre de la asignatura
                    $cell = $objWorksheet->getCell('B2');
                    $nomasig = $nomfich;

                    //leo el numero de preguntas
                    $cell = $objWorksheet->getCell('B3');
                    $numpreg = $cell->getValue();

                    //leo el numero de alternativas
                    $cell = $objWorksheet->getCell('B4');
                    $numalter = $cell->getValue();

                    //leo la penalizacion
                    $cell = $objWorksheet->getCell('B5');
                    $penal = $cell->getValue();
                    


                   //Miramos si el examen ya se ha hecho
                   if($fecha_actual - ($fecha_entrada + $tiempo_examen * 60) >= 0){

                       //Miro si ya se calculó el fichero global de notas
                       $fichero_nota = substr($_POST["asig"],0,strlen($_POST["asig"])-5)."_".substr($aux,0,strlen($aux)-4).$hora.".xlsx";

                       //Si todavia no se han creado las notas..., las creo
                       //if (!file_exists('./cursos/'.$_POST["curso"].'/notas/'.$fichero_nota)){
                           
                            //Copiamos la plantilla de notas en el directorio correspondiente
                            copy('./plantillas/plantilla_notas.xlsx','./cursos/'.$_POST["curso"].'/notas/'.$fichero_nota);						    												
                            
							//Cargo la plantilla para editarla
                            $objReader = new PHPExcel_Reader_Excel2007();
                            $objPHPExcel = $objReader->load('./cursos/'.$_POST["curso"].'/notas/'.$fichero_nota);
							
                            //colores de celda
                            $objPHPExcel->getActiveSheet()->getStyle('A9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FAC090');
                            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FAC090');
                            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FAC090');
                            $objPHPExcel->getActiveSheet()->getStyle('A2:A6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FDE9D9');
                            $objPHPExcel->getActiveSheet()->getStyle('B2:B6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FDE9D9');
                            $objPHPExcel->getActiveSheet()->getStyle('D9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
                            $objPHPExcel->getActiveSheet()->getStyle('B9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CFFFE8');
                            $objPHPExcel->getActiveSheet()->getStyle('C9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFCFCF');
                            $objPHPExcel->getActiveSheet()->getStyle('E9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

                            //Voy rellenando los campos de configuración
                            $objPHPExcel->getActiveSheet()->SetCellValue('B2', $nomasig);
                            $objPHPExcel->getActiveSheet()->SetCellValue('B3', $numpreg);
                            $objPHPExcel->getActiveSheet()->SetCellValue('B4', $numalter);
                            $objPHPExcel->getActiveSheet()->SetCellValue('B5', $penal);
                            $objPHPExcel->getActiveSheet()->SetCellValue('B6', $tiempo_examen);


                            //Abro el excel de la asignatura
                            $objReader2 = new PHPExcel_Reader_Excel2007();
                            $objPHPExcel2 = $objReader2->load('./cursos/'.$_POST["curso"].'/alumnos/'.str_replace("_-_","-",LimpiarCadena(str_replace(" ", "_", $nomasig))).".xlsx");

                            //Activo la hoja de calculo
                            $objWorksheet2 = $objPHPExcel2->getActiveSheet();

                            $i = 4;
                            $a = 10;
				
                            //Leo el nombre del alumno
                            while(($cell2 = $objWorksheet2->getCell('A'.$i)) && (strlen($cell2->getValue()) > 0)){
																
                                //Muestro el nombre en la columna de alumnos
                                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$a, ucwords($cell2->getValue()));

                                //Miro si ese alumno hizo el examen
                                $correc = strtolower(LimpiarCadena($cell2->getValue()));
                                $correc = str_replace(" ", "_", $correc);
                                $correc = str_replace(",", "", $correc);

                                //Este es el nombre del excel de correccion (en caso de q lo hubiera hecho)
                                $nomcorrec = strtolower(str_replace("_-_","-",LimpiarCadena(str_replace(" ", "_", $nomasig)))."_".$correc."_".substr($aux,0,strlen($aux)-4).$hora.".xlsx");

                                //si existe lo abro
                                if (file_exists('./cursos/'.$_POST["curso"].'/correcciones/'.$nomcorrec)){
                                    
                                    $objReader3 = new PHPExcel_Reader_Excel2007();
                                    $objPHPExcel3 = $objReader3->load('./cursos/'.$_POST["curso"].'/correcciones/'.$nomcorrec);

                                    //Activo la hoja de calculo
                                    $objWorksheet3 = $objPHPExcel3->getActiveSheet();

                                    //Leo las respuestas correctas
                                    $cell3 = $objWorksheet3->getCell('E2');
                                    $correctas = $cell3->getValue();
                                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$a,$correctas);

                                    //Leo las respuestas en blanco
                                    $cell3 = $objWorksheet3->getCell('E3');
                                    $blancas = $cell3->getValue();
                                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$a,$blancas);

                                    //Leo las respuestas erroneas
                                    $cell3 = $objWorksheet3->getCell('E4');
                                    $erroneas = $cell3->getValue();
                                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$a, $erroneas);

                                    //Leo la nota final
                                    $cell3 = $objWorksheet3->getCell('E6');
                                    $nota = $cell3->getValue();
                                    $objPHPExcel->getActiveSheet()->getStyle('E'.$a)->getFont()->setBold(true);
                                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$a,$nota);
                                }

                                $i++;
                                $a++;
                            }

                            //Guardamos la correccion
                            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                            $objWriter->save(str_replace('.php', '.xlsx','./cursos/'.$_POST["curso"].'/notas/'.$fichero_nota));                            
                       //}                                                                              
                   }
                }
          }
    }
	flush();
    closedir('./cursos/'.$_POST["curso"].'/examenes');
}

//Redondeo a 2 decimales
function redondear_dos_decimal($valor) {
    $float_redondeado=round($valor * 100) / 100;
    return $float_redondeado;
}


//Función para sacar el valor de la altura de una imagen en proporcion a otra altura
function DameAltura($imagen) {

     $im = imagecreatefromjpeg($imagen);
     $ancho = imagesx($im);
     $alto = imagesy($im);

     $altura = 140 * $alto / $ancho;

     return $altura;
}


?>