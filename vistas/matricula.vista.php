<?php
$rbd_establecimiento = 51543;
;?>
<!--<link rel="stylesheet" href="/_code/vistas/css/normalize.css">-->
<link rel="stylesheet" href="/_code/vistas/css/main.css">
<link rel="stylesheet" href="/_code/vistas/css/jquery.steps.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link rel="stylesheet" href="/_code/vistas/css/matricula.css">
<link rel="stylesheet" href="/_code/vistas/css/load.css">
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">

<script src="/_code/vistas/js/jquery.min.js"></script>
<script src="/_code/vistas/js/jquery.steps.min.js"></script>
<script src="/_code/vistas/js/jquery-ui.js"></script>
<script src="/_code/vistas/js/mensajes.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script src="/_code/vistas/js/matricula.js"></script>
<script src="/_code/vistas/js/validaciones.js"></script>



<h1 class="yjsg-center">Modulo De Matriculas</h1><br/>
<form action="/_code/controladores/matricula.ingreso.alumno.joomla.php" method="post" enctype="multipart/form-data" id="formulario">

    <div id="matricula_formulario">
        <div class="contenedor">
            <div id="modulo_matriculas">
                <h2>Ingreso De Alumno</h2>
                <section>
                    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/matricula.formulario.alumno.php";?>
                </section>
                <h2>Ingreso De Apoderado</h2>
                <section>
                    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/matricula.formulario.apoderado.php";?>
                </section>

                <h2>Seleccionar Curso</h2>
                <section>
                    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/matricula.formulario.curso.php";?>
                </section>

                <h2>Resumen</h2>
                <section>
                    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/matricula.formulario.resumen.php";?>
                </section>
            </div>
        </div>
    </div>

    <?php //echo "<input type='submit'>"; ?>
</form>
<div id="dialog" title="Mensaje" class="exito-ui"></div>
