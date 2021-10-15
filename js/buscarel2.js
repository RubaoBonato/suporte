$(function(){ //função enviar do formulario
$("#principal").submit(function(){
//pega dados do forumalario e campo de busca
var busca = $("#buscar").val();
//var ordem = $("#ordem").val();
var action = $(this).attr('action');
//envia post com dados do campo busca
$("#result").html("Buscando...");
$.post(action, {
busca : busca , ordem : ordem
},
//retorna resultado exibido na query php dentro da div #result
function(data) {
if (data != false) {
$("#result").html(data); }
});
return false;
});
});