jQuery(document).ready(function(){
    var bloques = new Array();
    var bloquesDel = new Array();
    var rbd_establecimiento = jQuery("#rbd_establecimiento").val();
    jQuery("#contenedor_formulario").sticky({topSpacing:0});
    //get_bloques0(rbd_establecimiento,1);

    get_siclos();

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
                .append("<option value='0'>Seleccione Una Asignatura</option>")
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

    jQuery("#contenedor_bloques").on("click", ".bloque", function (){

       // console.log("cambiando");
        var id_bloque = "#"+this.id;
        var selected = jQuery(id_bloque).attr("data-selected");
        var nombre_asignatura = jQuery("#id_asignatura").find(":selected").text();

        //console.log(nombre_asignatura);
        if(selected=='0'){
            if(jQuery("#id_asignatura").find(":selected").val() == "0"){
                return null;
            }
            jQuery(id_bloque).attr("data-selected","1");
            jQuery(id_bloque).addClass("selected");
            jQuery(id_bloque).children(".asignatura").text(nombre_asignatura);
            var i = bloquesDel.indexOf(this.id);
            if(i != -1) {
                bloquesDel.splice(i, 1);
            }
            bloques.push(this.id);
        }else{
            jQuery(id_bloque).attr("data-selected","0");
            jQuery(id_bloque).removeClass("selected");
            jQuery(id_bloque).children(".asignatura").text("Sin clases");

            var i = bloques.indexOf(this.id);
            if(i != -1) {
                bloques.splice(i, 1);
            }
            bloquesDel.push(this.id);

        }

        console.log("actualizar "+bloques);
        console.log("null para estos "+bloquesDel);

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
            processData:false


        }).done(function(data){
            console.log(data);
        });

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
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/curso.get.datos.php",
        data: {rbd_establecimiento: rbd_establecimiento, id_ciclo: id_ciclo},
        beforeSend: function(){
            load_on("Cargando Cursos...")
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
            load_on("Cargando clases...")
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);


            jQuery.each(data,function(i, value){
                var id_bloque = data[i].id_bloque;
                var id_dia = "#dia"+data[i].id_dia;
                var nombre_asignatura = data[i].nombre_asignatura;
                var hora = data[i].hora_inicio+ " - " +data[i].hora_fin;
                var id_asignatura = data[i].id_asignatura;
                //console.log(id_asignatura);
                get_clases(id_dia, hora, id_bloque, nombre_asignatura, id_asignatura);
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

function get_clases(id_dia, hora, id_bloque, nombre_asignatura, id_asignatura){
    if(id_asignatura){
        var clase = "bloque selected";
        var selected = "1";
    }else{
        var clase = "bloque"
        var selected = "0";
    }
    var bloque =    "<div class='"+clase+"' id='"+id_bloque+"' data-selected='"+selected+"'>" +
        "<div class='hora'>"+hora+"</div>" +
        "<div class='asignatura'>"+nombre_asignatura+"</div>" +
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
            load_on("Cargando asignaturas...");
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
            load_on("Cargando bloques del horario...");
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



function load_on(msg){
    var load = "<div id='panel_loading'><img src='/_code/vistas/img/load.gif'><div id='load_text'>"+msg+"</div></div>";
    jQuery("#contenedor_bloques").append(load);
}

function load_off(){
    jQuery("#panel_loading").remove()
}








