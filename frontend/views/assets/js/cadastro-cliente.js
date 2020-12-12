function cadastroCliente() {
    let nome = $("#nome").val();
    let cpf = $("#cpf").val();
    let uf = $("#uf").val() ?? "";
    let email = $("#email").val() ?? "";
    let contato = $("#contato").val() ?? "";
    let senha = $("#password").val();

    $.ajax({
        url: 'http://127.0.0.1:8000/api/v1/dadospessoais',
        type: 'POST',
        headers: {
            "accept": "application/json",
            "Access-Control-Allow-Origin": "*"
        },
        data: {
            nome: nome,
            cpf: cpf,
            uf: uf,
            email: email,
            contato: contato,
            saldo: 0.0,
            password: senha
        },
        beforeSend: function () {
            $("#double_req_block").removeClass('d-none')
        },
        success: function (data) {
            alert(data.messege)
            $("#double_req_block").addClass('d-none')
            localStorage.setItem('cliente', JSON.stringify(data.data))
            window.location.href = 'inicio.html';
        },
        error: function (data) {
            $("#double_req_block").addClass('d-none')
            alert(Object.values(data.responseJSON.errors).map((error) => {
                return `Error: ${error}`
            }))
        }
        
    })
}

function recuperarDadosCliente(){
    if (!localStorage.getItem('cliente'))
        return null
    else { 
        let json = JSON.parse(localStorage.getItem('cliente'))
        $("#balance").html("R$ " + (json.saldo).toLocaleString('pt-BR'));
    } 
}