<?php
$rbd_establecimiento = 51543;
?>

<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link rel="stylesheet" href="/_code/vistas/css/load.css">
<link rel="stylesheet" href="/_code/vistas/css/_carga_clases.css">

<script src="/_code/vistas/js/jquery.min.js"></script>
<script src="/_code/vistas/js/jquery-ui.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script src="/_code/vistas/js/sticky.js"></script>
<script src="/_code/vistas/js/_carga_clases.js"></script>

<h1 class="titulo">Panel De Carga Horaria</h1>

<div id="contenedor_selectores">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/carga_clases.selectores.php"?>
</div>
<div id="grilla10">&nbsp;</div>
<div id="contenedor_bloques">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/carga_clases.bloques.php"?>
</div>
<div id="dialog"></div>