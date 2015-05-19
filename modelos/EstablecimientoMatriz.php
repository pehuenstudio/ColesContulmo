<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Establecimiento.php";
class EstablecimientoMatriz {
    private $matriz = array();

    function __construct(){}

    public function set_matriz($matriz){
        $this->matriz = $matriz;
    }
    public function get_matriz(){
        return $this->matriz;
    }

    public function to_matriz(Establecimiento $establecimiento){
        $matriz = array(
            "rbd_establecimiento" => $establecimiento->get_rbd_establecimiento(),
            "nombre" => $establecimiento->get_nombre(),
            "telefono" => $establecimiento->get_telefono()

        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }


}
?> 