<?php

	//Exclui usuário caso a variável idExcluir esteja setada
	if( isset($_POST["idExcluir"]) ){
		$usuarioDao = new UsuarioDAO();
		$usuarioDao->excluir( $_POST["idExcluir"] );

		//flag para sinalizar que usuario foi excluído
		$excluirSucesso = true;
	}


	//Edita usuário com valores 
	if( isset($_POST["nIdEditar"]) && isset($_POST["nNomeEditar"]) &&
		isset($_POST["nSobrenomeEditar"]) && isset($_POST["nEmailEditar"]) &&
		isset($_POST["nPermissaoEditar"]) ){

			$usuario = new Usuario();
			$usuario->idusuario = $_POST["nIdEditar"];
			$usuario->nome = $_POST["nNomeEditar"];
			$usuario->sobrenome = $_POST["nSobrenomeEditar"];
			$usuario->email = strtolower($_POST["nEmailEditar"]);
			$usuario->admin = $_POST["nPermissaoEditar"];

			$usuarioDao = new UsuarioDAO();
			$usuarioDao->atualizarSemSenha( $usuario );

			$inserirSucesso = true;
	}

?>


<!-- Cabeçalho da página -->
<div class="page-header text-center">
	<h1>Consulta de Usuários</h1>
</div>


