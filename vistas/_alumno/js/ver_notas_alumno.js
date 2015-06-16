jQuery(document).ready(function(){
    var run_alumno = jQuery("#run_alumno");
    var rbd_establecimiento = jQuery("#rbd_establecimiento");
    var bloques = jQuery("#bloques");
    var contenedor_cartola = jQuery("#contenedor_cartola");
    var asignaturas = jQuery("#asignaturas");
    var asignaturas2 = asignaturas.clone();
    var botones = jQuery(".botones").find("button");

    get_establecimientos(run_alumno.val());

    botones.click(function(){
        var rol = jQuery(this).attr("data-rol");
        jQuery(this)
            .siblings()
            .removeClass();
        jQuery(this)
            .removeClass()
            .addClass("selected");
        switch (rol){
            case "ocultar":
                jQuery(".asignatura").css("display","none");
                break;
            case "mostrar":
                jQuery(".asignatura").css("display","block");
                break;
        }
    });

    rbd_establecimiento.change(function(){
        jQuery("#asignaturas").remove();
        contenedor_cartola.append(asignaturas2.clone());


        if(rbd_establecimiento.val() == "0"){
            jQuery(".botones")
                .css("visibility","hidden")
            ;
            return null;
        }

        get_asignaturas(run_alumno.val(), rbd_establecimiento.val());


    });
});


function get_establecimientos(run_alumno){
    console.log("Cargando establecimientos...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/establecimiento.controlador.php",
        data: {id_funcion: "3", run_alumno: run_alumno},
        beforeSend: function(){
            load_on("Cargando establecimientos...", "#contenedor_cartola");
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

function get_asignaturas(run_alumno, rbd_establecimiento){
    console.log("Cargando asignaturas...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/clase.controlador.php",
        data: {id_funcion: "5", run_alumno: run_alumno, rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            load_on("Cargando asignaturas...", "#contenedor_cartola");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i, v){

                jQuery("#asignaturas")
                    .append(
                        jQuery("<h3></h3>")
                            .text(data[i].nombre_asignatura+" - Prof. "+data[i].nombre_profesor)
                            .attr({
                                "data-id_asignatura":data[i].id_asignatura
                            })
                    )
                    .append(
                        jQuery("<div></div>")
                            .addClass("asignatura")
                            .append(
                                jQuery("<div></div>")
                                    .addClass("contenedor_evaluaciones")
                                    .attr("data-id_asignatura",data[i].id_asignatura)
                                    .append(
                                        jQuery("<div></div>")
                                            .addClass("notas_header")
                                            .append(
                                                jQuery("<div></div>")
                                                    .addClass("fecha_header")
                                                    .text("Fecha")

                                            )
                                            .append(
                                                jQuery("<div></div>")
                                                    .addClass("coeficiente_header")
                                                    .text("Coef.")

                                            )
                                            .append(
                                                jQuery("<div></div>")
                                                    .addClass("valor_header")
                                                    .text("Nota")

                                            )

                                    )
                                    .append(
                                        jQuery("<div></div>")
                                            .addClass("notas")

                                    )
                                    .append(
                                        jQuery("<div></div>")
                                            .addClass("contenedor_promedio")
                                            .append(
                                                jQuery("<div></div>")
                                                    .addClass("promedio_header")
                                                    .text("Promedio")

                                            )
                                            .append(
                                                jQuery("<div></div>")
                                                    .addClass("promedio")
                                                    .attr("data-id_asignatura",data[i].id_asignatura)
                                                    .html("&nbsp;")

                                            )

                                    )

                            )
                    )
                jQuery("head").append(
                    jQuery("<style></style>")
                        .html(".ui-accordion-header[data-id_asignatura="+data[i].id_asignatura+"]{" +
                            "color:red;" +
                            "}")
                );

                //jQuery.style.insertRule(".ui-accordion-header[data-id_asignatura="+data[i].id_asignatura+"]", 'color:red;')
            });
            get_evaluaciones(run_alumno, rbd_establecimiento);
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            //setTimeout(function(){load_off();},500);
        })
    ;
}

function get_evaluaciones(run_alumno, rbd_establecimiento){
    console.log("Cargando evaluaciones...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/evaluacion.controlador.php",
        data: {id_funcion: "8", run_alumno: run_alumno, rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            load_off();
            load_on("Cargando evaluaciones...", "#contenedor_cartola");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            var clase = "";
            jQuery.each(data, function(i, v){
                jQuery(".contenedor_evaluaciones[data-id_asignatura="+data[i].id_asignatura+"]").find(".notas")
                    .append(
                        jQuery("<div></div>")
                            .addClass("evaluacion")
                            .attr("data-id_evaluacion",data[i].id_evaluacion)
                            .append(
                                jQuery("<div></div>")
                                    .addClass("fecha")
                                    .text(data[i].fecha)
                            )
                            .append(
                                jQuery("<div></div>")
                                    .addClass("coeficiente")
                                    .text(data[i].coeficiente)
                            )
                            .append(
                                jQuery("<div></div>")
                                    .addClass("valor")
                                    .html("<p>S/N</p>")
                            )
                    )
            });

            get_notas(run_alumno, rbd_establecimiento);

        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            //setTimeout(function(){load_off();},500);
        })
    ;
}

function get_notas(run_alumno, rbd_establecimiento){
    console.log("Cargando notas...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/nota.controlador.php",
        data: {id_funcion: "3", run_alumno: run_alumno, rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            load_off();
            load_on("Cargando notas...", "#contenedor_cartola");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i, v){
                var clase = "";
                if(data[i].valor < 4){
                    clase = "rojo";
                }else{
                    clase = "azul";
                }
                jQuery("[data-id_evaluacion="+data[i].id_evaluacion+"]")
                    .find(".valor")
                    .html(
                        jQuery("<p></p>")
                            .text(data[i].valor)
                            .addClass(clase)
                    )
            });
            get_calcular_promedio();
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            //setTimeout(function(){load_off();},500);
        })
    ;
}

