<!DOCTYPE html>
<html lan="pt-br">
<head>
	<meta charset="UTF-8"/>
	<title>Sistema de Gerenciamento | Login</title>
</head>


<body>
<div id="interface">
	<!-- Cria formulário de login na tela -->
	<form action="_script/LoginProcessamento.php" method="post">
	<fieldset id="login"><legend>Login de Usuário</legend>

		<!-- Verifica a existência de erro no processo de Login -->
		<?php if(isset($_GET["ERRO"]) && $_GET["ERRO"] == "1"){ ?>
			<p>Usuario e/ou senha inválido!</p>
		<?php }else if(isset($_GET["ERRO"]) && $_GET["ERRO"] == "2"){ ?>
			<p>Efetue o login!</p>	
		<?php } ?>

		<!-- Campo para e-mail -->
		<p><label for="nEmail">E-mail:</label>
		<input type="text" id="idEmail" name="nEmail"/></p>

		<!-- Campo para senha -->
		<p><label for="nSenha">Senha:&nbsp;</label>
		<input type="password" id="idSenha" name="nSenha"/></p>
		
		<!-- Botão de login -->
		<p><input type="submit" value="Efetuar Login"/></p>
	
	</fieldset>
	</form>

</div>
</body>

</html>