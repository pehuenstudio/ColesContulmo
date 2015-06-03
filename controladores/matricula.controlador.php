<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Alumno.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Apoderado.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Curso.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Direccion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Matricula.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetido.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/TipoEnsenanza.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetidoMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Establecimiento.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Comuna.php";
require_once($_SERVER["DOCUMENT_ROOT"]."/_dompdf/dompdf_config.inc.php");

$id_funcion = $_POST["id_funcion"];

switch ($id_funcion){
    case "1":
        ins_matricula();
        break;
    case "2":
        to_pdf();
        break;
    default:
        break;

}

//SE USA DESDE ingreso_matriucla
function ins_matricula(){

    if($_POST["id_curso"]=="0"){
        $_POST["id_curso"] = null;
    }


    $alumno = new Alumno();
    $alumno->set_run($_POST["run_alumno"]);

    $apoderado = new Apoderado();
    $apoderado->set_run($_POST["run_apoderado"]);

    $curso = new Curso();
    $curso->set_id_curso($_POST["id_curso"]);
    $curso->set_id_tipo_ensenanza(($_POST["id_tipo_ensenanza"]));
    $curso->set_rbd_establecimiento($_POST["rbd_establecimiento"]);

    $result["result"] = "1";
    $result["msg"] = "Lo sentimos, ocurrió un error fatal y la matricula no pudo ser ingresada.";

    $validar = true;
    if(!$alumno->validar_run()){$validar = false;};
    if(!$apoderado->validar_run()){$validar = false;};
    //if(!$curso->validar()){$validar = false;};
    //print_r($validar);

    $periodo = $_POST["periodo"];
    $establecimiento_procedencia = $_POST["establecimiento_procedencia"];
    $fecha_incorporacion = date("Y-m-d");

    $matricula = new Matricula();
    $matricula->set_identidad(
        $curso->get_id_tipo_ensenanza(),
        $periodo,
        $alumno->get_run(),
        $curso->get_rbd_establecimiento(),
        $apoderado->get_run(),
        $curso->get_id_curso(),
        $establecimiento_procedencia,
        $fecha_incorporacion
    );
    //print_r($matricula);
    if(!$matricula->validar()){ $validar = false;};
    //print_r($validar);

    $ingreso = true;
    if($validar){
        if($matricula->db_get_matricula_by_run_alumno_and_rbd_esta_and_periodo() == "0"){
           if(!$matricula->db_ins_matricula()){$ingreso = false;};
        }else{
            $ingreso = false;
            $result["result"] = "2";
            $result["msg"] = "Lo sentimos, el alumno ya cuenta con una matrícula para este periodo.";
        }
    }else{
        $ingreso = false;
        $result["result"] = "1";
        $result["msg"] = "Lo sentimos, el formulario de matrícula tiene caracteres no permitidos.";
    }

    if($ingreso){
        $result["result"] = "3";
        $result["msg"] = "Matricula ingresada exitosamente.";
    }
//var_dump($ingreso);
    $result = json_encode($result, JSON_UNESCAPED_UNICODE);
    print_r($result);

}

