<div id="contenedor_intrucciones">
    <h3>Instrucciones para cargar <strong>Notas</strong>:</h3>
    <ol>
        <li>Selecciona un <strong>Establecimiento</strong>.</li>
        <li>Selecciona un <strong>Curso</strong>.</li>
        <li>Selecciona una <strong>Asignatura</strong>.</li>
    </ol>
</div>
<form id="formulario_notas" enctype="multipart/form-data">
    <input id="run_profesor" name="run_profesor" type="hidden" value="<?php echo $run_profesor;?>">
    <div id="cartola">
        <div class="header_alumnos"><h2>Lista de Alumnos</h2></div>
        <div class="header_notas"><h2>Notas</h2></div>
        <div class="empty"></div><div class="header_fechas"></div>
        <div class="contenedor_registros"></div>
        <div class="empty"></div><div class="booter_fechas"></div>
        <div class="contenedor_boton">
            <button type="submit" id="actualizar">Actualizar</button>
        </div>
    </div>
</form>
