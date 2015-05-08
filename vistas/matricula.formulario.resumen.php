<?php
//echo __FILE__."<br/>";
?>
<style>
    hr {
        display: block;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
        margin-left: auto;
        margin-right: auto;
        border-style: inset;
        border-width: 1px;
    }
    .resumen {
        text-transform: capitalize;
        font-style: italic;
    }
    div.label{
        color: #ffffff;
        background-color: #3598DC;
        font-size: larger;
        padding: 5px !important;
    }
    .load2{
        height: 25px !important;

    }
    .exito{
        color: #75A362;
        font-style: italic;

    }

    .warning{
        color: #F8AE0D;
        font-style: italic;
    }
    table#contenedor_resultado td, table#contenedor_resultado tr{
        height: 30px !important;
        border-width: 0 !important;
        text-align: left;
        background: #4C4C4C;
    }
    table#contenedor_resultado td.label1{
        width: 250px;
        color: #ffffff;
        font-size: larger;
    }
    table#contenedor_resultado td.label2{
        width: 225px;
        text-align: center;
    }
    table#contenedor_resultado td.label2 img{

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
        <hr>
        <h3>
            Cuadro De Resultados De Ingreso
        </h3>
        <p>Para finalizar el proceso de matrícula presione el botón azul que dice <b>Ingresar</b></p>
        <table id="contenedor_resultado">
            <tr>
                <td class="label1" id="load_ingreso_alumno_label">&nbsp;</td>
                <td class="label2" id="load_ingreso_alumno">&nbsp;</td>
                <td class="label3" id="msg_ingreso_alumno">&nbsp;</td>
            </tr>
            <tr>
                <td class="label1" id="load_ingreso_sistema1_label">&nbsp;</td>
                <td id="load_ingreso_sistema1">&nbsp;</td>
                <td id="msg_ingreso_sistema1">&nbsp;</td>
            </tr>
            <tr>
                <td class="label1" id="load_ingreso_apoderado_label">&nbsp;</td>
                <td id="load_ingreso_apoderado">&nbsp;</td>
                <td id="msg_ingreso_apoderado">&nbsp;</td>
            </tr>

            <tr>
                <td class="label1" id="load_ingreso_sistema2_label">&nbsp;</td>
                <td id="load_ingreso_sistema2">&nbsp;</td>
                <td id="msg_ingreso_sistema2">&nbsp;</td>
            </tr>
            <tr>
                <td class="label1" id="load_ingreso_matricula_label">&nbsp;</td>
                <td id="load_ingreso_matricula">&nbsp;</td>
                <td id="msg_ingreso_matricula">&nbsp;</td>
            </tr>
        </table>




    </div>
</div>