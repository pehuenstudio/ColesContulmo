<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Bloque.php";
class BloqueMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Bloque $bloque){
        $matriz = array(
            "id_bloque" => $bloque->get_id_bloque(),
            "rbd_establecimiento" => $bloque->get_rbd_establecimiento(),
            "id_ciclo" => $bloque->get_id_ciclo(),
            "id_dia" => $bloque->get_id_dia(),
            "hora_inicio" => $bloque->get_hora_inicio(),
            "hora_fin" => $bloque->get_hora_fin()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_bloques_by_run_profe_and_id_curso_and_id_asignatura($run_profesor, $id_curso, $id_asignatura){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_bloques_by_run_profe_and_id_curso_and_id_asignatura(?,?,?)");
        $sentencia->bindParam(1, $run_profesor, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $id_curso, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $id_asignatura, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $bloque = new Bloque();
            $bloque->set_id_bloque($row["id_bloque"]);
            $bloque->set_identidad(
                $row["rbd_establecimiento"],
                $row["id_ciclo"],
                $row["id_dia"],
                $row["hora_inicio"],
                $row["hora_fin"]
            );

            $this->to_matriz($bloque);
        }

        $sentencia->rowCount();
    }

    public function db_get_bloques_by_run_profe_and_id_cur_and_id_asig_and_id_dia($run_profesor, $id_curso, $id_asignatura, $id_dia){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_bloques_by_run_profe_and_id_cur_and_id_asig_and_id_dia(?,?,?,?)");
        $sentencia->bindParam(1, $run_profesor, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $id_curso, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $id_asignatura, \PDO::PARAM_INT);
        $sentencia->bindParam(4, $id_dia, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $bloque = new Bloque();
            $bloque->set_id_bloque($row["id_bloque"]);
            $bloque->set_identidad(
                $row["rbd_establecimiento"],
                $row["id_ciclo"],
                $row["id_dia"],
                $row["hora_inicio"],
                $row["hora_fin"]
            );

            $this->to_matriz($bloque);
        }

        $sentencia->rowCount();
    }
}
?>