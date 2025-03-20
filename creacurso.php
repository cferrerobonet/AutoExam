<?

session_start();
require_once('funciones.php');

if(!(file_exists('./cursos/'.Date('Y').'-'.(Date('Y')+1)))){

    $_SESSION['cc'] = 1;
    
    //Si no existia ya, lo creo
    mkdir('./cursos/'.Date('Y').'-'.(Date('Y')+1), 0700);
    mkdir('./cursos/'.Date('Y').'-'.(Date('Y')+1).'/notas', 0700);
    mkdir('./cursos/'.Date('Y').'-'.(Date('Y')+1).'/correcciones', 0700);
    mkdir('./cursos/'.Date('Y').'-'.(Date('Y')+1).'/alumnos', 0700);
    mkdir('./cursos/'.Date('Y').'-'.(Date('Y')+1).'/examenes', 0700);   

}
else
    $_SESSION['cc'] = 0;



?>