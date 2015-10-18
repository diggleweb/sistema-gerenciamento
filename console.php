<?php
session_start("login");

/* Testa se a variável de sessão está setada corretamente */
/* Caso contrário, gera erro acusando que o login não foi feito */
if( !isset($_SESSION["nome_usuario_logado"]) )
	header('Location: index.php?ERRO=2');
?>


<!DOCTYPE html>
<html lan="pt-br">
<head>
	<meta charset="UTF-8"/>
	<title>Sistema de Gerenciamento | Console</title>
</head>


<body>
<div id="interface">

Olá, <?php echo $_SESSION["nome_usuario_logado"]; ?>. Seja bem-vindo!<br/><br/>

	<!-- Verifica a existência de erro no processo de Login -->
	<?php if(isset($_SESSION["permissao_usuario_logado"]) && $_SESSION["permissao_usuario_logado"] == "1"){ ?>
		<a href="usuario_listagem.php">Usuário</a><br/>
	<?php } ?>
	<a href="_script/Logout.php">Estoque</a>
	<a href="_script/Logout.php">Logout</a>

</div>
</body>

</html>