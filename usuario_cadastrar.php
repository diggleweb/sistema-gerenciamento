<?php
session_start("login");

/* Inclui classe UsuarioDAO */
require_once("_script/UsuarioDAO.php");

/* Testa se a variável de sessão está setada corretamente */
/* Caso contrário, gera erro acusando que o login não foi feito */
if( !isset($_SESSION["nome_usuario_logado"]) )
	header('Location: index.php?ERRO=2');

?>


<!DOCTYPE html>
<html lan="pt-br">
<head>
	<meta charset="UTF-8"/>
	<title>Sistema de Gerenciamento | Cadastrar Usuário</title>
</head>


<body>
<div id="interface">

	<h1>Cadastrar Usuário</h1>

	<a href="usuario_listagem.php">Voltar</a><br/><br/>


	<!-- Aqui começa o formulário de cadastro -->
	<form action="_script/UsuarioProcessamento.php" method="post">
	<fieldset id="login"><legend>Informações do Usuário</legend>

		<!-- Campo escondido que mandam valor necessário junto com o formuláro -->
		<input type="hidden" name="nAcao" value="cadastrar" />

		<!-- Tabela para formatar formulário -->
		<table>
			<!-- Mostra campo para digitar nome do usuário -->
			<tr>
				<td>Nome:</td>
				<td><input type="text" id="idNome" name="nNome" /></td>
			</tr>
			<!-- Mostra campo para digitar sobrenome do usuário -->
			<tr>
				<td>Sobrenome:</td>
				<td><input type="text" id="idSobrenome" name="nSobrenome" /></td>
			</tr>
			<!-- Mostra campo para digitar e-mail do usuário -->
			<tr>
				<td>E-mail:</td>
				<td><input type="text" id="idEmail" name="nEmail" /></td>
			</tr>
			<!-- Mostra campo para digitar senha do usuário -->
			<tr>
				<td>Senha:</td>
				<td><input type="password" id="idSenha" name="nSenha" /></td>
			</tr>
			<!-- Botões radio para selecionar o tipo de permissão do usuário -->
			<tr>
				<td>Permissão:</td>
					<td><input type="radio" name="nPermissao" value="normal" checked />Normal&nbsp;&nbsp;
						<input type="radio" name="nPermissao" value="admin"  />Admin</td>
			</tr>
			<!-- Mostra botão de Submit e Limpar no formulário -->
			<tr>
				<td><input type="reset" value="Limpar"/></td>
				<td><input type="submit" value="Cadastrar"/></td>
			</tr>
		</table>
	</fieldset>
	</form>



</div>
</body>

</html>