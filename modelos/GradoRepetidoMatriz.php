<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetido.php";
class GradoRepetidoMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {

        return $this->matriz;
    }

    public function to_matriz(GradoRepetido $grado_repetido){
        $matriz = array(
            "run_alumno" => $grado_repetido->get_run_alumno(),
            "id_grado" => $grado_repetido->get_id_grado(),
            "id_tipo_ensenanza" => $grado_repetido->get_id_tipo_ensenanza(),
            "cantidad" => $grado_repetido->get_cantidad(),
            "estado" => $grado_repetido->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function validar(){
        $i = 0;
        $result = true;

        foreach ($this->matriz as $row){
            if(empty($row["cantidad"]) and ($row["cantidad"] != "0")){
                unset($this->matriz[$i]);
            }else{

                $grado_repetido = new GradoRepetido();
                $grado_repetido->set_identidad(
                    $row["run_alumno"],
                    $row["id_grado"],
                    $row["id_tipo_ensenanza"],
                    $row["cantidad"]
                );

                if(!$grado_repetido->validar()){unset($this->matriz[$i]); $result = false;}
            }
            $i++;

        }
        return $result;
    }

    public function db_get_grados_repetidos_by_run_alumno($run_alumno){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_grados_repetidos_by_run_alumno(?)");
        $sentencia->bindParam(1, $run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $grado_repetido = new GradoRepetido();
            $grado_repetido->set_identidad(
                $row["run_alumno"],
                $row["id_grado"],
                $row["id_tipo_ensenanza"],
                $row["cantidad"]
            );

            $this->to_matriz($grado_repetido);
        }

        return $sentencia->rowCount();
    }

    public function db_ins_or_upd(){
        foreach($this->matriz as $row){
            $grado_repetido = new GradoRepetido();
            $grado_repetido->set_identidad(
                $row["run_alumno"],
                $row["id_grado"],
                $row["id_tipo_ensenanza"],
                $row["cantidad"]
            );

            if($grado_repetido->db_get_grado_repetido_by_run_and_id_grado_and_id_tipo_ensenanza() > "0"){
                $result = $grado_repetido->db_upd_grado_repetido_by_run_and_id_grado_and_id_tipo_ensenanza();
            }else{
                $result = $grado_repetido->db_ins_grado_repetido();
            }

        }


    }



}
?>