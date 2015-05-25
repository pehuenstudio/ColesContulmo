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
}
?>