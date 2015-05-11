<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";


?>
<link rel="stylesheet" href="/_code/vistas/css/horario.css">
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">

<script src="/_code/vistas/js/_jquery.min.js"></script>
<script src="/_code/vistas/js/_jquery-ui.js"></script>
<script src="/_code/vistas/js/horario.js"></script>

<div id="contenedor_selector">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/horario.formulario.selector.php"?>
</div>
<div id="contenedor_horario">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/horario.formulario.bloques.php"?>
</div>
