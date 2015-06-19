<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Apoderado.php";
class ApoderadoMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Apoderado $apoderado){
        $matriz = array(
            "run_apoderado" => $apoderado->get_run(),
            "nombre1" => $apoderado->get_nombre1(),
            "nombre2" => $apoderado->get_nombre2(),
            "apellido1" => $apoderado->get_apellido1(),
            "apellido2" => $apoderado->get_apellido2(),
            "sexo" => $apoderado->get_sexo(),
            "id_direccion" => $apoderado->get_id_direccion(),
            "telefono_fijo" => $apoderado->get_telefono_fijo(),
            "telefono_celular" => $apoderado->get_telefono_celular(),
            "avatar" => $apoderado->get_avatar(),
            "email" => $apoderado->get_email(),
            "estado" => $apoderado->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_apoderados_by_id_curso($id_curso){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_apoderados_by_id_curso(?)");
        $sentencia->bindParam(1, $id_curso, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $apoderado = new Apoderado();
            $apoderado->set_identidad(
                $row["run_apoderado"],
                $row["nombre1"],
                $row["nombre2"],
                $row["apellido1"],
                $row["apellido2"],
                $row["sexo"],
                $row["email"]
            );
            $apoderado->set_id_direccion($row["id_direccion"]);
            $apoderado->set_avatar($row["avatar"]);
            $apoderado->set_telefono_fijo($row["telefono_fijo"]);
            $apoderado->set_telefono_celular($row["telefono_celular"]);

            $this->to_matriz($apoderado);
        }

        return $sentencia->rowCount();
    }
}
?>