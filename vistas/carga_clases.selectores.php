<form id="formulario_clase" enctype="multipart/form-data">
    <div class="contenedor_grillas">
        <input type="hidden" value="<?php echo $rbd_establecimiento ?>" id="rbd_establecimiento" name="rbd_establecimiento">
        <div class="grilla10">&nbsp;</div>
        <div class="grilla4">
            <select id="id_ciclo" name="id_ciclo">
                <option value ="0">Seleccione Un Ciclo</option>
            </select>
            <div class="div10 error">&nbsp;</div>
        </div>

        <div class="grilla4">
            <select id="id_curso" name="id_curso" disabled>
                <option value = "0">Seleccione Un Curso</option>
            </select>
            <div class="div10 error">&nbsp;</div>
        </div>

        <div class="grilla4">
            <select id="id_asignatura" name="id_asignatura" disabled>
                <option value = "0">Seleccione Una Asignatura</option>
            </select>
            <div class="div10 error">&nbsp;</div>
        </div>
        <div class="grilla4 last">
            <select id="run_profesor" name="run_profesor" disabled>
                <option value = "0">Seleccione Un Profesor</option>
            </select>
            <div class="div10 error">&nbsp;</div>
        </div>
        <div class="grilla10 center">
            <input type="submit" value="Actualizar">
        </div>

    </div>
</form>