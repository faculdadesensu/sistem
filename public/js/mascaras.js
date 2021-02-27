$(document).ready(function () {
    $('#telefone').mask('(00) 00000-0000');
    $('#cpf').mask('000.000.000-00');
    $('#cep').mask('00000-000');
    $('#cnpj').mask('00.000.000/0000-00');
    $('#money').mask('0.000.000.000,00', {reverse: true});
    $('#money2').mask('0.000.000.000,00', {reverse: true});

});


// Funcional em campos do type number
$('.float').change(function () {
    $(this).val(parseFloat($(this).val()).toFixed(2));
});