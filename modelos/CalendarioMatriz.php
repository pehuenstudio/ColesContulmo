<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Calendario.php";

class CalendarioMatriz {
    private $matriz = array();

    public function to_matriz(Calendario $calendario){
        $matriz = array(
            "fecha" => $calendario->get_fecha(),
            "id_mes" => $calendario->get_id_mes(),
            "id_dia" => $calendario->get_id_dia(),
            "dia_mes" => $calendario->get_dia_mes(),
            "estado" => $calendario->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }
} 