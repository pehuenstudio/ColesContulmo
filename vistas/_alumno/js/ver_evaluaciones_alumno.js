jQuery(document).ready(function() {
    var run_alumno = jQuery("#run_alumno");
    jQuery("#contenedor_selectores").sticky({topSpacing: 0});
    var contenedor_calendario = jQuery("#contenedor_calendario");
    var calendario = jQuery("#calendario");
    var calendario2 = calendario.clone();
    var rbd_establecimiento = jQuery("#rbd_establecimiento");
    var meses = ["", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    var dias_semana = ["", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes"];
    var hoy = new Date();
    var mes_actual = (hoy.getMonth() + 1);
    var ano_actual = hoy.getFullYear();

    if(mes_actual == 1){
        ano_actual -= 1;
        mes_actual = 3;
    }
    if(mes_actual == 2){
        mes_actual = 3;
    }


    if (mes_actual <= 3) {
        jQuery("#boton_atras").css("visibility", "hidden");
    }


    cargar_botones(meses, mes_actual, ano_actual);
    get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
    get_establecimientos(run_alumno.val());


    jQuery("#boton_atras").click(function () {
        mes_actual = (mes_actual - 1);
        cargar_botones(meses, mes_actual, ano_actual);

        console.log(mes_actual+" "+meses[mes_actual]);
        if (mes_actual <= 12) {
            jQuery("#boton_siguiente").css("visibility", "visible")
        }
        if (mes_actual <= 3) {
            jQuery("#boton_atras").css("visibility", "hidden");
        }
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
        get_evaluaciones(run_alumno.val(), rbd_establecimiento.val(), mes_actual);

    });

    jQuery("#boton_siguiente").click(function () {

        mes_actual = (mes_actual + 1);
        cargar_botones(meses, mes_actual, ano_actual);

        console.log(mes_actual);
        if (mes_actual >= 3) {
            jQuery("#boton_atras").css("visibility", "visible")
        }
        if (mes_actual >= 12) {
            jQuery("#boton_siguiente").css("visibility", "hidden");

        }
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
        get_evaluaciones(run_alumno.val(), rbd_establecimiento.val(), mes_actual);
    });

   rbd_establecimiento.change(function () {
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
        if (rbd_establecimiento.val() == "0") {
            return null;
        }

        get_evaluaciones(run_alumno.val(), rbd_establecimiento.val(), mes_actual);
    });

});

function cargar_botones(meses, mes_actual, ano_actual){
    var mes_anterior = (mes_actual - 1);
    var mes_siguiente = (mes_actual + 1);
    jQuery("#boton_atras").val(meses[mes_anterior]);
    jQuery("#boton_siguiente").val(meses[mes_siguiente]);
    jQuery("#mes_actual").text(meses[mes_actual]+" "+ano_actual);
}

function get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual){
    jQuery("#calendario").remove();
    contenedor_calendario.append(calendario2.clone());
    console.log("Cargando calendario...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/calendario.controlador.php",
        data: {id_funcion: "1", mes_actual: mes_actual, ano_actual: ano_actual}
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            var dias = jQuery(".mes").find(".dia");
            dias.find(".fecha").html("&nbsp;");
            dias.attr("data-fecha","");
            var j = 0;
            for (var i = 0; i < dias.length; i++){
                var dia = jQuery(dias[i]);
                if(dia.attr("data-id_dia") == data[j].id_dia){
                    dia.find(".fecha").text(data[j].dia_mes);
                    dia.attr({
                        "data-id_mes": data[j].id_mes,
                        "data-dia_mes":data[j].dia_mes,
                        "data-fecha": data[j].fecha
                    });
                    j++;
                }
                if(j >= data.length){break;}
            }
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){

        })
    ;
}

function get_establecimientos(run_alumno){
    console.log("Cargando establecimientos... "+run_alumno);
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/establecimiento.controlador.php",
        data: {id_funcion: "3", run_alumno: run_alumno},
        beforeSend: function(){
            //load_on("Cargando clases...", "#contenedor_bloques");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i, v){
                jQuery("#rbd_establecimiento")
                    .append(
                    jQuery("<option></option>")
                        .val(data[i].rbd_establecimiento)
                        .text(data[i].nombre)
                )
            });

        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();},500);
        })
    ;
}

function get_evaluaciones(run_alumno, rbd_establecimiento, mes_actual){
    //console.log("Cargando evaluaciones...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/evaluacion.controlador.php",
        data: {id_funcion: "7", run_alumno: run_alumno, rbd_establecimiento: rbd_establecimiento, mes_actual: mes_actual},
        beforeSend: function(){

        }
    })
        .done(function(data){
            //console.log(data);

            var data = jQuery.parseJSON(data);

            jQuery.each(data, function(i, value){
                var fecha = data[i].fecha;
                var dia = jQuery(".dia[data-fecha='"+fecha+"']");
                dia.find(".contenedor_evaluaciones").append(
                    jQuery("<div></div>")
                        .addClass("evaluacion")
                        .attr("data-id_evaluacion", data[i].id_evaluacion)
                        .append(
                            jQuery("<div></div>")
                                .addClass("asignatura")
                                .text("Prueba de "+data[i].nombre_asignatura)
                                .css({
                                    "background-color": data[i].color1,
                                    "color": data[i].color2
                                })
                        )
                        .append(
                            jQuery("<div></div>")
                                .addClass("coeficiente")
                                .text("C"+data[i].coeficiente)
                        )

                );
            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){

        })
    ;
}

function del_selector(selector, msg){
    selector
        .empty()
        .append(
            jQuery("<option></option>")
                .val("0")
                .text(msg)
        )
        .prop("disabled",true)
    ;
}

function mostrar_dialogo(val,msg){
    var clase = "";
    var titulo = "Mensaje";
    var dialogo = jQuery("#dialog");

    switch (val){
        case "1":
            clase = "error-ui";
            titulo = "Error Fatal";
            dialogo.dialog({
                autoOpen: false,
                buttons:[
                    {
                        text: "Intentar Nuevamente",
                        click: function(){
                            jQuery("#dialog").dialog("close");
                        }
                    }
                ]
            });
            break;

        case "2":
            clase = "peligro-ui";
            titulo = "Operación Interrumpida";
            dialogo.dialog({
                autoOpen: false,
                buttons:[
                    {
                        text: "Aceptar",
                        click: function(){
                            jQuery("#dialog").dialog("close");
                        }
                    }
                ]
            });
            break;

        case "3":
            clase = "exito-ui";
            titulo = "Operación exitosa";

            dialogo.dialog({
                autoOpen: false,
                buttons:[]
            });
    }



    dialogo
        .html("<p>"+msg+"</p>")
        .dialog({
            modal:true,
            autoOpen: false,
            dialogClass: clase,
            title: titulo,
            width: "auto"
        })
        .dialog("open");
}

