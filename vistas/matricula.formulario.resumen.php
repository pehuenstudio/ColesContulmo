<?php
//echo __FILE__."<br/>";
?>
<style>
    .resumen {
        text-transform: capitalize;
        font-style: italic;
    }
    .label{
        color: #ffffff;
        background-color: #C8C8C8;
    }
    .load2{
        height: 25px !important;

    }
    .exito{
        color: #00C3AB;
        font-style: italic;
    }

    .warning{
        color: #FAC757;
        font-style: italic;
    }

</style>
<div id="contenedor_resumen">
    <div class="contenedor_grillas">
        <div class="grilla5 izquierda">
            <div class="grilla10 titulo"><h3>Datos Del Alumno</h3></div>
            <div class="grilla10 label">RUN</div>
            <div class="grilla10"><p class="resumen" id="resumen_run_alumno"></p></div>
            <div class="grilla10 label">Nombre Completo</div>
            <div class="grilla10"><p class="resumen" id="resumen_nombre_alumno"></p></div>
            <div class="grilla10 label">Dirección</div>
            <div class="grilla10"><p class="resumen" id="resumen_direccion_alumno"></p></div>
            <div class="grilla10 label">Email</div>
            <div class="grilla10"><p class="resumen" id="resumen_email_alumno"></p></div>
            <div class="grilla10 label">Establecimiento Procedencia</div>
            <div class="grilla10"><p class="resumen" id="resumen_establecimiento_alumno"></p></div>

        </div>
        <!--PANEL DE DIRECCIONES-->
        <div class="grilla5 derecha">
            <div class="grilla10 titulo"><h3>Datos Apoderado</h3></div>
            <div class="grilla10 label">RUN</div>
            <div class="grilla10"><p class="resumen" id="resumen_run_apoderado"></p></div>
            <div class="grilla10 label">Nombre Completo</div>
            <div class="grilla10"><p class="resumen" id="resumen_nombre_apoderado"></p></div>
            <div class="grilla10 label">Dirección</div>
            <div class="grilla10"><p class="resumen" id="resumen_direccion_apoderado"></p></div>
            <div class="grilla10 label">Email</div>
            <div class="grilla10"><p class="resumen" id="resumen_email_apoderado"></p></div>
            <div class="grilla5 izquierda label">Telefono Fijo</div>
            <div class="grilla5 derecha label">Telefono Celular</div>
            <div class="grilla5 izquierda"><p class="resumen" id="resumen_tel1_apoderado"></p></div>
            <div class="grilla5 derecha"><p class="resumen" id="resumen_tel2_apoderado"></p></div>

        </div>
        <div class="grilla10">&nbsp;</div>
        <div class="grilla10 titulo"><h3>Datos De Curso</h3></div>
        <div class="grilla10 label">Periodo</div>
        <div class="grilla10"><p class="resumen" id="resumen_periodo"></p></div>
        <div class="grilla10 label">Establecimiento</div>
        <div class="grilla10"><p class="resumen" id="resumen_establecimiento"></p></div>
        <div class="grilla10 label">Tipo De Enseñanza</div>
        <div class="grilla10"><p class="resumen" id="resumen_tipo_ensenanza"></p></div>
        <div class="grilla10 label">Grado y Grupo</div>
        <div class="grilla10"><p class="resumen" id="resumen_grado_grupo"></p></div>

        <div class="grilla10">&nbsp;</div>
        <div class="grilla5 izquierda">
            <div class="grilla4 ">Ingresando alumno</div><div class="grilla6 " id="load_ingreso_alumno">&nbsp;</div>

            <div class="grilla4 ">Ingresando apoderado</div><div class="grilla6" id="load_ingreso_apoderado">&nbsp;</div>

            <div class="grilla4 ">Ingresando curso</div><div class="grilla6" id="load_ingreso_curso">&nbsp;</div>

        </div>
        <div class="grilla5 derecha">
            <div class="grilla10" id="msg_ingreso_alumno">&nbsp;</div>
            <div class="10"></div>
            <div class="grilla10" id="msg_ingreso_apoderado">&nbsp;</div>
            <div class="10"></div>
            <div class="grilla10" id="msg_ingreso_curso">&nbsp;</div>
            <div class="10"></div>
        </div>




    </div>
</div>