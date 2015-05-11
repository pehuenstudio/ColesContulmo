<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetido.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Validacion.php";
//echo __FILE__."<br/>";
class GradoRepetidoMatriz {
    private $matriz = array();

    function __construct(){}

    public function to_matriz(GradoRepetido $grado_repetido){
        $matriz = array(
            "run_alumno" => $grado_repetido->get_run_alumno(),
            "id_grado"=> $grado_repetido->get_id_grado(),
            "id_tipo_ensenanza" => $grado_repetido->get_id_tipo_ensenanza(),
            "cantidad" => $grado_repetido->get_cantidad()
        );
        array_push($this->matriz, $matriz);
    }

    public function validar(){
        $i = 0;
        $result = true;
        foreach ($this->matriz as $row){
            if(empty($row["cantidad"])){
                unset($this->matriz[$i]);
            }else{
                $grado_repetido = new GradoRepetido(
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

    public function to_json(){
        $json = json_encode($this->matriz,JSON_UNESCAPED_UNICODE);
        //print_r($json);
        return $json;
    }

    // ++++++++++++++++++++++++++++++++++++++++++++++MANEJO DE BBDD++++++++++++++++++++++++++++++++++++++++++
    public function db_ingresar(){
        $result = true;
        foreach($this->matriz as $row){
            $grado_repetido = new GradoRepetido(
                $row["run_alumno"],
                $row["id_grado"],
                $row["id_tipo_ensenanza"],
                $row["cantidad"]
            );
            if(!$grado_repetido->db_ingresar()){$result = false;};
        }
        return $result;
    }

    public function db_get_datos($run){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_grados_repetidos(?)");
        $sentencia->bindParam(1, $run, \PDO::PARAM_STR, 9);
        $sentencia->execute();
        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $matriz = array(
                "id_grado"=> $row["id_grado"],
                "id_tipo_ensenanza" => $row["id_tipo_ensenanza"],
                "cantidad" => $row["cantidad"]
            );
            array_push($this->matriz, $matriz);
        }


    }
}
?> 