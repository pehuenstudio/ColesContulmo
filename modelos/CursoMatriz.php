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
            "periodo" => $curso->get_periodo(),
            "estado" => $curso->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_cursos_by_rbd_esta_and_id_tipo_ense_and_id_grado_and_periodo($rbd_establecimiento,
                                                                                 $id_tipo_ensenanza, $id_grado, $periodo){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_cursos_by_rbd_esta_and_id_tipo_ense_and_id_grado_and_periodo(?,?,?,?)");
        $sentencia->bindParam(1, $rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $id_grado, \PDO::PARAM_INT);
        $sentencia->bindParam(4, $periodo, \PDO::PARAM_INT);
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

    public function db_get_cursos_by_rbd_establecimiento_and_id_ciclo_and_periodo($rbd_establecimiento, $id_ciclo, $periodo){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_cursos_by_rbd_establecimiento_and_id_ciclo_and_periodo(?,?,?)");
        $sentencia->bindParam(1, $rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $id_ciclo, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $periodo, \PDO::PARAM_INT);
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

            $curso->set_periodo($row["periodo"]);
            $this->to_matriz($curso);
        }

        return $sentencia->rowCount();
    }

    public function db_get_cursos_by_run_profesor_and_rbd_establecimiento_and_periodo($run_profesor,
                                                                                      $rbd_establecimiento, $periodo){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_cursos_by_run_profesor_and_rbd_establecimiento_and_periodo(?,?,?)");
        $sentencia->bindParam(1, $run_profesor, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $periodo, \PDO::PARAM_INT);

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
            $curso->set_periodo($row["periodo"]);
            $this->to_matriz($curso);
        }

        return $sentencia->rowCount();
    }


}

?>