<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Bloque.php";
class BloqueMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Bloque $bloque){
        $matriz = array(
            "id_bloque" => $bloque->get_id_bloque(),
            "rbd_establecimiento" => $bloque->get_rbd_establecimiento(),
            "id_ciclo" => $bloque->get_id_ciclo(),
            "id_dia" => $bloque->get_id_dia(),
            "hora_inicio" => $bloque->get_hora_inicio(),
            "hora_fin" => $bloque->get_hora_fin()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }


}
?>