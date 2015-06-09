<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Nota.php";
class NotaMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Nota $nota){
        $matriz = array(
            "id_nota" => $nota->get_id_nota(),
            "id_evaluacion" => $nota->get_id_evaluacion(),
            "run_alumno" => $nota->get_run_alumno(),
            "valor" => $nota->get_valor(),
            "fecha_creacion" => $nota->get_fecha_creacion(),
            "estado" => $nota->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_notas_by_id_evaluacion($id_evaluacion){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_notas_by_id_evaluacion(?)");
        $sentencia->bindParam(1, $id_evaluacion, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);

        foreach($data as $row){
            $nota = new Nota();
            $nota->set_id_nota($row["id_nota"]);
            $nota->set_identidad(
                $row["id_evaluacion"],
                $row["run_alumno"],
                $row["valor"],
                $row["fecha_creacion"]
            );

            $this->to_matriz($nota);
        }

        return $sentencia->rowCount();
    }
}
?>