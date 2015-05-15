<?php

namespace personas;
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Persona.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Profesor.php";
//echo __FILE__."<br/>";
class ProfesorMatriz {
    private $matriz = array();

    public function set_matriz($matriz)
    {
        $this->matriz = $matriz;
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Profesor $profesor){
        $matriz = array(
            "run" => $profesor->get_run(),
            "nombre1" => $profesor->get_nombre1(),
            "nombre2" => $profesor->get_nombre2(),
            "apellido1" => $profesor->get_apellido1(),
            "apellido2" => $profesor->get_apellido2(),
            "avatar" => $profesor->get_avatar(),
            "estado" => $profesor->get_estado()
        );
        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_datos($rbd_establecimiento){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_establecimientos_profesores(?)");
        $sentencia->bindParam(1, $rbd_establecimiento, \PDO::PARAM_STR, 9);
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $profesor = new Profesor();
            $profesor->set_identidad_nueva(
                $row["run_profesor"],
                $row["nombre1"],
                $row["nombre2"],
                $row["apellido1"],
                $row["apellido2"],
                $row["sexo"],
                $row["email"]
            );
            $profesor->set_avatar($row["avatar"]);

           $this->to_matriz($profesor);
        }
    }
}
?> 