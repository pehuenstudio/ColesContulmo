<?php
$rbd_establecimiento = 51543;
?>
<!--<link rel="stylesheet" href="/_code/vistas/css/normalize.css">-->
<link rel="stylesheet" href="/_code/vistas/css/main.css">
<link rel="stylesheet" href="/_code/vistas/css/jquery.steps.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link rel="stylesheet" href="/_code/vistas/css/load.css">
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/validaciones.css">
<link rel="stylesheet" href="/_code/vistas/css/selectores.css">
<link rel="stylesheet" href="/_code/vistas/_anexo/css/ingreso_matricula.css">

<script src="/_code/vistas/js/jquery.min.js"></script>
<script src="/_code/vistas/js/jquery.steps.min.js"></script>
<script src="/_code/vistas/js/jquery-ui.js"></script>
<script src="/_code/vistas/js/mensajes.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script src="/_code/vistas/js/validaciones.js"></script>
<script src="/_code/vistas/_anexo/js/ingreso_matricula.js"></script>



<h1 class="yjsg-center">Modulo De Matriculas</h1><br/>
<form action="/_code/controladores/matricula.ingreso.alumno.joomla.php" method="post" enctype="multipart/form-data" id="formulario">

    <div id="matricula_formulario">
        <div class="contenedor">
            <div id="modulo_matriculas">
                <h2>Ingreso De Alumno</h2>
                <section>
                    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/_anexo/ingreso_matricula.alumno.php";?>
                </section>
                <h2>Ingreso De Apoderado</h2>
                <section>
                    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/_anexo/ingreso_matricula.apoderado.php";?>
                </section>

                <h2>Seleccionar Curso</h2>
                <section>
                    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/_anexo/ingreso_matricula.curso.php";?>
                </section>

                <h2>Resumen</h2>
                <section>
                    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/_anexo/ingreso_matricula.resumen.php";?>
                </section>
            </div>
        </div>
    </div>

    <?php //echo "<input type='submit'>"; ?>
</form>
<div id="dialog" title="Mensaje" class="exito-ui"></div>
