<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Provincia.php";
class ProvinciaMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Provincia $provincia){
        $matriz = array(
            "id_provincia" => $provincia->get_id_provincia(),
            "id_region" => $provincia->get_id_region(),
            "nombre" => $provincia->get_nombre(),
            "prefijo_telefonico" => $provincia->get_prefijo_telefonico(),
            "estado" => $provincia->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_provincias_by_id_region($id_region){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_provincias_by_id_region(?)");
        $sentencia->bindParam(1, $id_region, \PDO::PARAM_INT);
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $provincia = new Provincia();
            $provincia->set_id_provincia($row["id_provincia"]);
            $provincia->set_identidad(
                $row["id_region"],
                $row["nombre"],
                $row["prefijo_telefonico"]
            );

            $this->to_matriz($provincia);
        }

        return $result;
    }
}
?>