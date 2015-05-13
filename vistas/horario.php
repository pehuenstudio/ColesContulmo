<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";


?>
<link rel="stylesheet" href="/_code/vistas/css/horario.css">
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">

<script src="/_code/vistas/js/_jquery.min.js"></script>
<script src="/_code/vistas/js/_jquery-ui.js"></script>
<script src="/_code/vistas/js/horario.js"></script>

<div id="contenedor_formulario">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/horario.formulario.php"?>
</div>
<div id="contenedor_bloques">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/horario.bloques.php"?>
</div>
