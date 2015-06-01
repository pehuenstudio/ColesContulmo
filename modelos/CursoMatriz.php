<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Curso.php";
class CursoMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Curso $curso){
        $matriz = array(
            "id_curso" => $curso->get_id_curso(),
            "rbd_establecimiento" => $curso->get_rbd_establecimiento(),
            "run_profesor_jefe" => $curso->get_run_profesor_jefe(),
            "id_grado" => $curso->get_id_grado(),
            "id_tipo_ensenanza" => $curso->get_id_tipo_ensenanza(),
            "id_ciclo" => $curso->get_id_ciclo(),
            "grupo" => $curso->get_grupo(),
            "estado" => $curso->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_cursos_by_rbd_esta_and_id_tipo_ensenanza_and_id_grado($rbd_establecimiento,
                                                                                 $id_tipo_ensenanza, $id_grado){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_cursos_by_rbd_esta_and_id_tipo_ensenanza_and_id_grado(?,?,?)");
        $sentencia->bindParam(1, $rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $id_grado, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);

        foreach($data as $row){
            $curso = new Curso();
            $curso->set_id_curso($row["id_curso"]);
            $curso->set_identidad(
                $row["rbd_establecimiento"],
                $row["run_profesor_jefe"],
                $row["id_grado"],
                $row["id_tipo_ensenanza"],
                $row["id_ciclo"],
                $row["grupo"]
            );

            $this->to_matriz($curso);
        }

        return $sentencia->rowCount();

    }

    public function db_get_cursos_by_rbd_establecimiento_and_id_ciclo($rbd_establecimiento, $id_ciclo){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_cursos_by_rbd_establecimiento_and_id_ciclo(?,?)");
        $sentencia->bindParam(1, $rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $id_ciclo, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $curso = new Curso();
            $curso->set_id_curso($row["id_curso"]);
            $curso->set_identidad(
                $row["rbd_establecimiento"],
                $row["run_profesor_jefe"],
                $row["id_grado"],
                $row["id_tipo_ensenanza"],
                $row["id_ciclo"],
                $row["grupo"]
            );

            $this->to_matriz($curso);
        }

        return $sentencia->rowCount();
    }
}

?>