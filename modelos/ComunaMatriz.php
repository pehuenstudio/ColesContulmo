<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Comuna.php";
class ComunaMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Comuna $comuna){
        $matriz = array(
            "id_comuna" => $comuna->get_id_comuna(),
            "id_provincia" => $comuna->get_id_provincia(),
            "nombre" => $comuna->get_nombre(),
            "estado" => $comuna->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_comunas_by_id_provincia($id_provincia){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_comunas_by_id_provincia(?)");
        $sentencia->bindParam(1, $id_provincia, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $comuna = new Comuna();
            $comuna->set_id_comuna($row["id_comuna"]);
            $comuna->set_identidad(
                $row["id_provincia"],
                $row["nombre"]
            );
            $this->to_matriz($comuna);
        }

        return $sentencia->rowCount();
    }
}
?>