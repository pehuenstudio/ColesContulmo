<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Evaluacion.php";
class EvaluacionMatriz {
    private $matriz = array();

    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {

        return $this->matriz;
    }

    public function to_matriz(Evaluacion $evaluacion){
        $matriz = array(
            "id_evaluacion" => $evaluacion->get_id_evaluacion(),
            "id_clase" => $evaluacion->get_id_clase(),
            "fecha" => $evaluacion->get_fecha(),
            "run_profesor" => $evaluacion->get_run_profesor(),
            "descripcion" => $evaluacion->get_descripcion()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_evaluaciones_by_id_curso_and_mes_actual($id_curso, $mes_actual){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_evaluaciones_by_id_curso_and_mes_actual(?,?)");
        $sentencia->bindParam(1, $id_curso, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $mes_actual, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $evalucacion = new Evaluacion();
            $evalucacion->set_id_evaluacion($row["id_evaluacion"]);
            $evalucacion->set_identidad(
                $row["id_clase"],
                $row["run_profesor"],
                $row["fecha"],
                $row["descripcion"]
            );

            $this->to_matriz($evalucacion);
        }

        return $sentencia->rowCount();
    }
}
?>