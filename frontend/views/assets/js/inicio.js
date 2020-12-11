function realizarTransacao(){
    let tipo = $("#tipo").val();
    let nome = $("#nome").val();
    let valor = $("#valor").val()
    let id_pessoa = JSON.parse(localStorage.getItem('cliente')).id

    if(tipo == 1)
        $req = 'http://127.0.0.1:8000/api/v1/credito'
    else if(tipo == 2)
        $req = 'http://127.0.0.1:8000/api/v1/debito'

    $.ajax({
        url: $req,
        type: 'POST',
        headers: {
            "accept": "application/json",
            "Access-Control-Allow-Origin": "*"
        },
        data: {
            nome: nome,
            transferencia: 0,
            valor: parseFloat(valor),
            id_pessoa: parseInt(id_pessoa)
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