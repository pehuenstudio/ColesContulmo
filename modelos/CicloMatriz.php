<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Ciclo.php";
class CicloMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Ciclo $ciclo){
        $matriz = array(
            "id_ciclo" => $ciclo->get_id_ciclo(),
            "nombre" => $ciclo->get_nombre(),
            "estado" => $ciclo->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_ciclos_by_rbd_establecimiento($rbd_establecimiento){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_ciclos_by_rbd_establecimiento(?)");
        $sentencia->bindParam(1, $rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $ciclo = new Ciclo();
            $ciclo->set_id_ciclo($row["id_ciclo"]);
            $ciclo->set_identidad(
                $row["nombre"]
            );
            $this->to_matriz($ciclo);
        }
       $sentencia->rowCount();
    }
}
?>