jQuery(document).ready(function(){
    var bloques = new Array();
    var bloquesDel = new Array();
    var rbd_establecimiento = jQuery("#rbd_establecimiento").val();
    // var periodo = jQuery("#periodo").val();

    jQuery("#contenedor_formulario").sticky({topSpacing:0});
    //get_bloques0(rbd_establecimiento,1);

    get_siclos();
    //get_profesores(rbd_establecimiento);
    setTimeout(function(){
        get_profesores(rbd_establecimiento);
    },500);

    jQuery("#id_ciclo").change(function(){
        del_bloques();
        var id_ciclo = jQuery("#id_ciclo").val();
        //get_bloques0(rbd_establecimiento,id_ciclo);
        if(id_ciclo == "0"){
            jQuery("#contenedor_bloques").css("display","none");
            //jQuery("#contenedor_info").css("display","inline");
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
        //jQuery("#contenedor_bloques").css("display","inline");
        //jQuery("#contenedor_info").css("display","none");
        jQuery("#id_curso").empty()
            .prop("disabled", false)
            .append("<option value='0'>Seleccione Un Curso</option>");

        get_cursos(rbd_establecimiento, id_ciclo);
    });

    jQuery("#id_curso").change(function(){
        del_bloques();
        var id_curso = jQuery("#id_curso").val();
        if(id_curso == "0"){
            jQuery("#contenedor_bloques").css("display","none");
            //jQuery("#contenedor_info").css("display","inline");
            jQuery("#id_asignatura").empty()
                .prop("disabled", true)
                .append("<option value='0'>Seleccione Una Asignatura</option>");
            jQuery("#run_profesor")
                .prop("disabled", true)
                .val("0");
            return null;
        }
        jQuery("#contenedor_bloques").css("display","inline");
        //jQuery("#contenedor_info").css("display","none");
        jQuery("#id_asignatura").empty()
            .prop("disabled", false)
            .append("<option value='0'>Seleccione Una Asignatura</option>")
        var id_grado = jQuery(this).find(":selected").data("id_grado");
        var id_tipo_ensenanza = jQuery(this).find(":selected").data("id_tipo_ensenanza");
        //console.log(id_tipo_ensenanza);

        get_bloques(rbd_establecimiento, id_curso);

        setTimeout(function(){
            get_asignaturas(id_grado, id_tipo_ensenanza);
        },1000);

    });

    jQuery("#id_asignatura").change(function(){
        var selected = jQuery("#id_asignatura").val();
        if(selected == "0"){
            jQuery("#run_profesor")
                .prop("disabled", true)
                .val("0");
            return null;
        }
        jQuery("#run_profesor")
            .prop("disabled", false)
        ;

    });

    jQuery("#contenedor_bloques").on("click", ".bloque", function (){

        // console.log("cambiando");
        var id_bloque = "#"+this.id;
        var id_clase = jQuery(id_bloque).attr("data-id_clase");
        var selected = jQuery(id_bloque).attr("data-selected");
        var nombre_asignatura = jQuery("#id_asignatura").find(":selected").text();
        var id_asignatura = jQuery("#id_asignatura").find(":selected").val();
        var nombre_profesor = jQuery("#run_profesor").find(":selected").text();
        var run_profesor = jQuery("#run_profesor").find(":selected").val();
        var matriz = {"id_bloque":this.id,"id_asignatura":id_asignatura,"run_profesor":run_profesor, "id_clase": id_clase};

        if(selected=='0'){
            if(id_asignatura == "0"){
                mostrar_dialogo("21","Para ingresar una clase primero debes seleccionar una asignatura.");
                return null;
            }
            if(run_profesor == "0"){
                mostrar_dialogo("21","Para ingresar una clase primero debes seleccionar un(a) profesor(a).");
                return null;
            }
            jQuery(id_bloque).attr("data-selected","1");
            jQuery(id_bloque).addClass("selected");
            jQuery(id_bloque).children(".asignatura").text(nombre_asignatura);
            jQuery(id_bloque).children(".profesor").text(nombre_profesor);

            for (var e = 0; e < bloquesDel.length ; e++){
                if(bloquesDel[e].id_bloque == matriz.id_bloque){
                    bloquesDel.splice(e, 1);
                }
            }
            bloques.push(matriz);

        }else{

            jQuery(id_bloque).attr("data-selected","0");
            jQuery(id_bloque).removeClass("selected");
            jQuery(id_bloque).children(".asignatura").text("Sin clases");
            jQuery(id_bloque).children(".profesor").empty();

            for (var e = 0; e < bloques.length ; e++){
                if(bloques[e].id_bloque == matriz.id_bloque){
                    bloques.splice(e, 1);
                }
            }
            bloquesDel.push(matriz);


        }
        //console.log("bloques "+bloques.length);
        //console.log("bloquesdel "+bloquesDel.length);
    });

    jQuery("#formulario_clase").submit(function(){
        event.preventDefault();
        var form = document.getElementById("formulario_clase");
        var miFormData = new FormData(form);
        var bloquesJson = JSON.stringify(bloques);
        var bloquesDelJson = JSON.stringify(bloquesDel);
        miFormData.append("bloques", bloquesJson);
        miFormData.append("bloquesDel", bloquesDelJson);

        jQuery.ajax({
            method: "POST",
            url: "/_code/controladores/clase.ingreso.php",
            data: miFormData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                load_on("Actualizando horario...","#contenedor_bloques");
            }


        }).done(function(data){
            //console.log(data);
            setTimeout(function(){
                load_off();
            },500);
        })
            .fail(function(){
                alert("ERROR");
            })
        ;

    });


});


