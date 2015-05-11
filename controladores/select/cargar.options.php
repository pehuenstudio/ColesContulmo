
<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";

//echo __FILE__."<br/>";

if(!isset($_GET["id_key"])){
    //TODO: CERRAR ESTA ARCHIVO HACIA VISITAS NO AUTORIZADAS header("Location: http://".$_SERVER['HTTP_HOST']);

}
if(!isset($_GET["procedimiento"])){
    //TODO: CERRAR ESTA ARCHIVO HACIA VISITAS NO AUTORIZADAS header("Location: http://".$_SERVER['HTTP_HOST']);

}
if(!isset($_GET["pk"])){
    //TODO: CERRAR ESTA ARCHIVO HACIA VISITAS NO AUTORIZADAS header("Location: http://".$_SERVER['HTTP_HOST']);

}
$id_key = $_GET["id_key"];
switch($id_key){
    case 1:
        $fk= "";
        $procedimiento = "get_regiones";
        $pk = "id_region";
        break;
    case 2:
        $fk= $_GET["fk"];
        $procedimiento = "get_provincias";
        $pk = "id_provincia";
        break;
    case 3:
        $fk= $_GET["fk"];
        $procedimiento = "get_comunas";
        $pk = "id_comuna";
        break;
    case 4:
        $fk = "";
        $procedimiento = "get_religiones";
        $pk = "id_religion";
        break;
    case 5:
        $fk = "";
        $procedimiento = "get_grados_educacionales";
        $pk = "id_grado_educacional";
        break;
    case 6:
        $fk = "";
        $procedimiento = "get_establecimientos";
        $pk = "rbd_establecimiento";
        break;
    case 7:
        $fk = $_GET["fk"];
        $procedimiento = "get_establecimientos_tipos_ensenanza";
        $pk = "id_tipo_ensenanza";
        break;
    case 8:
        $fk = $_GET["fk"].",".$_GET["fk2"];
        $procedimiento = "get_establecimientos_grados";
        $pk = "id_grado";
        break;
    case 9:
        $fk = $_GET["fk"].",".$_GET["fk2"].",".$_GET["fk3"];
        $procedimiento = "get_establecimientos_grados_grupos";
        $pk = "grupo";
        break;
    case 9:
        $fk = $_GET["fk"].",".$_GET["fk2"].",".$_GET["fk3"];
        $procedimiento = "get_establecimientos_grados_grupos";
        $pk = "grupo";
        break;
    //get_establecimientos_cursos
    default:
        //TODO: CERRAR ESTA ARCHIVO HACIA VISITAS NO AUTORIZADAS header("Location: http://".$_SERVER['HTTP_HOST']);
        break;
}
//echo "CALL ".$procedimiento."(".$fk.")";
$result = $myPDO->query("CALL ".$procedimiento."(".$fk.")");
foreach($result as $row){
    echo "<option value='".$row[$pk]."'>".$row["nombre"]."</option>";
}



?>
 