<div id="contenedor_formulario_ins">
    <div class="contenedor_grillas">
        <form id="formulario_ins" enctype="multipart/form-data">
            <input id="run_profesor_ins" name="run_profesor" type="hidden" value="<?php echo $run_profesor;?>">
            <input id="fecha_ins" name="fecha" type="hidden">
            <div class="grilla10">Fecha</div>
            <div class="grilla10">
                <div id="fecha_completa_ins" class="grilla10"></div>
                <div class="grilla10 error">&nbsp;</div>
            </div>

            <div class="grilla10">Clase<strong>*</strong></div>
            <div class="grilla10">
                <select id="id_clase_ins" name="id_clase">
                    <option value="0">Seleccione Una Clase</option>
                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>

            <div class="grilla10">Coeficiente<strong>*</strong></div>
            <div class="grilla10">
                <select id="coeficiente_ins" name="coeficiente">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>

            <div class="grilla10">Ingrese Una Descripción<strong>*</strong> (200 caracteres max)</div>
            <div class="grilla10">
                <textarea id="descripcion_ins" name="descripcion" maxlength="200"></textarea>
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">
                <input type="submit" id="boton_ins" value="Ingresar Evaluación">
            </div>
        </form>
    </div>
</div>

<div id="contenedor_formulario_upd">
    <div class="contenedor_grillas">
        <form id="formulario_upd" enctype="multipart/form-data">
            <input id="id_evaluacion_upd" name="id_evaluacion" type="hidden">
            <div class="grilla10">Fecha</div>
            <div class="grilla10">
                <div id="fecha_completa_upd" class="grilla10"></div>
                <div class="grilla10 error">&nbsp;</div>
            </div>

            <div class="grilla10">Horario</div>
            <div class="grilla10">
                <input id="horario_upd" readonly>
                <div class="grilla10 error">&nbsp;</div>
            </div>

            <div class="grilla10">Coeficiente<strong>*</strong></div>
            <div class="grilla10">
                <select id="coeficiente_upd" name="coeficiente">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>

            <div class="grilla10">Descripción<strong>*</strong> (200 caracteres max)</div>
            <div class="grilla10">
                <textarea id="descripcion_upd" name="descripcion" maxlength="200"></textarea>
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">
                <input type="button" id="boton_upd" value="Actualizar Evaluación">
                <input type="button" id="boton_del" value="Eliminar Evaluación">
            </div>
        </form>
    </div>
</div>