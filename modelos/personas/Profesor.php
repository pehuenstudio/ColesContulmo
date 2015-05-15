<?php

namespace personas;
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Persona.php";
//echo __FILE__."<br/>";
class Profesor extends Persona{

    public function db_get_datos(){
        $run_profesor = $this->get_run();
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_profesor(?)");
        $sentencia->bindParam(1, $run_profesor, \PDO::PARAM_STR, 9);
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $this->set_identidad_nueva(
                $row["run_profesor"],
                $row["nombre1"],
                $row["nombre2"],
                $row["apellido1"],
                $row["apellido2"],
                $row["sexo"],
                $row["email"]
            );
            $this->set_avatar($row["avatar"]);
        }
    }
}
?> 