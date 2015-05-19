<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Curso.php";
class CursoMatriz{
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

    public  function to_matriz(Curso $curso){
        $matriz = array(
            "id_curso" => $curso->get_id_curso(),
            "rbd_establecimiento" => $curso->get_rbd_establecimiento(),
            "run_profesor_jefe" => $curso->get_run_profesor_jefe(),
            "id_grado" => $curso->get_id_grado(),
            "nombre_grado" =>$curso->get_nombre_grado(),
            "id_tipo_ensenanza" => $curso->get_id_tipo_ensenanza(),
            "nombre_tipo_ensenanza" => $curso->get_nombre_tipo_ensenanza(),
            "id_ciclo" => $curso->get_id_ciclo(),
            "grupo" => $curso->get_grupo()
        );

        array_push($this->matriz, $matriz);
    }

    public function to_json(){
        $json = json_encode($this->matriz, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_get_datos($rbd_establecimiento, $id_ciclo){
        global $myPDO;

        $sentencia = $myPDO->prepare("CALL get_cursos(?,?)");
        $sentencia->bindParam(1, $rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $id_ciclo, \PDO::PARAM_INT);
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $curso = new Curso();
            $curso->set_identidad(
                $row["rbd_establecimiento"],
                $row["id_grado"],
                $row["id_tipo_ensenanza"],
                $row["grupo"]
            );
            $curso->set_id_curso($row["id_curso"]);
            $curso->set_run_profesor_jefe($row["run_profesor_jefe"]);
            $curso->set_id_ciclo($row["id_ciclo"]);

            $this->to_matriz($curso);
        }

        return $result;
    }
}
/*
$matriz_curso = new CursoMatriz();
$matriz_curso->db_get_datos(51543);
print_r($matriz_curso->to_json());*/
?>
 