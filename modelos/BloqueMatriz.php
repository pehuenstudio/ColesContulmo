<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Bloque.php";
//echo __FILE__."<br/>";
class BloqueMatriz {
    private $matriz = array();

    function __construct(){}

    function to_matriz(Bloque $bloque){
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

    public function db_get_datos($rbd_establecimiento,$id_ciclo){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_bloques(?,?)");
        $sentencia->bindParam(1, $rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $id_ciclo, \PDO::PARAM_INT);
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $bloque = new Bloque();
            $bloque->set_identidad(
                $row["rbd_establecimiento"],
                $row["id_ciclo"],
                $row["id_dia"],
                date("H:i",strtotime($row["hora_inicio"])),
                date("H:i",strtotime($row["hora_fin"]))
            );
            $bloque->set_id_bloque($row["id_bloque"]);

            $this->to_matriz($bloque);
        }

    }


}
/*
$matriz_bloques = new MatrizBloques();
$matriz_bloques->db_get_datos(51543,1);
print_r($matriz_bloques->to_json());*/
?> 