function carregarCliente(){
    let user = JSON.parse(localStorage.getItem('USER'));
    let token = user.token;
    let userInfo = user.user
    
    $.ajax({
        url: `http://127.0.0.1:8000/api/v1/dadospessoais/${userInfo.id}`,
        type: 'GET',
        headers: {
            "accept": "application/json",
            "Access-Control-Allow-Origin": "*",
            "Authorization": `Bearer ${token}`
        },
        beforeSend: function () {
            $("#double_req_block").removeClass('d-none')
        },
        success: function (data) {
            $("#double_req_block").addClass('d-none')
            $('#balance').html(`R$ ${data.data.saldo}`)
        },
        error: function (data) {
            $("#double_req_block").addClass('d-none')
            alert(Object.values(data.responseJSON.errors).map((error) => {
                return `Error: ${error}`
            }))
        }
    })
}


function realizarTransacao(){
    let tipo = $("#tipo").val();
    let nome = $("#nome").val() ?? "não informado";
    let valor = $("#valor").val();
    let destinatario = $('#destinatario').val() != ""? $('#destinatario').val() : "não informado";

    let req = '';
    let transferencia = 0;

    let user = JSON.parse(localStorage.getItem('USER'));
    let token = user.token;
    let userInfo = user.user

    if(tipo == 1)
        req = 'http://127.0.0.1:8000/api/v1/credito';
    else if(tipo == 2)
        req = 'http://127.0.0.1:8000/api/v1/debito';
    else{
        req = 'http://127.0.0.1:8000/api/v1/debito';
        transferencia = 1;
    }

    $.ajax({
        url: req,
        type: 'POST',
        headers: {
            "accept": "application/json",
            "Access-Control-Allow-Origin": "*",
            "Authorization": `Bearer ${token}`
        },
        data: {
            nome: nome,
            transferencia: transferencia,
            valor: parseFloat(valor),
            destinatario: destinatario, 
        },
        success: function (data) {
            $("#double_req_block").addClass('d-none')
            alert(data.messege)
            window.location.href = `inicio.html`;
        },
        error: function (data) {
            $("#double_req_block").addClass('d-none')
            alert(Object.values(data.responseJSON.errors).map((error) => {
                return `Error: ${error}`
            }))
        }
    })
        
}

    