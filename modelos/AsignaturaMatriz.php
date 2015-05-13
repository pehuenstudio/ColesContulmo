<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Asignatura.php";
//echo __FILE__."<br/>";
class AsignaturaMatriz {
    private $matriz = array();

    function __construct(){}

    public function set_matriz($matriz)
    {
        $this->matriz = $matriz;
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Asignatura $asignatura){
        $matriz = array(
            "id_asignatura" => $asignatura->get_id_asignatura(),
            "id_asignatura_tipo" => $asignatura->get_id_asignatura_tipo(),
            "nombre" => $asignatura->get_nombre(),
            "rbd_establecimiento" => $asignatura->get_rbd_establecimiento(),
            "descripcion" => $asignatura->get_descripcion(),
            "estado" => $asignatura->get_estado()
        );
        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_datos($id_asignatura_tipo){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_asignaturas(?)");
        $sentencia->bindParam(1, $id_asignatura_tipo, \PDO::PARAM_INT);
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $asignatura = new Asignatura();
            $asignatura->set_identidad(
                $row["id_asignatura_tipo"],
                $row["rbd_establecimiento"],
                $row["nombre"]
            );
            $asignatura->set_id_asignatura($row["id_asignatura"]);
            $asignatura->set_descripcion($row["descripcion"]);

            $this->to_matriz($asignatura);
        }

        return $result;
    }
}
?> 