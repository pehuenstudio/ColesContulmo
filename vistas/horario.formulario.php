<?php
$rbd_establecimiento = 51543;
?>

    <form id="formulario_clase" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $rbd_establecimiento?>" id="rbd_establecimiento" name="rbd_establecimiento">
        <div class="contenedor_grillas">
            <div class="grilla10 titulo"><h3>Panel De Clases</h3></div>

            <div class="grilla3">
                <select id="id_ciclo" name="id_ciclo">
                    <option value ="0">Seleccione Un Ciclo</option>
                </select>
                <div class="div10 error">&nbsp;</div>
            </div>

            <div class="grilla3">
                <select id="id_curso" name="id_curso" disabled>
                    <option value = "0">Seleccione Un Curso</option>
                </select>
                <div class="div10 error">&nbsp;</div>
            </div>

            <div class="grilla3">
                <select id="id_asignatura" name="id_asignatura" disabled>
                    <option value = "0">Seleccione Una Asignatura</option>
                </select>
                <div class="div10 error">&nbsp;</div>
            </div>
            <input type="submit">
        </div>
    </form>
