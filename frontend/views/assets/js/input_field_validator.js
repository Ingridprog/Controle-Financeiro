// Máscaras 
function fMasc(objeto, mascara) {
     obj = objeto
     masc = mascara
     setTimeout("fMascEx()", 1)
}
function fMascEx() {
     obj.value = masc(obj.value)
}
function mTel(tel) {
     tel = tel.replace(/\D/g, "")
     tel = tel.replace(/^(\d)/, "($1")
     tel = tel.replace(/(.{3})(\d)/, "$1)$2")
     if (tel.length == 9) {
          tel = tel.replace(/(.{1})$/, "-$1")
     } else if (tel.length == 10) {
          tel = tel.replace(/(.{2})$/, "-$1")
     } else if (tel.length == 11) {
          tel = tel.replace(/(.{3})$/, "-$1")
     } else if (tel.length == 12) {
          tel = tel.replace(/(.{4})$/, "-$1")
     } else if (tel.length > 12) {
          tel = tel.replace(/(.{4})$/, "-$1")
     }
     return tel;
}

function mCPF(cpf) {
     cpf = cpf.replace(/\D/g, "")
     cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
     cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
     cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
     return cpf
}

function mNum(num) {
     num = num.replace(/\D/g, "")
     return num
}


// Valida CPF
function validaCpf(val) {
     if (val.length == 14) {
          var cpf = val.trim();

          cpf = cpf.replace(/\./g, '');
          cpf = cpf.replace('-', '');
          cpf = cpf.split('');

          var v1 = 0;
          var v2 = 0;
          var aux = false;

          for (var i = 1; cpf.length > i; i++) {
               if (cpf[i - 1] != cpf[i]) {
                    aux = true;
               }
          }

          if (aux == false) {
               return false;
          }

          for (var i = 0, p = 10; (cpf.length - 2) > i; i++, p--) {
               v1 += cpf[i] * p;
          }

          v1 = ((v1 * 10) % 11);

          if (v1 == 10) {
               v1 = 0;
          }

          if (v1 != cpf[9]) {
               return false;
          }

          for (var i = 0, p = 11; (cpf.length - 1) > i; i++, p--) {
               v2 += cpf[i] * p;
          }

          v2 = ((v2 * 10) % 11);

          if (v2 == 10) {
               v2 = 0;
          }

          if (v2 != cpf[10]) {
               return false;
          } else {
               return true;
          }
     } else {
          return false;
     }
}



