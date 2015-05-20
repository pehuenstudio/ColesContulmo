function validar_run(runInput){
    run = runInput.val();
    run = run.replace(/\./gi,"");
    run = run.replace(/\-/gi,"");
    //console.log("run: "+run);
    var numero = run.substr(0,run.length-1);
    //console.log("NUMERO = " + numero);
    var dv = (run.substr(run.length-1,1)).toUpperCase();
    //console.log("DV = " + dv)
    var serie = ["2","3","4","5","6","7"];
    var procucto;
    var sumatoria = 0
    var resto;
    var j = 0;

    for (var i = numero.length-1; i>=0; i--){
        procucto = numero.charAt(i)*serie[j];
        //console.log(numero.charAt(i)+" * "+serie[j]+" = "+procucto);
        sumatoria = procucto + sumatoria;
        //console.log("SUMATORIA = "+sumatoria);
        j++;
        if (j > 5){
            j = 0;
        }

    }
    //console.log("TOTAL: "+sumatoria);
    resto = (sumatoria % 11);
    //console.log(resto);
    //console.log("DV CORRESPONDIENTE = " + (11 - resto));

    switch (dv){
        case "0":
            dv = "11";
            break;
        case "K":
            dv = "10";
    }

    if (dv != (11 - resto)){
        runInput.attr("class","error");
        runInput.siblings(".error").html("<p>Ingrese Un RUN Valido</p>");
        return false;
    }
    runInput.attr("class","");
    runInput.siblings(".error").html("&nbsp;");
    return true;
}

function validar_textoMinMax(input,min,max,msg){
    var inputTexto = input.val();
    var regExp =  new RegExp("^[a-záéíóúñö ]{"+min+","+max+"}$","i");
    if(!regExp.test(inputTexto)){
        input.attr("class","error");
        input.siblings(".error").html("<p>"+msg+"</p>");
        return false;
    }
    input.attr("class","");
    input.siblings(".error").html("&nbsp;");
    return true;
}

function validar_numeroMinMax(input,min,max,msg){
    var inputNumero = input.val();
    var regExp =  new RegExp("^[0-9]{"+min+","+max+"}$","i");
    if(!regExp.test(inputNumero)){
        input.attr("class","error");
        input.siblings(".error").html("<p>"+msg+"</p>");
        return false;
    }
    input.attr("class","");
    input.siblings(".error").html("&nbsp;");
    return true;
}

function validar_numeroMinMax2(input,min,max,msg,error){
    var inputNumero = input.val();
    var regExp =  new RegExp("^[0-9]{"+min+","+max+"}$","i");
    if(!regExp.test(inputNumero)){
        input.attr("class","error");
        jQuery(error).html("<p>"+msg+"</p>");
        return false;
    }
    input.attr("class","");
    jQuery(error).html("&nbsp;");
    return true;
}

function validar_numeroTextoMinMax(input,min,max,msg){
    var inputNT = input.val();
    var regExp =  new RegExp("^[a-zñ0-9 ]{"+min+","+max+"}$","i");
    if(!regExp.test(inputNT)){
        input.attr("class","error");
        input.siblings(".error").html("<p>"+msg+"</p>");
        return false;
    }
    input.attr("class","");
    input.siblings(".error").html("&nbsp;");
    return true;
}

function validar_select(select,msg){
    var selectOp = select.val();
    if(selectOp == 0){
        select.attr("class","error");
        select.siblings(".error").html("<p>"+msg+"</p>");
        return false;
    }
    select.attr("class","");
    select.siblings(".error").html("&nbsp;");
    return true;
}

function validar_fecha(date,msg){
    var dateTexto = date.val();
    var dateFormat = new Date(dateTexto);
    var hoy = new Date();
    var regExp = /^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/;
    if(dateFormat.getFullYear() >= hoy.getFullYear()){
        date.attr("class","error");
        date.siblings(".error").html("<p>"+msg+"</p>");
        return false;
    }
    if((hoy.getFullYear() - dateFormat.getFullYear()) > 100){
        date.attr("class","error");
        date.siblings(".error").html("<p>"+msg+"</p>");
        return false;
    }
    if(!regExp.test(dateTexto)){
        date.attr("class","error");
        date.siblings(".error").html("<p>"+msg+"</p>");
        return false;
    }
    date.attr("class","");
    date.siblings(".error").html("&nbsp;");
    return true;
}

function validar_email(email,msg){
    var emailText = email.val();
    if (emailText == ""){
        email.attr("class","");
        email.siblings(".error").html("&nbsp;");
        return true;
    }
    var regExp = /[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}/;
    if(!regExp.test(emailText)){
        email.attr("class","error");
        email.siblings(".error").html("<p>"+msg+"</p>");
        return false;
    }
    email.attr("class","");
    email.siblings(".error").html("&nbsp;");
    return true;
}

function validar_imagen_extencion(file,msg){
    var img = file.val();
    var extension = img.substr( (img.lastIndexOf('.') +1) );
    if(extension == ""){
        return true;
    }
    if(extension != "png" && extension != "jpeg" && extension != "jpg"){
        file.attr("class","error");
        file.siblings(".error").html("<p>"+msg+"</p>");
        return false;
    }
    file.attr("class","");
    file.siblings(".error").html("&nbsp;");
    return true;
}
