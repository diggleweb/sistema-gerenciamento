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

/* Seta variáveis de acordo com a ação desejada na página anterior */
$novo = ( isset($_GET["acao"]) && $_GET["acao"]=="cadastrar" ) ? true : false;
$editar = ( isset($_GET["acao"]) && $_GET["acao"]=="editar" ) ? true : false;
$excluir = ( isset($_GET["acao"]) && $_GET["acao"]=="excluir" ) ? true : false;

?>


<!DOCTYPE html>
<html lan="pt-br">
<head>
	<meta charset="UTF-8"/>
	<title>Sistema de Gerenciamento | Manutenção de Usuário</title>
</head>


<body>
<div id="interface">

	<h1>Manutenção de Usuários</h1>

	<a href="usuario_listagem.php">Voltar</a><br/><br/>


	<!-- Aqui começa o formulário de cadastro/edição/exclusão -->
	<form action="_script/UsuarioProcessamento.php" method="post">
	<fieldset id="login"><legend>Informações do usuário</legend>

		<!-- Campos escondidos que mandam valores necessários junto com o formuláro -->
		<input type="hidden" name="nIdUsuario" value="<?php echo (isset($usuario) ? $usuario->idusuario : ""); ?>" />
		<input type="hidden" name="nAcao" value="<?php echo (isset($_GET["acao"]) ? $_GET["acao"] : ""); ?>" />

		<!-- Tabela para formatar formulário -->
		<table>
			<!-- Mostra campo para digitar nome do usuário -->
			<!-- Se for a opção excluir, o campo será somente de leitura -->
			<tr>
				<td>Nome:</td>
				<td><input type="text" id="idNome" name="nNome" <?php if($excluir){ ?> readonly <?php } ?>  value="<?php echo (isset($usuario) ? $usuario->nome : ""); ?>"/></td>
			</tr>
			<!-- Mostra campo para digitar e-mail do usuário -->
			<!-- Se for a opção excluir, o campo será somente de leitura -->
			<tr>
				<td>E-mail:</td>
				<td><input type="text" id="idEmail" name="nEmail" <?php if($excluir){ ?> readonly <?php } ?>  value="<?php echo (isset($usuario) ? $usuario->email : ""); ?>"/></td>
			</tr>
			<!-- Nas opções Editar e Cadastrar, a nova senha será pedida -->
			<?php if(!$excluir){ ?>
			<tr>
				<td>Senha:</td>
				<td><input type="password" id="idSenha" name="nSenha" /></td>
			</tr>
			<?php } ?>
			<!-- Botões radio para selecionar o tipo de permissão do suário -->
			<tr>
				<td>Permissão:</td>
				<?php if(!$excluir) { ?>
					<td><input type="radio" name="nPermissao" value="normal" checked />Normal&nbsp;&nbsp;
						<input type="radio" name="nPermissao" value="admin" />Admin</td>
				<?php }else{ ?>
					<td><?php if($usuario->admin == "1"){ ?>
								<input type="text" id="idPermissao" name="nPermissao" readonly value="<?php echo "Administrador"; ?>"/>
						<?php }elseif($usuario->admin == "0"){ ?>
								<input type="text" id="idPermissao" name="nPermissao" readonly value="<?php echo "Normal"; ?>"/>
						<?php } ?>
					</td>
				<?php } ?>
			</tr>
			<!-- Mostra botão de Submit no formulário -->
			<tr>
				<td colspan="2">
					<?php if( $novo ){ ?>
						<p><input type="submit" value="Cadastrar"/></p>
					<?php }elseif ( $editar ){ ?>
						<p><input type="submit" value="Salvar"/></p>
					<?php }elseif ( $excluir ){ ?>
						<p><input type="submit" value="Excluir"/></p>
					<?php } ?>
				</td>
			</tr>
		</table>
	</fieldset>
	</form>



</div>
</body>

</html>