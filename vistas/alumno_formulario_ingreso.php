<?php

//TODO TERMINAR FORMULARIO DE INGRESO (VISTA) Y EL MANEJO CON EL MODELO(CONTROLADOR)
?>
<style>
    #alumno_formulario_ingreso .error{
        color: red;
        font-size: x-small;
        font-style: italic;
    }
    #alumno_formulario_ingreso .colaError{
        height: 0px;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="/_code/js/jquery.Rut.min.js"></script>
<form action="#" id="alumno_formulario_ingreso">
    <table >
        <tbody>
        <tr>
            <td>RUN</td>
            <td>:</td>
            <td colspan="2"><input type="text" id="run" maxlength="9"  ></td>
        </tr>
        <tr>
            <td>Nombres</td>
            <td>:</td>
            <td><input type="text" id="nombre1" ></td>
            <td><input type="text" id="nombre2" ></td>
        </tr>
        <tr class="colaError">
            <td colspan="2"></td>
        <!--<td></td>-->
            <td colspan="2" id="errorNombre1"></td>
         <!--<td></td>-->
        </tr>
        <tr>
            <td>Apellidos</td>
            <td>:</td>
            <td><input type="text" id="apellido1" ></td>
            <td><input type="text" id="apellido2" ></td>
        </tr>
        <tr class="colaError">
            <td colspan="2"></td>
            <!--<td></td>-->
            <td colspan="2"><span id="errorApellido1" class="error"></span></td>
            <!--<td></td>-->
        </tr>
        <tr>
            <td>Fecha de Nacimiento</td>
            <td>:</td>
            <td><input type="date" ></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>¿Necesidades Especiales?</td>
            <td>:</td>
            <td colspan="2"><input type="checkbox"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><input type="submit" name="submit" id="submit" value="Enviar"></td>
        </tr>
        </tbody>
    </table>
</form>
<script>
    var errorSoloLetras = "Solo puedes ingresar letras aquí.";

    $("#alumno_formulario_ingreso").submit(function(){
        var result    = true;
        var regex     = /^[a-zA-ZáéíóúÁÉÍÓÚ]{3,30}$/;

        var nombre1   = $("#nombre1").val();
        var nombre2   = $("#nombre2").val();
        var apellido1 = $("#apellido1").val();
        var apellido2 = $("#apellido2").val();

        if(!regex.test(nombre1)){
            console.log("NOMBRE1 TIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO");
            $("#errorNombre1").html("<span  class='error'>El Primer Nombre ingresaso es incorrecto</span>");
            result = false;
        }
        if(!regex.test(nombre2)){
            console.log("NOMBRE2 TIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO");

            result = false;
        }
        if(!regex.test(apellido1)){
            console.log("APELLIDO1 TIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO");
            $("#errorApellido1").text("El Apellido Paterno ingresaso es incorrecto");
            result = false;
        }
        if(!regex.test(apellido2)){
            console.log("APELLIDOS TIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO");
            result = false;
        }
        return result;

    });

	
/*	//$( "#run" ).Rut();/*
	document.getElementById("nombre1").setCustomValidity(errorSoloLetras);
    document.getElementById("nombre2").setCustomValidity(errorSoloLetras);
    document.getElementById("apellido1").setCustomValidity(errorSoloLetras);
    document.getElementById("apellido2").setCustomValidity(errorSoloLetras);
*/
 </script>