jQuery(document).ready(function(){
    var bloques = new Array();
    var bloquesDel = new Array();
    var rbd_establecimiento = jQuery("#rbd_establecimiento").val();
    get_bloques(rbd_establecimiento,1);
    setTimeout(function(){
        get_cursos()
    },1000);

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
            alert(data);
        });

    });

    jQuery("#contenedor_horario").on("click", ".bloque", function (){
        var selected = jQuery("#"+this.id).attr("data-selected");
        if(selected=='0'){
            jQuery("#"+this.id).attr("data-selected","1");
        }else{
            jQuery("#"+this.id).attr("data-selected","0");
        }
        selected = jQuery("#"+this.id).attr("data-selected");
        if(selected == '1'){
            var i = bloquesDel.indexOf(this.id);
            if(i != -1) {
                bloquesDel.splice(i, 1);
            }
            bloques.push(this.id);
            jQuery("#"+this.id).addClass("selected");
        }else{
            var i = bloques.indexOf(this.id);
            if(i != -1) {
                bloques.splice(i, 1);
            }
            bloquesDel.push(this.id);
            jQuery("#"+this.id).removeClass("selected");

        }
        //alert(bloques.length);

    });

    jQuery("#id_curso").on("change",function(){

        var id_curso = jQuery(this).find(':selected').attr("value");
        var id_tipo_ensenanza = jQuery(this).find(':selected').attr("data-id_tipo_ensenanza");
        var id_grado = jQuery(this).find(':selected').attr("data-id_grado");
        var id_ciclo = 1;
        var id_asignatura_tipo = 1;

        if(id_curso == 0){
            jQuery(".bloque").remove();
            jQuery("#id_asignatura")
                .prop("disabled",true)
                .find("option").remove();
            jQuery("#id_asignatura")
                .append("<option value ='0'>Seleccione Una Asignatura</option>")
            ;
            return null;
        }

        jQuery("#id_asignatura")
            .prop("disabled",false);



        switch (id_tipo_ensenanza){
            case '110':
                if(id_grado > 4){
                    id_ciclo = 2;
                }
                if(id_grado > 6){
                    id_asignatura_tipo = 2;
                }
        }
        //alert(id_asignatura_tipo);
        get_bloques(rbd_establecimiento,id_ciclo);
        get_clases(rbd_establecimiento, id_curso);
        setTimeout(function(){
            get_asignaturas(id_asignatura_tipo);
        },1000);
    });
});

function get_clases(rbd_establecimiento, id_curso){
    //alert(id_curso);
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/clase.get.datos.php",
        data: {rbd_establecimiento: rbd_establecimiento, id_curso: id_curso}
    })
        .done(function(data){
            //alert(data);
            var data = jQuery.parseJSON(data);
            for(var i = 0; i < data.length; i++){
                var id_bloque = "#"+data[i].id_bloque;
                //console.log(id_bloque);
                jQuery(id_bloque).html("<h1>foo</h1>");
            }

    });
}

function get_cursos(){
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/curso.get.datos.php",
        data: {rbd_establecimiento : jQuery("#rbd_establecimiento").val()},
        beforeSend: function(){
            jQuery("#contenedor_horario").append(load("Cargando cursos del horario..."));
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            for(var i = 0; i < data.length; i++){
                var id_curso = data[i]["id_curso"];
                var id_grado = data[i]["id_grado"];
                var id_tipo_ensenanza = data[i]["id_tipo_ensenaza"];
                var grupo = data[i]["grupo"];
                // alert(id_tipo_ensenanza);
                if(id_tipo_ensenanza == "10"){
                    switch (id_grado){
                        case "4":
                            id_grado = "Pre-Kinder";
                            break;
                        case "5":
                            id_grado = "Kinder";
                            break;
                    }
                }else if(id_tipo_ensenanza == "110"){
                    id_grado = id_grado + " Básico"
                }

                jQuery("#id_curso").append("<option value='"+id_curso+"' data-id_tipo_ensenanza='"+id_tipo_ensenanza+"' data-id_grado='"+data[i]["id_grado"]+"'>"+id_grado+" "+grupo+"</option>");
            }



            setTimeout(function(){
                jQuery("#panel_loading").remove();
            },1000);


        })
        .fail(function(){
            alert("error");
            setTimeout(function(){
                jQuery("#panel_loading").remove();

            },1000);
        })
    ;
}

function get_asignaturas(id_asignatura_tipo){
    jQuery("#id_asignatura")
        .find("option").remove();
    jQuery("#id_asignatura")
        .append("<option value='0'>Seleccione Una Asignatura</option>")
    ;
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/asignatura.get.datos.php",
        data: {id_asignatura_tipo: id_asignatura_tipo},
        beforeSend: function(){
            jQuery("body").append(load("Cargando asignaturas"));
        }
    })
        .done(function(data){
            //alert(data);
            var data = jQuery.parseJSON(data);

            for(var i = 0; i < data.length; i++){
                var id_asignatura = data[i]["id_asignatura"];
                var nombre = data[i]["nombre"];

                jQuery("#id_asignatura").append("<option value='"+id_asignatura+"'>"+nombre+"</option>")

            }
            setTimeout(function(){
                jQuery("#panel_loading").remove();
            },1000);
        })
        .fail(function(){
            alert(error);
            setTimeout(function(){
                jQuery("#panel_loading").remove();
            },1000);
        })

    ;
}

function get_bloques(rbd_establecimiento,id_ciclo){
    jQuery(".bloque").remove();
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/bloque.get.datos.php",
        data: {rbd_establecimiento : rbd_establecimiento, id_ciclo : id_ciclo},
        beforeSend: function(){
            jQuery("#contenedor_horario").append(load("Cargando bloques del horario..."));
        }
    })
        .done(function(data){
            //alert(data);
            var data = jQuery.parseJSON(data);

            for(var i=0; i<data.length; i++){
                var id_bloque = data[i]["id_bloque"];
                var id_dia = "#dia"+data[i]["id_dia"];
                var hora = data[i]["hora_inicio"]+" - "+data[i]["hora_fin"];
                jQuery(id_dia).append(bloque(hora, id_bloque));

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
function load(msg){
    var load = "<div id='panel_loading'><img src='/_code/vistas/img/load.gif'><div id='load_text'>"+msg+"</div></div>";
    return load;
}
function bloque(hora, id_bloque){
    var bloque =    "<div class='bloque' id='"+id_bloque+"' data-selected='0'>" +
                        "<div class='hora'>"+hora+"</div>" +
                        "<div class='asignatura'></div>" +
                    "</div>";

    return bloque;
}
function dump(arr,level) {
    var dumped_text = "";
    if(!level) level = 0;

    //The padding given at the beginning of the line.
    var level_padding = "";
    for(var j=0;j<level+1;j++) level_padding += "    ";

    if(typeof(arr) == 'object') { //Array/Hashes/Objects
        for(var item in arr) {
            var value = arr[item];

            if(typeof(value) == 'object') { //If it is an array,
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += dump(value,level+1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
            }
        }
    } else { //Stings/Chars/Numbers etc.
        dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
    }
    return dumped_text;
}
