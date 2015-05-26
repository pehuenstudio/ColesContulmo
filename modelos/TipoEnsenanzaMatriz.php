<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/TipoEnsenanza.php";
class TipoEnsenanzaMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(TipoEnsenanza $tipo_ensenanza){
        $matriz = array(
            "id_tipo_ensenanza" => $tipo_ensenanza->get_id_tipo_ensenanza(),
            "nombre" => $tipo_ensenanza->get_nombre(),
            "estado" => $tipo_ensenanza->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_tipos_ensenanza_by_rbd_establecimiento($rbd_establecimiento){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_tipos_ensenanza_by_rbd_establecimiento(?)");
        $sentencia->bindParam(1, $rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $tipo_ensenanza = new TipoEnsenanza();
            $tipo_ensenanza->set_id_tipo_ensenanza($row["id_tipo_ensenanza"]);
            $tipo_ensenanza->set_identidad($row["nombre"]);

            $this->to_matriz($tipo_ensenanza);
        }

        return $sentencia->rowCount();
    }
}
?>