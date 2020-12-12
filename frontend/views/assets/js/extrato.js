function extrato(){
    let user = JSON.parse(localStorage.getItem('USER'));
    let token = user.token;
    let userInfo = user.user

    $('#saldo-final').html(`R$ ${userInfo.saldo.replace('.', ',')}`)

    var extrato = [];

    $.ajax({
        url: `http://127.0.0.1:8000/api/v1/credito`,
        type: 'GET',
        headers: {
             "accept": "application/json",
             "Access-Control-Allow-Origin": "*",
             "Authorization": `Bearer ${token}`
        },
        async: false,
        beforeSend: function () {
             $("#spinner-loader").removeClass('d-none');
        },
        success: function (data) {
            $("#spinner-loader").addClass('d-none');
            let arr = data.data;
            arr.forEach(element => {
                element.type = 1;
                extrato.push(element);
            });
        },
        error: function () {
             console.log("ERROR");
        }
   })

   $.ajax({
        url: `http://127.0.0.1:8000/api/v1/debito`,
        type: 'GET',
        headers: {
            "accept": "application/json",
            "Access-Control-Allow-Origin": "*",
            "Authorization": `Bearer ${token}`
        },
        async: false,
        beforeSend: function () {
            $("#spinner-loader").removeClass('d-none');
        },
        success: function (data) {
            $("#spinner-loader").addClass('d-none');
            let arr = data.data;
            arr.forEach(element => {
                element.type = 2;
                extrato.push(element);
            });
        },
        error: function () {
            console.log("ERROR");
        }
    })
   
    extrato.sort(function compare(a, b){
        if(a.updated_at < b.updated_at) return 1;
        if(a.updated_at > b.updated_at) return -1;
        return 0
    }) 

    $("#tabela").html(renderizarExtrato(extrato))
}

function renderizarExtrato(json){

    let data = new Date();

    return json.map((dados) => {
        let cor = "red"
        let sinal = "-"

        if (dados.type == 1){
            cor = "green"
            sinal = "+"
        }
        return `
        <tr>
             <td>${dados.nome}</td>
             <td>${dados.type == 1 ? "Crédito" : "Débito"}</td>
             <td>${dados.transferencia == 1 ? "SIM" : "NÃO"}</td>
             ${console.log(dados)}
             <td style="color:${cor};"> ${sinal} R$ ${dados.valor.replace('.', ',')}</td>        
        </tr>    
        `
   })
}

