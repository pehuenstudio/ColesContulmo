jQuery(document).ready(function(){
    var run_alumno = jQuery("#run_alumno");
    var rbd_establecimiento = jQuery("#rbd_establecimiento");
    var bloques = jQuery("#bloques");
    var contenedor_cartola = jQuery("#contenedor_cartola");
    var asignaturas = jQuery("#asignaturas");
    var asignaturas2 = asignaturas.clone();

    get_establecimeintos(run_alumno.val());

    rbd_establecimiento.change(function(){
        jQuery("#asignaturas").remove();
        contenedor_cartola.append(asignaturas2.clone());


        if(rbd_establecimiento.val() == "0"){
            return null;
        }

        get_asignaturas(run_alumno.val(), rbd_establecimiento.val());


    });
});


function get_establecimeintos(run_alumno){
    console.log("Cargando establecimientos...");
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

function get_asignaturas(run_alumno, rbd_establecimiento){
    console.log("Cargando asignaturas...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/asignatura.controlador.php",
        data: {id_funcion: "3", run_alumno: run_alumno, rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            //load_on("Cargando clases...", "#contenedor_bloques");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i, v){
                jQuery("#asignaturas")
                    .append(
                        jQuery("<h3></h3>")
                            .text(data[i].nombre)
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

            });
            //jQuery("#asignaturas").accordion({ active: false, collapsible: true });
            get_evaluaciones(run_alumno, rbd_establecimiento);
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();},500);
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
            //load_on("Cargando clases...", "#contenedor_bloques");
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
            jQuery("#asignaturas").accordion({
                active: false,
                collapsible: true,
                heightStyle: "content"
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

function get_notas(run_alumno, rbd_establecimiento){
    console.log("Cargando notas...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/nota.controlador.php",
        data: {id_funcion: "3", run_alumno: run_alumno, rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            //load_on("Cargando clases...", "#contenedor_bloques");
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
            setTimeout(function(){load_off();},500);
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
            console.log("notas de esta asignatura");
            var sumatoria_notas = 0;
            var sumatoria_coeficientes = 0;
            jQuery.each(evaluaciones, function(i,v){
                var nota = jQuery(evaluaciones[i]).find(".valor").find("p").text();

                var coeficiente = jQuery(evaluaciones[i]).find(".coeficiente").text();

                if(!isNaN(parseFloat(nota).toFixed(1))){
                    console.log(nota);
                    console.log(coeficiente);
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
}