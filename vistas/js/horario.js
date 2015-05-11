jQuery(document).ready(function(){
    get_bloques(51543,1);

    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/curso.get.datos.php",
        data: {rbd_establecimiento : jQuery("#rbd_establecimiento").val()},
        beforeSend: function(){
            jQuery("#contenedor_horario").append(load("Cargando cursos del horario..."));
        }
    })
        .done(function(data){
            console.log(data);
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

                jQuery("#id_curso").append("<option id='"+id_curso+"' data-id_tipo_ensenanza='"+id_tipo_ensenanza+"'>"+id_grado+" "+grupo+"</option>");
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


    jQuery("#id_curso").change(function(){
        var id_tipo_ensenanza = jQuery(this).find(':selected').attr("data-id_tipo_ensenanza");
        //alert(jQuery(this).find(':selected').attr("data-id_tipo_ensenanza"));
        get_bloques(51543,id_tipo_ensenanza);
    });
});

function get_bloques(rbd_establecimiento,id_ciclo){
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/bloques.get.datos.php",
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
    var bloque =    "<div class='bloque' id='"+id_bloque+"'>" +
                        "<div class='hora'>"+hora+"</div>" +
                        "<div class='asignatura'></div>" +
                    "</div>";

    return bloque;
}
