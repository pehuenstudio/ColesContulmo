function load(msg){
    var load = "<div id='panel_loading'><img src='/_code/vistas/img/load.gif'><div id='load_text'>"+msg+"</div></div>";
    return load;
}
function get_grados_educacionales(to,contenedor){
    console.log("Invocando grados educacionales  ...");
    jQuery.ajax({
        url: "/_code/controladores/select/cargar.options.php",
        data: {id_key: "5" },
        beforeSend: function() {
            jQuery(contenedor).append(load("Cargando grados educacionales…"));
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
