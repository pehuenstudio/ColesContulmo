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
            "coeficiente" => $evaluacion->get_coeficiente(),
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
                $row["fecha"],
                $row["coeficiente"],
                $row["descripcion"]
            );

            $this->to_matriz($evalucacion);
        }

        return $sentencia->rowCount();
    }

    public function db_get_evaluaciones_by_id_curso_and_id_asignatura($id_curso, $id_asignatura){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_evaluaciones_by_id_curso_and_id_asignatura(?,?)");
        $sentencia->bindParam(1, $id_curso, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $id_asignatura, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $evalucacion = new Evaluacion();
            $evalucacion->set_id_evaluacion($row["id_evaluacion"]);
            $evalucacion->set_identidad(
                $row["id_clase"],
                $row["fecha"],
                $row["coeficiente"],
                $row["descripcion"]
            );

            $this->to_matriz($evalucacion);
        }

        return $sentencia->rowCount();

    }
}
?>