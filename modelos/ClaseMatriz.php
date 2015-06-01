<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Clase.php";
class ClaseMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
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
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_clases_by_id_curso($id_curso){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_clases_by_id_curso(?)");
        $sentencia->bindParam(1, $id_curso, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $clase = new Clase();
            $clase->set_id_clase($row["id_clase"]);
            $clase->set_identidad(
                $row["id_curso"],
                $row["id_asignatura"],
                $row["id_bloque"],
                $row["rbd_establecimiento"]
            );
            $clase->set_run_profesor($row["run_profesor"]);

            $this->to_matriz($clase);
        }

        return $sentencia->rowCount();
    }

    public function db_upd_clases_run_profesor_and_id_asignatura_by_id(){
        $matriz = $this->get_matriz();
        foreach($matriz as $row){
            $clase = new Clase();
            $clase->set_id_clase($row["id_clase"]);
            $clase->set_run_profesor($row["run_profesor"]);
            $clase->set_id_asignatura($row["id_asignatura"]);

            $clase->db_upd_clase_run_profesor_and_id_asignatura_by_id();
        }
    }
}
?>