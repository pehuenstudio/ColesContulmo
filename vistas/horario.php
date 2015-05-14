<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";


?>
<link rel="stylesheet" href="/_code/vistas/css/horario.css">
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">

<script src="/_code/vistas/js/_jquery.min.js"></script>
<script src="/_code/vistas/js/_jquery-ui.js"></script>
<script src="/_code/vistas/js/jquery.sticky.js"></script>
<script src="/_code/vistas/js/mensajes.js"></script>
<script src="/_code/vistas/js/horario.js"></script>


<div id="contenedor_formulario">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/horario.formulario.php"?>
</div>
<div id="contenedor_info">
    <div id="grilla10">
        <h3>Instrucciones para ingresar una clase al horario:</h3>
        <ol style="font-size: larger">
            <li>Seleccione un <b>ciclo</b>.</li>
            <li>Seleccione un <b>curso</b>.</li>
            <li>Seleccione una <b>asignatura</b>.</li>
            <li>Agregar/Quitar una <b>clase</b>.
                <ul>
                    <li>Para agregar una <b>asignatura</b> a un <b>bloque</b> haga clic sobre él y este se pondrá de color verde.</li>
                    <li>Para quitar una <b>asignatura</b> de un <b>bloque</b> haga clic sobre él y este volverá se estar plomo.</li>
                    <li>Puede seleccionar tantos <b>bloques</b> como desee e incluso cambiar de <b>asignatura</b>.</li>
                </ul>
            </li>
            <li>Haga clic en actualizar para guardar los cambios.
        </ol>

    </div>
</div>
<div id="grilla10">&nbsp;</div>
<div id="contenedor_bloques">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/horario.bloques.php"?>
</div>
<div id="dialog"></div>
