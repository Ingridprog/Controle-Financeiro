function logar(){

    let cpf = $('#cpf').val();
    let password = $('#password').val();

    $.ajax({
        url: 'http://127.0.0.1:8000/api/v1/login',
        type: 'POST',
        headers: {
            "accept": "application/json",
            "Access-Control-Allow-Origin": "*"
        },
        data: {
            cpf:cpf,
            password: password
        },
        beforeSend: function () {
            $("#double_req_block").removeClass('d-none')
        },
        success: function (data) {
            // alert(JSON.stringify(data))
            $("#double_req_block").addClass('d-none')
            localStorage.setItem('USER', JSON.stringify(data))
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

function logout(){
    localStorage.removeItem('USER');
}