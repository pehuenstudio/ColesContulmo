<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Religion.php";
class ReligionMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Religion $religion){
        $matriz = array(
            "id_religion" => $religion->get_id_religion(),
            "nombre" => $religion->get_nombre(),
            "estado" => $religion->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_religiones(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_religiones()");
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $religion = new Religion();
            $religion->set_id_religion($row["id_religion"]);
            $religion->set_identidad($row["nombre"]);

            $this->to_matriz($religion);
        }

        return $sentencia->rowCount();
    }
}
?>