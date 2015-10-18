<?php
session_start("login");

/* Inclui classe UsuarioDAO */
require_once("_script/UsuarioDAO.php");

/* Testa se a variável de sessão está setada corretamente */
/* Caso contrário, gera erro acusando que o login não foi feito */
if( !isset($_SESSION["nome_usuario_logado"]) )
	header('Location: index.php?ERRO=2');

/* De aordo com o ID do usuário repassado, já busca todas suas informações */
if( isset($_GET["idusuario"]) ){
	$usuarioDao = new UsuarioDAO();
	$usuario = $usuarioDao->buscaPorId($_GET["idusuario"]);
}

?>


<!DOCTYPE html>
<html lan="pt-br">
<head>
	<meta charset="UTF-8"/>
	<title>Sistema de Gerenciamento | Excluir Usuário</title>
</head>


<body>
<div id="interface">

	<h1>Excluir Usuário</h1>

	<a href="usuario_listagem.php">Voltar</a><br/><br/>


	<!-- Aqui começa o formulário de exclusão -->
	<form action="_script/UsuarioProcessamento.php" method="post">
	<fieldset id="login"><legend>Informações do Usuário</legend>

		<!-- Campos escondidos que mandam valores necessários junto com o formuláro -->
		<input type="hidden" name="nIdUsuario" value="<?php echo $usuario->idusuario; ?>" />
		<input type="hidden" name="nAcao" value="excluir" />

		<!-- Tabela para formatar formulário -->
		<table>
			<!-- Campo que mostra o nome do usuário -->
			<tr>
				<td>Nome:</td>
				<td><input type="text" id="idNome" name="nNome" readonly value="<?php echo $usuario->nome; ?>"/></td>
			</tr>
			<!-- Campo que mostra o sobrenome do usuário -->
			<tr>
				<td>Sobrenome:</td>
				<td><input type="text" id="idSobrenome" name="nSobrenome" readonly value="<?php echo $usuario->sobrenome; ?>"/></td>
			</tr>
			<!-- Campo que mostra o e-mail do usuário -->
			<tr>
				<td>E-mail:</td>
				<td><input type="text" id="idEmail" name="nEmail" readonly value="<?php echo $usuario->email; ?>"/></td>
			</tr>
			<!-- Campo que mostra a permissão do usuário -->
			<tr>
				<td>Permissão:</td>
				<td><input type="text" id="idPermissão" name="nPermissao" readonly value="<?php echo ( ($usuario->admin == 1) ? "Administrador" : "Normal"); ?>"/></td>
			</tr>
			<!-- Mostra botão de Submit no formulário -->
			<tr>
				<td colspan="2"><input type="submit" value="Excluir"/></td>
			</tr>
		</table>
	</fieldset>
	</form>



</div>
</body>

</html>