<!DOCTYPE html>
<html lan="pt-br">
<head>
	<meta charset="UTF-8"/>
	<title>Sistema de Gerenciamento | Login</title>
</head>


<body>
<div id="interface">

	<form action="script/LoginProcessamento.php" method="post">
	<fieldset id="login"><legend>Login de Usuário</legend>

		<p><label for="nEmail">E-mail:</label>
		<input type="text" id="idEmail" name"nEmail"/></p>

		<p><label for="nSenha">Senha:&nbsp;</label>
		<input type="password" id="idSenha" name"nSenha"/></p>
		
		<p><input type="submit" value="vLogin"/></p>
	
	</fieldset>
	</form>

</div>
</body>

</html>