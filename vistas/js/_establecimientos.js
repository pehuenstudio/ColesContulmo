function load(msg){
    var load = "<div id='panel_loading'><img src='/_code/vistas/img/load.gif'><div id='load_text'>"+msg+"</div></div>";
    return load;
}
function get_establecimientos(to,contenedor){
    console.log("Invocando Establecimientos...");
    jQuery.ajax({
        url: "/_code/controladores/select/cargar.options.php",
        data: {id_key: "6" },
        beforeSend: function() {
            jQuery(contenedor).append(load("Cargando establecimientos…"));
        }
    })
        .done(function(data){
            jQuery(to).append(data);
        })
        .fail(function(){
            alert( "error" );
        })
        .always(function(){

                jQuery("#panel_loading").remove();


        });
}

function get_establecimientos_tipos_ensenanza(from,to,contenedor){
    console.log("Invocando Tipos de Enseñanza...");
    jQuery(to).find("option").remove();
    jQuery(to).append("<option value='0'>Seleccione Tipo De Enseñanza</option>");
    jQuery.ajax({
        url: "/_code/controladores/select/cargar.options.php",
        data: {id_key: "7", fk: jQuery(from).val()},
        beforeSend: function() {
            jQuery(contenedor).append(load("Cargando tipos de enseñanza..."));
        }
    })
        .done(function(data){
            jQuery(to).removeAttr('disabled');
            jQuery(to).append(data);
        })
        .fail(function(){
            alert( "error" );
        })
        .always(function(){

                jQuery("#panel_loading").remove();


        });

}

function get_establecimientos_grados(from,from2,to,contenedor){
    console.log("Invocando grados...");
    jQuery(to).find("option").remove();
    jQuery(to).append("<option value='0'>Seleccione Grado</option>");
    jQuery.ajax({
        url: "/_code/controladores/select/cargar.options.php",
        data: {id_key: "8", fk: jQuery(from).val(), fk2: jQuery(from2).val()},
        beforeSend: function() {
            jQuery(contenedor).append(load("Cargando grados..."));
        }
    })
        .done(function(data){
            jQuery(to).removeAttr('disabled');
            jQuery(to).append(data);
        })
        .fail(function(){
            alert( "error" );
        })
        .always(function(){

                jQuery("#panel_loading").remove();


        });

}

function get_establecimientos_cursos(from,from2,from3,to,contenedor){
    console.log("Invocando grupos...");
    jQuery(to).find("option").remove();
    jQuery(to).append("<option value='0'>Seleccione Grupos</option>");
    jQuery.ajax({
        url: "/_code/controladores/select/cargar.options.php",
        data: {id_key: "9", fk: jQuery(from).val(), fk2: jQuery(from2).val(), fk3: jQuery(from3).val()},
        beforeSend: function() {
            jQuery(contenedor).append(load("Cargando grupos..."));
        }
    })
        .done(function(data){
            jQuery(to).removeAttr('disabled');
            jQuery(to).append(data);
        })
        .fail(function(){
            alert( "error" );
        })
        .always(function(){

                jQuery("#panel_loading").remove();


        });

}