<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Alumno.php";
class AlumnoMatriz {
    private $matriz = array();
    
    public function set_matriz($matriz)
    {
        $this->matriz = ($matriz);
    }
    public function get_matriz()
    {
        return $this->matriz;
    }

    public function to_matriz(Alumno $alumno){
        $matriz = array(
            "run_alumno" => $alumno->get_run(),
            "nombre1" => $alumno->get_nombre1(),
            "nombre2" => $alumno->get_nombre2(),
            "apellido1" => $alumno->get_apellido1(),
            "apellido2" => $alumno->get_apellido2(),
            "sexo" => $alumno->get_sexo(),
            "fecha_nacimiento" => $alumno->get_fecha_nacimiento(),
            "pde" => $alumno->get_pde(),
            "id_direccion" => $alumno->get_id_direccion(),
            "id_religion" => $alumno->get_id_religion(),
            "grado_educacional_padre" => $alumno->get_grado_educacional_padre(),
            "grado_educacional_madre" => $alumno->get_grado_educacional_madre(),
            "persona_vive" => $alumno->get_persona_vive(),
            "avatar" => $alumno->get_avatar(),
            "email" => $alumno->get_email(),
            "estado" => $alumno->get_estado()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_alumnos_by_id_curso($id_curso){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_alumnos_by_id_curso(?)");
        $sentencia->bindParam(1, $id_curso, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $alumno = new Alumno();
            $alumno->set_identidad(
                $row["run_alumno"],
                $row["nombre1"],
                $row["nombre2"],
                $row["apellido1"],
                $row["apellido2"],
                $row["sexo"],
                $row["email"]
            );
            $alumno->set_id_direccion($row["id_direccion"]);
            $alumno->set_avatar($row["avatar"]);
            $alumno->set_fecha_nacimiento($row["fecha_nacimiento"]);
            $alumno->set_pde($row["pde"]);
            $alumno->set_id_religion($row["id_religion"]);
            $alumno->set_grado_educacional_padre($row["grado_educacional_padre"]);
            $alumno->set_grado_educacional_madre($row["grado_educacional_padre"]);
            $alumno->set_persona_vive($row["persona_vive"]);

            $this->to_matriz($alumno);
        }

        return $sentencia->rowCount();
    }
}
?>