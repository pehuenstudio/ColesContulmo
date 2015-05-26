<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Grado.php";
class GradoMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Grado $grado){
        $matriz = array(
            "id_grado" => $grado->get_id_grado(),
            "id_tipo_ensenanza" => $grado->get_id_tipo_ensenanza(),
            "nombre" => $grado->get_nombre(),
            "estado" => $grado->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_grados_by_rbd_establecimiento_and_id_tipo_ensenanza($rbd_establecimiento, $id_tipo_ensenanza){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_grados_by_rbd_establecimiento_and_id_tipo_ensenanza(?,?)");
        $sentencia->bindParam(1, $rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $grado = new Grado();
            $grado->set_identidad(
                $row["id_grado"],
                $row["id_tipo_ensenanza"],
                $row["nombre"]
            );

            $this->to_matriz($grado);
        }

        return $sentencia->rowCount();
    }
}
?>