function load_on(msg, contenedor){
    var load = "<div id='panel_loading'><img src='/_code/vistas/img/load.gif'><div id='load_text'>"+msg+"</div></div>";
    jQuery(contenedor).append(load);
}

function load_off(){
    jQuery("#panel_loading").remove()
}
