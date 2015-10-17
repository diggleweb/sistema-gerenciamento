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
	<title>Sistema de Gerenciamento | Listagem de Usuários</title>
</head>


<body>
<div id="interface">

	<h1>Listagem de Usuários</h1>


	<a href="usuario_formulario.php?acao=cadastrar">Cadastrar</a><br/><br/>


	<!-- Tabela que lista usuários cadastrados no sistema -->
	<table>
		<tr>
			<th>Nome</th>
			<th>E-mail</th>
			<th>Permissão</th>
			<th>Ação</th>
		</tr>
		<!-- Busca todos usuários cadastrados no banco-->
		<?php  
			$usuarioDao = new UsuarioDAO();
			$lista = $usuarioDao->listar();
		?>
		<!-- Imprime na tabela em HTML os usuários utilizando o PHP -->
		<?php foreach ($lista as $indice => $usuario) { ?>
			<tr>
				<td><?php echo $usuario->nome; ?></td>
				<td><?php echo $usuario->email; ?></td>
				<td><?php
						if($usuario->admin == 0)
							echo "Normal";
						elseif($usuario->admin == 1)
							echo "Admin";
				?></td>
				<!-- Imprime links (opções) na últim coluna para editar ou excluir usuário -->
				<td>
					<a href="usuario_formulario.php?acao=editar&idusuario=<?php echo $usuario->idusuario; ?>">Editar</a>
					&nbsp;&nbsp;
					<a href="usuario_formulario.php?acao=excluir&idusuario=<?php echo $usuario->idusuario; ?>">Excluir</a>
				</td>
			</tr>
		<?php } ?>
	</table>


	<br/><br/><br/><a href="console.php">Voltar</a>

</div>
</body>

</html>