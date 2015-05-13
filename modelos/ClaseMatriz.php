<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Clase.php";
//echo __FILE__."<br/>";
class ClaseMatriz {
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

    public function to_matriz(Clase $clase){
        $matriz = array(
            "id_clase" => $clase->get_id_clase(),
            "run_profesor" => $clase->get_run_profesor(),
            "id_curso" => $clase->get_id_curso(),
            "id_asignatura" => $clase->get_id_asignatura(),
            "id_bloque" => $clase->get_id_bloque(),
            "rbd_establecimiento" => $clase->get_rbd_establecimiento(),
            "estado" => $clase->get_estado()
        );
        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz,JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_ingresar(){
        foreach($this->matriz as $row){
            $clase = new Clase();
            $clase->set_identidad(
                $row["id_curso"],
                $row["id_asignatura"],
                $row["id_bloque"],
                $row["rbd_establecimiento"]
            );
            $clase->db_ingresar();
        }
    }

    public function db_actualizar_estado($estado){
        foreach($this->matriz as $row){
            $clase = new Clase();
            $clase->set_identidad(
                $row["id_curso"],
                $row["id_asignatura"],
                $row["id_bloque"],
                $row["rbd_establecimiento"]
            );
            $clase->db_actualizar_estado($estado);
        }
    }
    public function db_get_datos($id_curso, $rbd_establecimiento){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_clases(?,?)");
        $sentencia->bindParam(1, $id_curso, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $rbd_establecimiento, \PDO::PARAM_INT);
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $clase = new Clase();
            $clase->set_identidad(
                $row["id_curso"],
                $row["id_asignatura"],
                $row["id_bloque"],
                $row["rbd_establecimiento"]
            );
            $this->to_matriz($clase);
        }

    }

}
?> 