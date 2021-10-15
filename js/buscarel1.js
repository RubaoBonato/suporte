function busca(){
$.ajax({
type: "POST",
url: "buscarel1.php",
data: "cod="+ $("#pesq").val(),
dataType: "html",
success: function(data)
{
	$("#pagina").val(data);
}
});
}

function init(){
$("#pesq").blur(busca);
}
$(init);