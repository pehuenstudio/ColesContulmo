<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Region.php";
//echo __FILE__."<br/>";
class RegionMatriz {
    private $matriz = array();

    public function set_matriz($matriz)
    {
        $this->matriz = $matriz;
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Region $region){
        $matriz = array(
            "id_region" => $region->get_id_region(),
            "letra_romana" => $region->get_letra_romana(),
            "nombre" => $region->get_nombre(),
            "estado" => $region->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_regiones(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_regiones");
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $region = new Region();
            $region->set_id_region($row["id_region"]);
            $region->set_identidad(
                $row["letra_romana"],
                $row["nombre"]
            );

            $this->to_matriz($region);
        }

        return $result;
    }
}
?> 