<!-- div que engloba o filtro e a tabela de usuários -->
<div id="conteudo">

	<!-- Pequeno formulário para fazer pesquisa/filtragem de usuários cadastrados -->
	<!-- Retorna para esta mesma página o nome digitado pelo método $_GET -->
	<div class="contorno">
		<h4><span class="glyphicon glyphicon-filter"></span> Filtro</h4>
		<hr>
		<form action="console.php" method="get" role="form">

			<!-- Campo escondido informando a página -->
			<input type="hidden" name="page" value="UsuariosConsultar" />

			<div class="row">
				<!-- Label -->
				<div class="col-sm-1">
					<label for="idPesquisa">Nome:</label>
				</div>

				<!-- Campo para nome a ser buscado -->
				<div class="col-sm-7">
					<input type="text" class="form-control" id="idPesquisa" name="nPesquisa" placeholder="Nome ou sobrenome" />
				</div>

				<!-- Botão de Pesquisar -->
				<div class="col-sm-2">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block" />Pesquisar</button>
					</div>
				</div>

				<!-- Botão de Listar Todos -->
				<div class="col-sm-2">
					<div class="form-group">
						<button type="button" class="btn btn-default btn-block" onclick="javascript:window.location.href='console.php?page=UsuariosConsultar'; ">Listar Todos</button>
					</div>
				</div>
			</div>

		</form>
	</div>
	<!-- /contorno -->


	<!-- Imprime mensagem que usuário foi excluído com sucesso! -->
	<?php
		if( $excluirSucesso ) { ?>

			<div class="alert alert-success" role="alert">
			  	<p><span class="glyphicon glyphicon-exclamation-sign"></span> Usuário excluído com sucesso!</p>
			</div>

		<?php } 
	?>


	<!-- Tabela que lista usuários cadastrados no sistema -->
	<table class="table table-striped table-bordered">
		<thead>
		<tr>
			<th>Nome</th>
			<th>E-mail</th>
			<th>Permissão</th>
			<th>Ação</th>
		</tr>
		</thead>
		<!-- Busca usuários cadastrados no banco -->
		<!-- Se a pesquisa foi acionada, busca por nome, senão lista todos -->
		<tbody>
		<?php
			if(!$usuarioDao)
				$usuarioDao = new UsuarioDAO();

			if( isset($_GET["nPesquisa"]) )
				$lista = $usuarioDao->buscaPorNome($_GET["nPesquisa"]);
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
				<!-- Imprime links (opções) na última coluna para editar ou excluir usuário -->
				<td>
					<a title="Editar Usuário" href="#editarUsuarioModal" data-toggle="modal" class="modalEditarUsuario" data-id="<?php echo $usuario->idusuario; ?>" data-nome="<?php echo $usuario->nome; ?>" data-sobrenome="<?php echo $usuario->sobrenome; ?>" data-email="<?php echo $usuario->email; ?>" data-permissao="<?php echo $usuario->admin; ?>" ><span class="label label-success">Editar</span></a>
					&nbsp;&nbsp;
					<a title="Excluir Usuário" href="#excluirUsuarioModal" data-toggle="modal" class="modalExcluirUsuario" data-id="<?php echo $usuario->idusuario; ?>" data-nome="<?php echo $usuario->nome." ".$usuario->sobrenome; ?>"><span class="label label-danger">Excluir</span></a>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>


	<!-- ********************************************************************************************** -->
	<!-- ********************** Cria Modal para confirmar EXCLUIR usuário ***************************** -->
	<!-- ********************************************************************************************** -->
	<div class="modal fade" id="excluirUsuarioModal" role="dialog">
		<div class ="modal-dialog">
			<div class="modal-content">

				<!-- Cabeçalho do Modal -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
        			<h4 class="modal-title">Excluir</h4>
				</div>
				
				<!-- Corpo do Modal -->
				<div class="modal-body" id="modal-body-excluir-usr">
        			<p id="red-text"><span class="glyphicon glyphicon-alert"></span> Tem certeza de que deseja excluir o usuário <strong><span id="nomeSpan"></span></strong>?</p>
        			
        			<!-- Pequeno formulário que contém apenas o ID do usuário a ser excluído -->
        			<!-- O ID é colocado dentro deste campo através do jQuery -->
        			<form action="?page=UsuariosConsultar" method="post" id="formExcluirUsuario" role="form">
        				<input type="hidden" id="idInput" name="idExcluir" value="" />
        			</form>
      			</div>
      			
      			<!-- Roda-pé do Modal -->
      			<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        			<!-- Quando clica neste botão o formulário acima é submetido através do jQuery -->
        			<button type="button" class="btn btn-danger" id="buttonExcluirUsuario">Excluir</button>
      			</div>

			</div>
			<!-- /modal-content -->
		</div>
		<!-- /modal-dialog -->
	</div>
	<!-- /modal -->


	<!-- ********************************************************************************************** -->
	<!-- ********************** Cria Modal para EDITAR informações do Usuário ************************* -->
	<!-- ********************************************************************************************** -->
	<div class="modal fade" id="editarUsuarioModal" role="dialog">
		<div class ="modal-dialog modal-sm">
			<div class="modal-content">

				<!-- Cabeçalho do Modal -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
        			<h4 class="modal-title">Editar</h4>
				</div>
				
				<!-- Corpo do Modal -->
				<div class="modal-body" id="modal-body-editar-usr">
        			
        			<!-- Formulário que conterá os dados do usuário a serem editadoos -->
        			<form action="?page=UsuariosConsultar" method="post" id="formEditarUsuario" role="form">

        				<!-- ID - campo escondido -->
	        			<input type="hidden" id="idInput" name="nIdEditar" value="" />

	        			<!-- Nome -->
	        			<div class="form-group">
	        				<label for="" class="control-label">Nome:</label>
	        				<input type="text" class="form-control" id="nomeInput" name="nNomeEditar" value="" autofocus />
	        			</div>

	        			<!-- Sobrenome -->
	        			<div class="form-group">
	        				<label for="" class="control-label">Sobrenome:</label>
	        				<input type="text" class="form-control" id="sobrenomeInput" name="nSobrenomeEditar" value="" />
	        			</div>

	        			<!-- E-mail -->
	        			<div class="form-group">
	        				<label for="" class="control-label">E-mail:</label>
	        				<input type="email" class="form-control" id="emailInput" name="nEmailEditar" value="" />
	        			</div>

	        			<!-- Permissão -->
	        			<div class="form-group">
							<label class="control-label">Permissão:</label><br/>

							<div class="row">
								<div class="col-sm-6">
									<label for="normalRadio" class="radio-inline">
										<input type="radio" id="normalRadio" name="nPermissaoEditar" value="0" />
										Normal
									</label>
								</div>

								<div class="col-sm-6">
									<label for="adminRadio" class="radio-inline">
										<input type="radio" id="adminRadio" name="nPermissaoEditar" value="1" />
										Administrador
									</label>
								</div>
							</div>
						</div>

        			</form>
      			</div>
      			
      			<!-- Roda-pé do Modal -->
      			<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        			<!-- Quando clica neste botão o formulário acima é submetido através do jQuery -->
        			<button type="button" class="btn btn-success" id="buttonEditarUsuario">Salvar</button>
      			</div>

			</div>
			<!-- /modal-content -->
		</div>
		<!-- /modal-dialog -->
	</div>
	<!-- /modal -->



</div>
<!-- /conteudo -->