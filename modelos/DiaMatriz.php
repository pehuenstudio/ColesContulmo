<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Dia.php";
class DiaMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Dia $dia){
        $matriz = array(
            "id_dia" => $dia->get_id_dia(),
            "nombre" => $dia->get_nombre(),
            "estado" => $dia->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function get_dias_by_run_profesor_and_id_curso_and_id_asignatura($run_profesor, $id_curso, $id_asignatura){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_dias_by_run_profesor_and_id_curso_and_id_asignatura(?,?,?)");
        $sentencia->bindParam(1, $run_profesor, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $id_curso, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $id_asignatura, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);

        foreach($data as $row){
            $dia = new Dia();
            $dia->set_id_dia($row["id_dia"]);
            $dia->set_identidad(
                $row["nombre"]
            );
            $this->to_matriz($dia);
        }

        return $sentencia->rowCount();
    }
}
?>