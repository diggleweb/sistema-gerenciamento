
$(document).ready(function(){

	// close automatically alert window in 6 seconds
	$(".alert").addClass("in").fadeOut(6000);


	// swap open/close side menu icons
	$('[data-toggle=collapse]').click(function(){
	  	// toggle icon
	  	$(this).find("i").toggleClass("glyphicon-chevron-up glyphicon-chevron-down");
	});

	//Submete o formulário para edição de usuário dentro do Modal
	$("#buttonEditarUsuario").click(function() {
		$("#formEditarUsuario").submit();
	});

	//Submete o formulário para exclusão de usuário dentro do Modal
	$("#buttonExcluirUsuario").click(function() {
		$("#formExcluirUsuario").submit();
	});

});

$(document).ready(function () {
        $('.dropdown-toggle').dropdown();
});


//Função jQuery que pega o ID e o nome do usuário a ser excluído e mostra isso na janela Modal
//que é criada quando o usuário clica em "Excluir".
//O ID é passado para um campo escondido dentro do modal-body
$(document).on("click", ".modalExcluirUsuario", function () {
     var idUsr = $(this).data('id'); //campo data-id
     var nomeUsr = $(this).data('nome'); //campo data-nome
     $("#modal-body-excluir-usr #idInput").val( idUsr );
     $("#modal-body-excluir-usr #nomeSpan").text( nomeUsr );
});


//Função jQuery que pega dados do usuário selecionado e mostra isso na janela Modal
//que é criada quando o usuário clica em "Editar".
//O formulário é preenchido através desta função e depois pode ser editado
$(document).on("click", ".modalEditarUsuario", function () {
     var idUsr = $(this).data('id'); //campo data-id
     var nomeUsr = $(this).data('nome'); //campo data-nome
     var sobrenomeUsr = $(this).data('sobrenome'); //campo data-sobrenome
     var emailUsr = $(this).data('email'); //campo data-email
     var permissaoUsr = $(this).data('permissao'); //campo data-permissao

     $("#modal-body-editar-usr #idInput").val( idUsr );
     $("#modal-body-editar-usr #nomeInput").val( nomeUsr );
     $("#modal-body-editar-usr #sobrenomeInput").val( sobrenomeUsr );
     $("#modal-body-editar-usr #emailInput").val( emailUsr );
     if(permissaoUsr == "1")
     	$("#modal-body-editar-usr #adminRadio").prop("checked", true);
     else
     	$("#modal-body-editar-usr #normalRadio").prop("checked", true);

});