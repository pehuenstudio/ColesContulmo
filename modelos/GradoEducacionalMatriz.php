<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoEducacional.php";
class GradoEducacionalMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(GradoEducacional $grado_educacional){
        $matriz = array(
            "id_grado_educacional" => $grado_educacional->get_id_grado_educacional(),
            "nombre" => $grado_educacional->get_nombre(),
            "estado" => $grado_educacional->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_grados_educacionales(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_grados_educacionales");
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        //print_r($data);
        foreach($data as $row){
            $grado_educacional = new GradoEducacional();
            $grado_educacional->set_id_grado_educacional($row["id_grado_educacional"]);
            $grado_educacional->set_identidad(
                $row["nombre"]
            );

            $this->to_matriz($grado_educacional);
        }

        return $sentencia->rowCount();
    }
}
?>