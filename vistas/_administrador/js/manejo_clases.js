jQuery(document).ready(function(){
    var clasesIns = [];
    var clasesDel = [];
    var rbd_establecimiento = jQuery("#rbd_establecimiento").val();

    jQuery("#contenedor_formulario").sticky({topSpacing:0});

    get_ciclos(rbd_establecimiento);

    setTimeout(function(){
        get_profesores(rbd_establecimiento);
    },500);

    jQuery("#id_ciclo").change(function(){
        del_bloques();
        var id_ciclo = jQuery("#id_ciclo").val();

        if(id_ciclo == "0"){
            jQuery("#bloques").css("display","none");

            jQuery("#id_curso").empty()
                .prop("disabled", true)
                .append("<option value='0'>Seleccione Un Curso</option>");
            jQuery("#id_asignatura").empty()
                .prop("disabled", true)
                .append("<option value='0'>Seleccione Una Asignatura</option>");
            jQuery("#run_profesor")
                .prop("disabled", true)
                .val("0");
            return null;
        }
        //jQuery("#bloques").css("display","inline");
        //jQuery("#contenedor_info").css("display","none");
        jQuery("#id_curso").empty()
            .prop("disabled", false)
            .append("<option value='0'>Seleccione Un Curso</option>");

        get_cursos(rbd_establecimiento, id_ciclo);

    });

    jQuery("#id_curso").change(function(){
        del_bloques();
        var id_curso = jQuery("#id_curso").val();
        var bloques = jQuery("#bloques");
        var asignatura = jQuery("#id_asignatura");

        if(id_curso == "0"){
            bloques.css("display","none");

            asignatura
                .empty()
                .prop("disabled", true)
                .append("<option value='0'>Seleccione Una Asignatura</option>");
            jQuery("#run_profesor")
                .prop("disabled", true)
                .val("0");
            return null;
        }
        bloques.css("display","inline");

        asignatura
            .empty()
            .prop("disabled", false)
            .append("<option value='0'>Seleccione Una Asignatura</option>")
        var id_grado = jQuery(this).find(":selected").data("id_grado");
        var id_tipo_ensenanza = jQuery(this).find(":selected").data("id_tipo_ensenanza");


        get_bloques(id_curso);

        setTimeout(function(){
            get_asignaturas(rbd_establecimiento, id_curso);
        },500);

    });

    jQuery("#id_asignatura").change(function(){
        var selected = jQuery("#id_asignatura").val();
        var profesor = jQuery("#run_profesor");
        if(selected == "0"){
            profesor
                .prop("disabled", true)
                .val("0");
            return null;
        }
        profesor
            .prop("disabled", false)
        ;

    });

    jQuery("#bloques").on("click", ".bloque", function (){

        var id_bloque = jQuery(this).attr("data-id_bloque");
        var id_clase = jQuery(this).attr("data-id_clase");
        var selected = jQuery(this).attr("data-selected");

        var asignatura = jQuery("#id_asignatura").find(":selected");
        var nombre_asignatura = asignatura.text();
        var id_asignatura = asignatura.val();
        var color1 = asignatura.attr("data-color1");
        var color2 = asignatura.attr("data-color2");

        var profesor = jQuery("#run_profesor").find(":selected");
        var nombre_profesor = profesor.text();
        var run_profesor = profesor.val();

        var matriz = {"id_bloque":id_bloque,"id_asignatura":id_asignatura,"run_profesor":run_profesor, "id_clase": id_clase};


        if(selected=='0'){
            if(id_asignatura == "0"){
                mostrar_dialogo("2","Para ingresar una clase primero debes seleccionar una asignatura.");
                return null;
            }
            if(run_profesor == "0"){
                mostrar_dialogo("2","Para ingresar una clase primero debes seleccionar un(a) profesor(a).");
                return null;
            }
            jQuery(this)
                .attr("data-selected","1")
                .removeClass("non_selected")
                .addClass("selected")
                .css({
                    "background-color": color2,
                    "color": color1
                });
            jQuery(this).find(".hora").css({
                "background-color": color1,
                "color": color2
            });

            jQuery(this).find(".asignatura").text(nombre_asignatura);
            jQuery(this).find(".profesor").text(nombre_profesor);

            for (var e = 0; e < clasesDel.length ; e++){
                if(clasesDel[e].id_bloque == matriz.id_bloque){
                    clasesDel.splice(e, 1);
                }
            }
            clasesIns.push(matriz);

        }else{

            jQuery(this)
                .attr("data-selected","0")
                .removeClass("selected")
                .addClass("non_selected")
            ;
            jQuery(this).find(".asignatura").text("Sin clases");
            jQuery(this).find(".profesor").empty();

            for (var e = 0; e < clasesIns.length ; e++){
                if(clasesIns[e].id_bloque == matriz.id_bloque){
                    clasesIns.splice(e, 1);
                }
            }
            clasesDel.push(matriz);


        }
        //console.log(clasesDel);
        //console.log("bloquesdel "+bloquesDel.length);
    });

    jQuery("#formulario_clase").submit(function(){
        event.preventDefault();
        var form = document.getElementById("formulario_clase");
        var miFormData = new FormData(form);
        miFormData.append("id_funcion", "2");
        var clasesInsJson = JSON.stringify(clasesIns);
        var clasesDelJson = JSON.stringify(clasesDel);
        miFormData.append("clasesIns", clasesInsJson);
        miFormData.append("clasesDel", clasesDelJson);

        jQuery.ajax({
            method: "POST",
            url: "/_code/controladores/clase.controlador.php",
            data: miFormData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                load_on("Actualizando horario...","#contenedor_bloques");
             }
        }).done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            setTimeout(function(){
                mostrar_dialogo(data.result, data.msg);
            },500);
            setTimeout(function(){
                jQuery("#dialog").dialog("close");
            },3000);

        })
            .fail(function(){
                alert("ERROR");
            })
            .always(function(){
                setTimeout(function(){load_off();},500);
            })
        ;

    });


});


