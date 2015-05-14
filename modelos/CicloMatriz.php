<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Ciclo.php";
//echo __FILE__."<br/>";
class CicloMatriz {
    private $matriz = array();

    function __construct(){}

    public function set_matriz($matriz)
    {
        $this->matriz = $matriz;
    }

    public function get_matriz()
    {
        return $this->matriz;
    }



    public function to_matriz(Ciclo $ciclo){
        $matriz = array(
            "id_ciclo" => $ciclo->get_id_ciclo(),
            "nombre" => $ciclo->get_nombre(),
            "estado" => $ciclo->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_datos(){
        global $myPDO;
        $result = $myPDO->query("CALL get_ciclos()");
        $data = $result->fetchAll(0);

        foreach($data as $row){
            $ciclo = new Ciclo();
            $ciclo->set_id_ciclo($row["id_ciclo"]);
            $ciclo->set_nombre($row["nombre"]);
            $ciclo->set_estado($row["estado"]);

            $this->to_matriz($ciclo);
        }

        return $result;
    }
}
?> 