<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetido.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Validacion.php";
echo __FILE__."<br/>";
class MatrizGradosRepetidos {
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
}
?> 