//SE USA DESDE carga_clases
function to_pdf(){
    $plataforma= $_SERVER["HTTP_HOST"];

    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $date = date("Y-m-d H:i:s");
    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fecha = $dias[date('w')]." ".date('j')." de ".$meses[date('n')-1]. " del ".date('Y').", ".date("H:i:s") ;
    $escudo = $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/img/escudo.png";
    $municipalidad_nombre = MUNICIPALIDAD;


    $alumno = new Alumno();
    $alumno->set_run($_POST["run_alumno"]);
    $alumno->validar_run();
    $run_alumno = $alumno->get_run();

    $matricula = new Matricula();
    $matricula->set_run_alumno($run_alumno);
    $matricula->set_periodo($_POST["periodo"]);
    $matricula->set_rbd_establecimiento($_POST["rbd_establecimiento"]);
    $matricula->db_get_matricula_by_run_alumno_and_rbd_esta_and_periodo();

    $matricula_numero = $matricula->get_id_matricula();
    $tipo_ensenanza = new TipoEnsenanza();
    $tipo_ensenanza->set_id_tipo_ensenanza($matricula->get_id_tipo_ensenanza());
    $tipo_ensenanza->db_get_tipo_ensenanza_by_id();

    $matricula_tipo_ensenanza = $tipo_ensenanza->get_nombre();
    $matricula_periodo = $matricula->get_periodo();
    $matricula_fi = new DateTime($matricula->get_fecha_incorporacion());
    $matricula_fecha_incorporacion = $matricula_fi->format("j")." de ".$meses[$matricula_fi->format("n")-1]." de ".$matricula_fi->format("Y");

    $curso = new Curso();
    $curso->set_id_curso($matricula->get_id_curso());
    $curso->db_get_curso_by_id();

    $id_grado = $curso->get_id_grado();
    if($curso->get_id_tipo_ensenanza() == 10){
        switch ($curso->get_id_grado()){
            case 4:
                $id_grado = "Pre-Kinder";
                break;

            case 5:
                $id_grado = "Kinder";
                break;
        }
    }
    $matricula_curso = $id_grado." ".$curso->get_grupo();
    $run_apoderado = $matricula->get_run_apoderado();

    $establecimiento = new Establecimiento();
    $establecimiento->set_rbd_establecimiento($matricula->get_rbd_establecimiento());
    $establecimiento->db_get_establecimiento_by_rbd();
    $establecimiento_nombre = $establecimiento->get_nombre();

    $alumno = new Alumno();
    $alumno->set_run($matricula->get_run_alumno());
    $alumno->db_get_alumno_by_run();
    $alumno_nombre_completo = $alumno->get_nombre1()." ".$alumno->get_nombre2()." ".$alumno->get_apellido1()." ".$alumno->get_apellido2();
    $alumno_fn = new DateTime($alumno->get_fecha_nacimiento());
    $alumno_fecha_nacimiento = $alumno_fn->format("j")." de ".$meses[$alumno_fn->format("n")-1]." de ".$alumno_fn->format("Y");

    $alumno_dir = new Direccion();
    $alumno_dir->set_id_direccion($alumno->get_id_direccion());
    $alumno_dir->db_get_direccion_by_id();

    $alumno_comuna = new Comuna();
    $alumno_comuna->set_id_comuna($alumno_dir->get_id_comuna());
    $alumno_comuna->db_get_comuna_by_id();

    $alumno_direccion = $alumno_dir->get_calle()." "
        .$alumno_dir->get_numero()." "
        .$alumno_dir->get_depto()." "
        .$alumno_dir->get_sector().", "
        .$alumno_comuna->get_nombre();

    $apoderado = new Apoderado();
    $apoderado->set_run($matricula->get_run_apoderado());
    $apoderado->db_get_apoderado_by_run();
    $apoderado_nombre_completo = $apoderado->get_nombre1()." ".$apoderado->get_nombre2()." ".$apoderado->get_apellido1()." ".$apoderado->get_apellido2();

    $apoderado_dir = new Direccion();
    $apoderado_dir->set_id_direccion($apoderado->get_id_direccion());
    $apoderado_dir->db_get_direccion_by_id();

    $apoderado_comuna = new Comuna();
    $apoderado_comuna->set_id_comuna($apoderado_dir->get_id_comuna());
    $apoderado_comuna->db_get_comuna_by_id();

    $apoderado_direccion = $apoderado_dir->get_calle()." "
        .$apoderado_dir->get_numero()." "
        .$apoderado_dir->get_depto()." "
        .$apoderado_dir->get_sector().", "
        .$alumno_comuna->get_nombre();

    $apoderado_telefono_fijo = $apoderado->get_telefono_fijo();
    $apoderado_telefono_celular = $apoderado->get_telefono_celular();

    //var_dump($matricula);
    //var_dump($tipo_ensenanza);
    //var_dump($curso);

    $html = "
            <!DOCTYPE HTML>
            <html>
            <head>
                <title>Matricula $date</title>
                <style>
                    @page {
                        margin: 1cm;

                    }
                    body{
                        color: #808080;
                        font-family: monospace;
                        font-size: x-small;
                    }
                    table{
                        width: 100%;
                    }
                    table td{

                    }
                    table td.izq{
                        width: 30%;
                        font-weight: bold ;
                    }
                    table td.cen{
                        width: 1%;
                    }
                    table td.der{
                        width: 69%;
                        font-weight: lighter;
                    }
                    table td.titulo{
                        background-color: #AAD4FF;
                        text-align: center;
                        color: #ffffff;
                    }

                    #header{
                        width: 100%;
                    }
                    #header td.escudo{
                        width: 80px;
                        text-align: center;
                    }
                    #header img {
                        background-image: url('/_code/vistas/img/escudo.png');
                        width: 79px;
                        height: 119px;
                    }
                    #header h1,#header h2,#header h3 {
                        margin-bottom: 1px;
                        margin-top: 0;
                    }

                </style>
            </head>
            <body>
            <!-- +++++++++++++++++++++++++CABECERA+++++++++++++++++++++++ -->
            <table id='header'>
                <tr>
                    <td class='escudo'>
                        <img src='$escudo'>
                    </td>
                    <td>
                        <h1>$municipalidad_nombre</h1>
                        <h2>$establecimiento_nombre</h2>
                        <h3>Fecha De Emisión: $fecha</h3>
                    </td>
                </tr>
            </table><hr>
            <!-- +++++++++++++++++++++++++TITULO+++++++++++++++++++++++ -->
            <h2>Comprobante De Matricula</h2>
            <!-- +++++++++++++++++++++++++Resumen Matricula+++++++++++++++++++++++ -->
            <table>
                <tr>
                    <td colspan='3' class='titulo'><h3>Resumen De La Matricula</h3></td>
                </tr>
                <tr>
                    <td class='izq'>Periodo</td>
                    <td class='cen'>:</td>
                    <td class='der'>$matricula_periodo</td>
                </tr>
                <tr>
                    <td class='izq'>Numero</td>
                    <td class='cen'>:</td>
                    <td class='der'>$matricula_numero</td>
                </tr>
                <tr>
                    <td class='izq'>Tipo De Enseñanza </td>
                    <td class='cen'>:</td>
                    <td class='der'>$matricula_tipo_ensenanza</td>
                </tr>
                <tr>
                    <td class='izq'>Curso</td>
                    <td class='cen'>:</td>
                    <td class='der'>$matricula_curso</td>
                </tr>
                <tr>
                    <td class='izq'>Fecha De Incorporación</td>
                    <td class='cen'>:</td>
                    <td class='der'>$matricula_fecha_incorporacion</td>
                </tr>

            </table><br/><br/>
            <!-- +++++++++++++++++++++++++DATOS DE ALUMNO+++++++++++++++++++++++ -->
            <table id='tabla_alumno'>
                <tr>
                    <td colspan='3' class='titulo'><h3>Datos de Alumno</h3></td>
                </tr>
                <tr>
                    <td class='izq'>RUN</td>
                    <td class='cen'>:</td>
                    <td class='der'>$run_alumno</td>
                </tr>
                <tr>
                    <td class='izq'>Nombre Completo</td>
                    <td class='cen'>:</td>
                    <td class='der'>$alumno_nombre_completo</td>
                </tr>
                <tr>
                    <td class='izq'>Fecha De Nacimineto</td>
                    <td class='cen'>:</td>
                    <td class='der'>$alumno_fecha_nacimiento</td>
                </tr>
                <tr>
                    <td class='izq'>Dirección</td>
                    <td class='cen'>:</td>
                    <td class='der'>$alumno_direccion</td>
                </tr>
            </table><br/><br/>
            <!-- +++++++++++++++++++++++++DATOS DEL CURSO+++++++++++++++++++++++ -->

            <!-- +++++++++++++++++++++++++DATOS DE APODERADO+++++++++++++++++++++++ -->
            <table>
                <tr>
                    <td colspan='3' class='titulo'><h3>Datos de Apoderado</h3></td>
                </tr>
                <tr>
                    <td class='izq'>RUN</td>
                    <td class='cen'>:</td>
                    <td class='der'>$run_apoderado</td>
                </tr>
                <tr>
                    <td class='izq'>Nombre Completo</td>
                    <td class='cen'>:</td>
                    <td class='der'>$apoderado_nombre_completo</td>
                </tr>
                <tr>
                    <td class='izq'>Dirección</td>
                    <td class='cen'>:</td>
                    <td class='der'>$apoderado_direccion</td>
                </tr>
                <tr>
                    <td class='izq'>Teléfono Fijo</td>
                    <td class='cen'>:</td>
                    <td class='der'>$apoderado_telefono_fijo</td>
                </tr>
                <tr>
                    <td class='izq'>Teléfono Celular</td>
                    <td class='cen'>:</td>
                    <td class='der'>$apoderado_telefono_celular</td>
                </tr>
            </table><br/><br/><hr>
            <h2>Acceso a la plataforma www.$plataforma</h2>
            <table>
                <tr>
                    <td colspan='3' class='titulo'><h3>Alumno</h3></td>

                </tr>
                <tr>
                    <td class='izq'>Usuario</td>
                    <td class='cen'>:</td>
                    <td class='der'>$run_alumno</td>
                </tr>
                    <tr>
                    <td class='izq'>Contraseña</td>
                    <td class='cen'>:</td>
                    <td class='der'>$run_alumno</td>
                </tr>
            </table>
            <br/>
            <table>
                <tr>
                    <td colspan='3' class='titulo'><h3>Apoderado</h3></td>

                </tr>
                <tr>
                    <td class='izq'>Usuario</td>
                    <td class='cen'>:</td>
                    <td class='der'>$run_apoderado</td>
                </tr>
                    <tr>
                    <td class='izq'>Contraseña</td>
                    <td class='cen'>:</td>
                    <td class='der'>$run_apoderado</td>
                </tr>
            </table>
            </body>
            </html>
";

//echo $html;

    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream($run_alumno.".pdf");
}
?>
 