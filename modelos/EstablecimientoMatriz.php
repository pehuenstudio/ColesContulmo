<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Establecimiento.php";
class EstablecimientoMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Establecimiento $establecimiento){
        $matriz = array(
            "rbd_establecimiento" => $establecimiento->get_rbd_establecimiento(),
            "nombre" => $establecimiento->get_nombre(),
            "telefono" => $establecimiento->get_telefono(),
            "id_direccion" => $establecimiento->get_id_direccion(),
            "estado" => $establecimiento->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_establecimientos(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_establecimientos");
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $establecimiento = new Establecimiento();
            $establecimiento->set_identidad(
                $row["rbd_establecimiento"],
                $row["nombre"],
                $row["telefono"],
                $row["id_direccion"]
            );

            $this->to_matriz($establecimiento);
        }

        return $sentencia->rowCount();
    }

    public function db_get_establecimientos_by_run_profesor($run_profesor){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_establecimientos_by_run_profesor(?)");
        $sentencia->bindParam(1, $run_profesor, \PDO::PARAM_STR, 9);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $establecimiento = new Establecimiento();
            $establecimiento->set_identidad(
                $row["rbd_establecimiento"],
                $row["nombre"],
                $row["telefono"],
                $row["id_direccion"]
            );

            $this->to_matriz($establecimiento);
        }

        return $sentencia->rowCount();
    }
}
?>