// Recupera os dados do Formulário

var form = document.getElementById('formPessoa')
var nome = document.getElementById('nome-p')
var dataNascimento = document.getElementById('data_nascimento')
var cpf = document.getElementById('cpf')
var rg = document.getElementById('rg')
var telefone = document.getElementById('telefone')
var cep = document.getElementById('cep')
var uf = document.getElementById('uf')
var numero = document.getElementById('numero')
var endereco = document.getElementById('endereco')


// Executa a validação
function valido() {

  return validaInput()
}

// verifica se os campos sao validos
function validaInput() {

  if (nome.value === '') {
    alert('Prenecha o nome')
    nome.focus()
    return false
  }

  if (dataNascimento.value === '') {
    alert('Prenecha a data de nascimento')
    dataNascimento.focus()
    return false
  }
  if (cpf.value === '') {
    alert('Prenecha o CPF')
    cpf.focus()
    return false
  }
  if (rg.value === '') {
    alert('Prenecha o RG')
    rg.focus()
    return false
  }
  if (telefone.value === '') {
    alert('Prenecha o Telefone')
    telefone.focus()
    return false
  }

  if (cep.value === '') {
    alert('Prenecha o CEP')
    cep.focus()
    return false
  }
  if (uf.value === '') {
    alert('Prenecha o UF')
    uf.focus()
    return false
  }

  if (numero.value === '') {
    alert('Prenecha o Número')
    numero.focus()
    return false
  }
  if (endereco.value === '') {
    alert('Prenecha o Endereço')
    endereco.focus()
    return false
  }
  
  return true
}