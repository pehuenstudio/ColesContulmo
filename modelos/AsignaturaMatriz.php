<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Asignatura.php";
class AsignaturaMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
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
            "color1" => $asignatura->get_color1(),
            "color2" => $asignatura->get_color2(),
            "estado" => $asignatura->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_asignaturas_by_rbd_establecimiento_and_id_tipo_asignatura($rbd_establecimiento, $id_tipo_asignatura){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_asignaturas_by_rbd_establecimiento_and_id_tipo_asignatura(?,?)");
        $sentencia->bindParam(1, $rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $id_tipo_asignatura, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $asignatura = new Asignatura();
            $asignatura->set_id_asignatura($row["id_asignatura"]);
            $asignatura->set_identidad(
                $row["id_asignatura_tipo"],
                $row["rbd_establecimiento"],
                $row["nombre"],
                $row["descripcion"]
            );
            $asignatura->set_color1($row["color1"]);
            $asignatura->set_color2($row["color2"]);

            $this->to_matriz($asignatura);
        }

        return $sentencia->rowCount();
    }

    public function db_get_asignaturas_by_run_profesor_and_id_curso($run_profesor, $id_curso){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_asignaturas_by_run_profesor_and_id_curso(?,?)");
        $sentencia->bindParam(1, $run_profesor, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $id_curso, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $asignatura = new Asignatura();
            $asignatura->set_id_asignatura($row["id_asignatura"]);
            $asignatura->set_identidad(
                $row["id_asignatura_tipo"],
                $row["rbd_establecimiento"],
                $row["nombre"],
                $row["descripcion"]
            );
            $asignatura->set_color1($row["color1"]);
            $asignatura->set_color2($row["color2"]);

            $this->to_matriz($asignatura);
        }

        return $sentencia->rowCount();

    }

    public function get_asignaturas_by_id_curso($id_curso){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_asignaturas_by_id_curso(?)");
        $sentencia->bindParam(1, $id_curso, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $asignatura = new Asignatura();
            $asignatura->set_id_asignatura($row["id_asignatura"]);
            $asignatura->set_identidad(
                $row["id_asignatura_tipo"],
                $row["rbd_establecimiento"],
                $row["nombre"],
                $row["descripcion"]
            );
            $asignatura->set_color1($row["color1"]);
            $asignatura->set_color2($row["color2"]);

            $this->to_matriz($asignatura);
        }

        return $sentencia->rowCount();
    }
}
?>