function get_ciclos(rbd_establecimiento){
    console.log("Cargando ciclos...")
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/ciclo.controlador.php",
        data: {id_funcion: "1", rbd_establecimiento: rbd_establecimiento}
    })
        .done(function(data){
            console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery.each(data, function (i, value){
                jQuery("#id_ciclo")
                    .append(
                        jQuery("<option></option>")
                            .val(data[i].id_ciclo)
                            .text(data[i].nombre))
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

function get_cursos(rbd_establecimiento, id_ciclo){
    console.log("Cargando cursos...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/curso.controlador.php",
        data: {id_funcion: "2", rbd_establecimiento: rbd_establecimiento, id_ciclo: id_ciclo},
        beforeSend: function(){
            load_on("Cargando Cursos...", "#contenedor_bloques");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i, value){
                jQuery("#id_curso")
                    .append(
                        jQuery("<option></option>")
                            .val(data[i].id_curso)
                            .text(data[i].id_grado+" "+data[i].nombre_curso+" "+data[i].grupo)
                    )
               });
            setTimeout(function(){load_off();},500);
        })
    ;
}

function get_bloques(id_curso){
    console.log("Cargando clases...")
    del_bloques();
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/clase.controlador.php",
        data: {id_funcion: "1", id_curso: id_curso},
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

function get_asignaturas(rbd_establecimiento, id_curso){
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/asignatura.controlador.php",
        data: {id_funcion: "1", rbd_establecimiento: rbd_establecimiento, id_curso: id_curso},
        beforeSend: function (){
            load_on("Cargando asignaturas...", "#contenedor_bloques");
        }
    })
        .done(function(data){
           //console.log(data);
           var data = jQuery.parseJSON(data);

           jQuery.each(data,function(i, value){
                jQuery("#id_asignatura").append(
                    jQuery("<option></option>")
                        .val(data[i].id_asignatura)
                        .text(data[i].nombre)
                        .attr({
                            "data-color1": data[i].color1,
                            "data-color2": data[i].color2
                        })
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

function get_bloques0(rbd_establecimiento,id_ciclo){
    jQuery(".bloque").remove();
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/bloque.get.datos.php",
        data: {rbd_establecimiento : rbd_establecimiento, id_ciclo : id_ciclo},
        beforeSend: function(){
            load_on("Cargando bloques del horario...", "#contenedor_bloques");
        }
    })
        .done(function(data){
            //alert(data);
            var data = jQuery.parseJSON(data);

            for(var i=0; i<data.length; i++){
                var id_bloque = data[i]["id_bloque"];
                var id_dia = "#dia"+data[i]["id_dia"];
                var hora = data[i]["hora_inicio"]+" - "+data[i]["hora_fin"];
                get_clases(id_dia, hora, id_bloque, "", "");

            }
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();},500);
        })
    ;
}

function get_profesores(rbd_establecimiento){
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/profesor.controlador.php",
        data: {id_funcion : "1", rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            load_on("Cargando profesores...", "#contenedor_bloques");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);

            jQuery.each(data,function(i,value){
                jQuery("#run_profesor")
                    .append(
                        jQuery("<option></option>")
                            .val(data[i].run)
                            .text(data[i].nombre1+" "+data[i].apellido1+" "+data[i].apellido2)
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










