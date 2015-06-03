<?php
?>
<div class="contenedor_grillas">
<form enctype="multipart/form-data">
    <input id="run_profesor" name="run_profesor" type="hidden" value="<?php echo $run_profesor;?>">
    <div class="grilla3">
        <select id="rbd_establecimiento" name="rbd_establecimiento">
            <option value="0">Seleccione Establecimiento</option>
        </select>
    </div>
    <div class="grilla3">
        <select id="id_curso" name="id_curso" disabled>
            <option value="0">Seleccione Un Curso</option>
        </select>
    </div>
    <div class="grilla3 ultima">
        <select id="id_asignatura" name="id_asignatura" disabled>
            <option value="0">Seleccione Una Asignatura</option>
        </select>
    </div>
    <div class="grilla10">&nbsp;</div>
</form>
</div>