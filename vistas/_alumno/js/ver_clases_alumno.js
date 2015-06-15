jQuery(document).ready(function(){
    var run_alumno = jQuery("#run_alumno");
    var rbd_establecimiento = jQuery("#rbd_establecimiento");
    var bloques = jQuery("#bloques");

    get_establecimeintos(run_alumno.val());

    rbd_establecimiento.change(function(){
        bloques.css("display","none");
        del_bloques();

        if(rbd_establecimiento.val() == "0"){
            return null;
        }

        bloques.css("display","inline");
        get_clases(run_alumno.val(), rbd_establecimiento.val());
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

function get_clases(run_alumno, rbd_establecimiento){
    console.log("Cargando clases...");
    del_bloques();
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/clase.controlador.php",
        data: {id_funcion: "4", run_alumno: run_alumno, rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            load_on("Cargando clases...", "#contenedor_bloques");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);

            jQuery.each(data,function(i, value){
                var id_dia = "#dia"+data[i].id_dia;
                var id_bloque = "#bloque"+data[i].id_bloque;
                var id_asignatura = data[i].id_asignatura;
                var nombre_asignatura = data[i].nombre_asignatura;

                var clase = "bloque non_selected";
                var selected = "0";

                if(id_asignatura){
                    clase = "bloque selected";
                    selected = "1";
                }

                if(!nombre_asignatura){
                    nombre_asignatura = "Sin Clases"
                }

                jQuery(id_dia).append(
                    jQuery("<div></div>")
                        .addClass(clase)
                        .attr({
                            "id": id_bloque,
                            "data-id_bloque": data[i].id_bloque,
                            "data-selected": selected,
                            "data-id_clase": data[i].id_clase
                        })
                        .css({
                            "background-color": data[i].color2,
                            "color": data[i].color1
                        })
                        .append(
                            jQuery("<div></div>")
                                .addClass("hora")
                                .text(data[i].horario)
                                .css({
                                    "background-color": data[i].color1,
                                    "color": data[i].color2
                                })
                        )
                        .append(
                            jQuery("<div></div>")
                                .addClass("asignatura")
                                .text(nombre_asignatura)
                        )
                        .append(
                            jQuery("<div></div>")
                                .addClass("profesor")
                                .text(data[i].nombre_profesor)
                        )
                );
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

function del_bloques(){
    jQuery(".bloque").remove();
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










