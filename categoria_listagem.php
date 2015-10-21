<?php
session_start("login");

/* Inclui classe CategoriaDAO */
require_once("_script/CategoriaDAO.php");

/* Testa se a variável de sessão está setada corretamente */
/* Caso contrário, gera erro acusando que o login não foi feito */
if( !isset($_SESSION["nome_usuario_logado"]) )
	header('Location: index.php?ERRO=2');


/* Instancia um objeto da classe CategoriaDAO */
$categoriaDao = new CategoriaDAO();


/* Verifica se houve requisição para apagar alguma categoria */
if( isset($_GET["excluir"]) ){
	/* Verifica a existência de produtos relacionados à categoria a qual deseja-se excluir */
	$id_prod_rel = $categoriaDao->verificaProdutosRelacionados($_GET["id"]);

	/* Se vetor == nulo, então pode apagar a categoria, pois não existem produtos cadastrados nela */
	if( $id_prod_rel == null ){
		$categoriaDao->excluir($_GET["id"]);
		header("Location: categoria_listagem.php?excluido=1");
	}
	/* Senão, tem que imprimir mensagem de alerta de que existem produtos cadastrados ali */
	else
		header("Location: categoria_listagem.php?erro=1");
}
?>


<!DOCTYPE html>
<html lan="pt-br">
<head>
	<meta charset="UTF-8"/>
	<title>Sistema de Gerenciamento | Listagem de Categorias</title>
</head>


<body>
<div id="interface">

	<h1>Listagem de Categorias</h1>

	<a href="categoria_cadastrar.php">Cadastrar</a><br/><br/>

	<!-- Cria um pequeno formulário para listar categorias e mostrar botões de ações -->
	<form action="_script/CategoriaProcessamento.php" method="get">
	<fieldset id="categorias"><legend>Categorias Cadastradas</legend>
		<table>
			<tr>
				<td>
				<?php
					/* Este método gera uma lista do tipo <select> do HTML */
					$categoriaDao->selectOption();
				?>
				</td>
				<!-- Botão Editar -->
				<td>&nbsp;&nbsp;&nbsp;
					<input type="submit" id="idEditar" name="nEditar" value="Editar" /></td>
				<!-- Botão Excluir -->
				<td>&nbsp;&nbsp;&nbsp;
					<input type="submit" id="idExcluir" name="nExcluir" value="Excluir" /></td>
			</tr>

			<!-- Esta linha só irá aparecer caso tenha sido feita uma requisição de excluir -->
			<?php if( isset($_GET["excluido"]) ){ ?>
						<tr>
							<td colspan="3">Categoria excluída com sucesso!</td>
						</tr>
			<?php }elseif( isset($_GET["erro"]) ){ ?>
						<tr>
							<td colspan="3">Impossível apagar categoria!</td>
						</tr>
			<?php } ?>
		</table>
	</fieldset>
	</form>

	<br/><a href="console.php">Voltar</a>

</div>
</body>

</html>