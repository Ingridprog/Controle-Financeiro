function mudarCampo(){
    let tipo = $("#tipo").val();


    if(tipo == 3){
        $("#destinatario_wrapper").removeClass("d-none");
        $("#destinatario").attr('disabled', false);  
    }else{
        $("#destinatario_wrapper").addClass("d-none");
        $("#destinatario").attr('disabled', true);  
    }
}