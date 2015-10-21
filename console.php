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

	<!-- Somente usuários com permissão Admin podem editar Usuários -->
	<?php if(isset($_SESSION["permissao_usuario_logado"]) && $_SESSION["permissao_usuario_logado"] == "1"){ ?>
		<a href="usuario_listagem.php">Usuário</a><br/>
	<?php } ?>
	<a href="produto_listagem.php">Estoque</a><br/>
	<a href="categoria_listagem.php">Categorias</a><br/>
	<a href="_script/Logout.php">Logout</a>

</div>
</body>

</html>