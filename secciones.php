<? require('config.php'); ?>
<? require('funciones.php'); ?>

<?

$action = addslashes($_POST['action']);
$id = addslashes($_POST['id']);

//Eliminamos la seccion
if(($action == "eliminar") && (isset($id))){
    //Conectamos con la base de datos
    $enlace = Conecta($servidor, $usuario, $password, $bd);

    //Seleccionamos las categorias que hay de fotos
    $result = Consulta("DELETE FROM galeria_tipos WHERE idtipo = $id");

    echo '<div style="float:left; border:1px solid #17BF7D; font-family:\'Trebuchet MS\', Georgia, \'Times New Roman\', Times, serif; margin-bottom:15px; margin-right:11px; font-size:8px; background:#EFFFF7; padding: 4px; width:450px;"><div class="titular_link_g3" align=Center>Secci&oacute;n eliminada correctamente.</div></div>';
}
else    
    echo '<div style="float:left; border:1px solid #BF2F2F; font-family:\'Trebuchet MS\', Georgia, \'Times New Roman\', Times, serif; margin-bottom:15px; margin-right:11px; font-size:8px; background:#FFCFCF; padding: 4px; width:450px;"><div class="titular_link_g4" align=Center>ERROR eliminando secci&oacute;n de galer&iacute;as.</div></div>';

?>