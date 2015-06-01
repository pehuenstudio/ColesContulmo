<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Persona.php";
//echo __FILE__."<br/>";
class Profesor extends Persona{
    private $run;
    private $nombre1;
    private $nombre2;
    private $apellido1;
    private $apellido2;
    private $sexo;
    private $id_direccion;
    private $direccion;
    private $avatar;
    private $email;
    private $estado = "1";

    public function db_get_profesor_by_run(){
        $run_profesor = $this->get_run();
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_profesor_by_run(?)");
        $sentencia->bindParam(1, $run_profesor, \PDO::PARAM_STR, 9);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $this->set_identidad(
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

        return $sentencia->rowCount();
    }
}
?> 