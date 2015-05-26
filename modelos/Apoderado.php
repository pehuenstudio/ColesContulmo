<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Persona.php";
//echo __FILE__."<br/>";
class Apoderado extends Persona{
    private $telefono_fijo;
    private $telefono_celular;
    private $estado = "1";

    public function set_telefono_celular($telefono_celular)
    {
        $this->telefono_celular = $telefono_celular;
    }
    public function get_telefono_celular()
    {
        return $this->telefono_celular;
    }
    public function set_telefono_fijo($telefono_fijo)
    {
        $this->telefono_fijo = $telefono_fijo;
    }
    public function get_telefono_fijo()
    {
        return $this->telefono_fijo;
    }

    public function set_identidad($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo, $id_direccion, $email)
    {
        parent::set_identidad($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo, $id_direccion, $email); // TODO: Change the autogenerated stub
    }

    public function to_matriz()
    {
        $matriz = parent::to_matriz();
        $matriz["telefono_fijo"] = $this->get_telefono_fijo();
        $matriz["telefono_celular"] = $this->get_telefono_celular();

        return  $matriz;
    }

    public function to_json(){
        $json = json_encode($this->to_matriz(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_apoderado_by_run(){
        $run_apoderado = $this->get_run();
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_apoderado_by_run(?)");
        $sentencia->bindParam(1, $run_apoderado, \PDO::PARAM_STR, 9);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $this->set_identidad(
                $row["run_apoderado"],
                $row["nombre1"],
                $row["nombre2"],
                $row["apellido1"],
                $row["apellido2"],
                $row["sexo"],
                $row["id_direccion"],
                $row["email"]
            );
            $this->set_avatar($row["avatar"]);
            $this->set_telefono_fijo($row["telefono_fijo"]);
            $this->set_telefono_celular($row["telefono_celular"]);
        }

        return $sentencia->rowCount();
    }


}
?> 