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
	<title>Sistema de Gerenciamento | Editar Usuário</title>
</head>


<body>
<div id="interface">

	<h1>Editar Usuário</h1>

	<a href="usuario_listagem.php">Voltar</a><br/><br/>


	<!-- Aqui começa o formulário de edição -->
	<form action="_script/UsuarioProcessamento.php" method="post">
	<fieldset id="login"><legend>Informações do Usuário</legend>

		<!-- Campos escondidos que mandam valores necessários junto com o formuláro -->
		<input type="hidden" name="nIdUsuario" value="<?php echo $usuario->idusuario; ?>" />
		<input type="hidden" name="nAcao" value="editar" />

		<!-- Tabela para formatar formulário -->
		<table>
			<!-- Mostra campo para editar nome do usuário -->
			<tr>
				<td>Nome:</td>
				<td><input type="text" id="idNome" name="nNome" value="<?php echo $usuario->nome; ?>"/></td>
			</tr>
			<!-- Mostra campo para editar sobrenome do usuário -->
			<tr>
				<td>Sobrenome:</td>
				<td><input type="text" id="idSobrenome" name="nSobrenome" value="<?php echo $usuario->sobrenome; ?>"/></td>
			</tr>
			<!-- Mostra campo para editar e-mail do usuário -->
			<tr>
				<td>E-mail:</td>
				<td><input type="text" id="idEmail" name="nEmail" value="<?php echo $usuario->email; ?>"/></td>
			</tr>
			<!-- Mostra campo para editar senha do usuário -->
			<tr>
				<td>Senha:</td>
				<td><input type="password" id="idSenha" name="nSenha" /></td>
			</tr>
			<!-- Botões radio para selecionar o tipo de permissão do suário -->
			<!-- Fica marcado previamente o  -->
			<tr>
				<td>Permissão:</td>
				<td><input type="radio" name="nPermissao" value="normal" 
					<?php if($usuario->admin == "0"){ ?> 
						checked  
					<?php } ?> />Normal&nbsp;&nbsp;
					<input type="radio" name="nPermissao" value="admin" 
					<?php if($usuario->admin == "1"){ ?> 
						checked 
					<?php } ?> />Admin</td>
			</tr>
			<!-- Mostra botão de Submit no formulário -->
			<tr>
				<td colspan="2"><input type="submit" value="Salvar"/></td>
			</tr>
		</table>
	</fieldset>
	</form>



</div>
</body>

</html>