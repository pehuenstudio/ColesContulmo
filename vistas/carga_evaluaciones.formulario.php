<div class="contenedor_grillas">
    <form enctype="multipart/form-data">
        <input id="run_profesor" name="run_profesor" type="hidden" value="<?php echo $run_profesor;?>">
        <input id="fecha" name="fecha" type="hidden">
        <div class="grilla10">Fecha<strong>*</strong></div>
        <div class="grilla10">
            <input id="fecha_completa" readonly>
        </div>
        <div class="grilla10">&nbsp;</div>
        <div class="grilla10">Clase<strong>*</strong></div>
        <div class="grilla10">
            <select id="id_clase" name="id_clase">
                <option value="0">Seleccione Una Clase</option>
            </select>
        </div>
        <div class="grilla10">&nbsp;</div>
        <div class="grilla10">Ingrese Una Descripción (200 caracteres max)<strong>*</strong></div>
        <div class="grilla10">
            <textarea id="descripcion" name="descripcion" maxlength="200"></textarea>
        </div>
        <div class="grilla10">
            <input type="submit" id="ingresar_evaluacion" value="Ingresar Evaluación">
        </div>
    </form>
</div>