function get_calcular_promedio(){
    var evaluacionesArray = jQuery(".contenedor_evaluaciones");
    jQuery.each(evaluacionesArray, function(i,v){
        var evaluaciones = jQuery(evaluacionesArray[i]).find(".evaluacion");
        if(evaluaciones.length == 0){
            jQuery(evaluacionesArray[i])
                .empty()
                .append("<p>No hay evaluaciones para esta asignatura, para más información contacte al profesor que la imparte.</p>")
            ;
        }else{
            var sumatoria_notas = 0;
            var sumatoria_coeficientes = 0;
            jQuery.each(evaluaciones, function(i,v){
                var nota = jQuery(evaluaciones[i]).find(".valor").find("p").text();

                var coeficiente = jQuery(evaluaciones[i]).find(".coeficiente").text();

                if(!isNaN(parseFloat(nota).toFixed(1))){
                    sumatoria_notas += parseFloat(nota*coeficiente);
                    sumatoria_coeficientes += parseFloat(coeficiente);
                }

            });
            if(sumatoria_notas > 0){
                var promedio = sumatoria_notas/sumatoria_coeficientes;
                var clase = "";
                if(promedio < 4){
                    clase = "rojo";
                }else{
                    clase = "azul";
                }

                jQuery(evaluacionesArray[i]).find(".promedio").text(promedio.toFixed(1)).addClass(clase);

            }else{
                jQuery(evaluacionesArray[i]).find(".promedio").text("S/N");
            }
        }

    });
    jQuery("#asignaturas")
        .accordion({
            active: false,
            collapsible: true,
            heightStyle: "content"
        })
        .css("visibility","visible")
    ;
    jQuery(".botones")
        .css("visibility","visible")
    ;
    load_off();
}