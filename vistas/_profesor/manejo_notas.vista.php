<?php
$user = JFactory::getUser();
if($user->username){
    $run_profesor = $user->username;
}else{
    $run_profesor = "5308978k";
}

?>
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link rel="stylesheet" href="/_code/vistas/css/load.css">
<link rel="stylesheet" href="/_code/vistas/css/validaciones.css">
<link rel="stylesheet" href="/_code/vistas/css/selectores.css">
<link rel="stylesheet" href="/_code/vistas/_profesor/css/manejo_notas.css">


<script src="/_code/vistas/js/jquery.min.js"></script>
<script src="/_code/vistas/js/jquery-ui.js"></script>
<script src="/_code/vistas/js/mensajes.js"></script>
<script src="/_code/vistas/js/sticky.js"></script>
<script src="/_code/vistas/js/validaciones.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script src="/_code/vistas/_profesor/js/manejo_notas.js"></script>

<h1 class="titulo">Manejo De Notas</h1>
<div id="contenedor_selectores">
    <?php require_once "/_code/vistas/_profesor/manejo_notas.selectores.php"?>
</div>
<div id="contenedor_cartola">
    <?php require_once "/_code/vistas/_profesor/manejo_notas.cartola.php"?>
</div>
<div id="dialog"></div>