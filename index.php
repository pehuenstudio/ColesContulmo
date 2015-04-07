<?php
echo __FILE__."<br/>";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/config.php";
require_once ROOT_MODELOS_USUARIOS."Profesor.php";
require_once ROOT_MODELOS_USUARIOS."Apoderado.php";
require_once ROOT_MODELOS_USUARIOS."Alumno.php";


$alumnoParametrizado = new Alumno("11.111.111-1","angelica","maria","saavedra","torres","19880528",1);


if($alumnoParametrizado->validar()){

    if(!$alumnoParametrizado->db_verificar_existencia()){

        $alumnoParametrizado->db_ingresar();

    }else{
        $alumnoParametrizado->db_actualizar();
    }
}/*
$miAlumno = new Alumno();
$miAlumno->set_run("00.000.000-0");
var_dump($miAlumno);

if ($miAlumno->validar_run()){

    if($miAlumno->db_verificar_existencia()){

       $miAlumno->db_poblar();

    }
}*/

?>