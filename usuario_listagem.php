<?php
session_start("login");

/* Inclui classe UsuarioDAO */
require_once("_script/UsuarioDAO.php");

/* Testa se a variável de sessão está setada corretamente */
/* Caso contrário, gera erro acusando que o login não foi feito */
if( !isset($_SESSION["nome_usuario_logado"]) )
	header('Location: index.php?ERRO=2');

/* Se foi digitado um nome para pesquisa, salva ele em $nome */
if( isset($_GET["nPesquisa"]) )
	$nomePesquisa = $_GET["nPesquisa"];

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

	<a href="usuario_cadastrar.php">Cadastrar</a><br/><br/>

	<!-- Pequeno formulário para fazer pesquisa/filtragem de usuários cadastrados -->
	<!-- Retorna para esta mesma página o nome digitado pelo método $_GET -->
	<form action="usuario_listagem.php" method="get">
	<fieldset id="filtro"><legend>Pesquisar Usuário</legend>

		<!-- Campo para nome a ser buscado -->
		<label for="nNome">Nome:</label>
		<input type="text" id="idPesquisa" name="nPesquisa"/>
		
		<!-- Botão de Pesquisar -->
		<input type="submit" value="Pesquisar"/>&nbsp;&nbsp;
		<input type="button" value="Listar Todos" onclick="javascript:window.location.href='usuario_listagem.php'; ">
	
	</fieldset>
	</form>
	<br/><br/>

	<!-- Tabela que lista usuários cadastrados no sistema -->
	<table>
		<tr>
			<th>Nome</th>
			<th>E-mail</th>
			<th>Permissão</th>
			<th>Ação</th>
		</tr>
		<!-- Busca usuários cadastrados no banco -->
		<!-- Se a pesquisa foi acionada, busca por nome, senão lista todos -->
		<?php  
			$usuarioDao = new UsuarioDAO();
			if( isset($_GET["nPesquisa"]) )
				$lista = $usuarioDao->buscaPorNome($nomePesquisa);
			else
				$lista = $usuarioDao->listar();
			
			/* Imprime na tabela em HTML os usuários encontrados */
		 	foreach ($lista as $indice => $usuario) { ?>
			<tr>
				<td><?php echo "$usuario->nome $usuario->sobrenome"; ?></td>
				<td><?php echo $usuario->email; ?></td>
				<td><?php
						if($usuario->admin == 0)
							echo "Normal";
						elseif($usuario->admin == 1)
							echo "Admin";
				?></td>
				<!-- Imprime links (opções) na últim coluna para editar ou excluir usuário -->
				<td>
					<a href="usuario_editar.php?idusuario=<?php echo $usuario->idusuario; ?>">Editar</a>
					&nbsp;&nbsp;
					<a href="usuario_excluir.php?idusuario=<?php echo $usuario->idusuario; ?>">Excluir</a>
				</td>
			</tr>
		<?php } ?>
	</table>


	<br/><br/><a href="console.php">Voltar</a>

</div>
</body>

</html>