function get_siclos(){
    jQuery.ajax({
        url: "/_code/controladores/ciclo.get.datos.php"
    })
        .done(function(data){
            //alert(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data,function (i, value){
                var id_ciclo = data[i].id_ciclo;
                var nombre = data[i].nombre;
                jQuery("#id_ciclo").append("<option value='"+id_ciclo+"'>"+nombre+"</option>");
            });
        })
        .fail(function(){
            alert("ERROR");
        })
    ;
}

function get_cursos(rbd_establecimiento, id_ciclo){
    //console.log("cargando_cursos");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/curso.get.datos.php",
        data: {rbd_establecimiento: rbd_establecimiento, id_ciclo: id_ciclo},
        beforeSend: function(){
            load_on("Cargando Cursos...", "#contenedor_bloques");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);

            jQuery.each(data, function(i, value){
                var id_curso = data[i].id_curso;
                var id_grado = data[i].id_grado;
                var id_tipo_ensenanza = data[i].id_tipo_ensenanza;
                var nombre_curso = data[i].nombre_curso;

                jQuery("#id_curso").append("<option value='"+id_curso+"' data-id_grado='"+id_grado+"' data-id_tipo_ensenanza='"+id_tipo_ensenanza+"'>"+nombre_curso+"</option>");
            });
            setTimeout(function(){
                load_off();
            },1000);
        })
    ;
}

function get_bloques(rbd_establecimiento, id_curso){
    del_bloques();
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/clase.get.datos.php",
        data: {rbd_establecimiento: rbd_establecimiento, id_curso: id_curso},
        beforeSend: function(){
            load_on("Cargando clases...", "#contenedor_bloques");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);


            jQuery.each(data,function(i, value){
                var id_clase = data[i].id_clase;
                var id_bloque = data[i].id_bloque;
                var id_dia = "#dia"+data[i].id_dia;
                var nombre_asignatura = data[i].nombre_asignatura;
                var hora = data[i].hora_inicio+ " - " +data[i].hora_fin;
                var id_asignatura = data[i].id_asignatura;
                var nombre_profesor = data[i].nombre_profesor;
                //console.log(id_asignatura);
                get_clases(id_clase, id_dia, hora, id_bloque, nombre_asignatura, id_asignatura, nombre_profesor);
            });

            setTimeout(function(){
                load_off();
            },1000);
        })
        .fail(function(){
            alert("ERROR");
            load_off();
        })
    ;
}

function get_clases(id_clase, id_dia, hora, id_bloque, nombre_asignatura, id_asignatura, nombre_profesor){
    if(id_asignatura){
        var clase = "bloque selected";
        var selected = "1";
    }else{
        var clase = "bloque"
        var selected = "0";
    }
    var bloque =    "<div class='"+clase+"' id='"+id_bloque+"' data-selected='"+selected+"' data-id_clase='"+id_clase+"'>" +
        "<div class='hora'>"+hora+"</div>" +
        "<div class='asignatura'>"+nombre_asignatura+"</div>" +
        "<div class='profesor'>"+nombre_profesor+"</div>"+
        "</div>";
    //console.log(id_dia);
    jQuery(id_dia).append(bloque);
}

function del_bloques(){
    jQuery(".bloque").remove();
}

function get_asignaturas(id_grado, id_tipo_ensenanza){
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/asignatura.get.datos.php",
        data: {id_grado: id_grado, id_tipo_ensenanza: id_tipo_ensenanza},
        beforeSend: function (){
            load_on("Cargando asignaturas...", "#contenedor_bloques");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);


            jQuery.each(data,function(i, value){
                var id_asignatura = data[i]["id_asignatura"];
                var nombre = data[i]["nombre"];
                jQuery("#id_asignatura").append("<option value='"+id_asignatura+"'>"+nombre+"</option>");
            });

            setTimeout(function(){
                load_off();
            },1000);

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
            setTimeout(function(){
                jQuery("#panel_loading").remove();
            },1000);
        })
        .fail(function(){
            alert("alert");
            setTimeout(function(){
                jQuery("#panel_loading").remove();

            },1000);
        })

    ;
}

function get_profesores(rbd_establecimiento){
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/profesor.get.datos.todos.php",
        data: {rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            load_on("Cargando profesores...", "#contenedor_bloques");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);

            jQuery.each(data,function(i,value){
                var run_profesor = data[i].run;
                var nombre1 = data[i].nombre1;
                var apellido1 = data[i].apellido1;
                var apellido2 = data[i].apellido2;
                jQuery("#run_profesor").append("<option value='"+run_profesor+"'>"+nombre1+" "+apellido1+" "+apellido2+"</option>")

            });
            setTimeout(function(){
                load_off();
            },500);
        })
        .fail(function(){
            mostrar_dialogo("0", "La lista de profesores no se cargó correctamente.")
        })
        .always(function(){
            setTimeout(function(){
                load_off();
            },500);
        })
    ;
}











