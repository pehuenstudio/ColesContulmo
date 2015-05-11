function load(msg){
    var load = "<div id='panel_loading'><img src='/_code/vistas/img/load.gif'><div id='load_text'>"+msg+"</div></div>";
    return load;
}
function get_regiones(to, contenedor){
    console.log("Invocando Regiones...");
    jQuery.ajax({
        url: "/_code/controladores/select/cargar.options.php",
        data: {id_key: "1" },
        beforeSend: function() {
            jQuery(contenedor).append(load("Cargando regiones…"));
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

function get_provincias(from,to,contenedor){
    console.log("Invocando Provincias...");
    jQuery(to).find("option").remove();
    jQuery(to).append("<option value='0'>Seleccione Provincia</option>");
    jQuery.ajax({
        url: "/_code/controladores/select/cargar.options.php",
        data: {id_key: "2", fk: jQuery(from).val()},
        beforeSend: function() {
            jQuery(contenedor).append(load("Cargando provincias…"));
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

function get_comunas(from,to,contenedor){
    console.log("Invocando Comunas...");
    jQuery(to).find("option").remove();
    jQuery(to).append("<option value='0'>Seleccione Comuna</option>");
    jQuery.ajax({
        url: "/_code/controladores/select/cargar.options.php",
        data: {id_key: "3", fk: jQuery(from).val()},
        beforeSend: function() {
            jQuery(contenedor).append(load("Cargando comunas…"));
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

