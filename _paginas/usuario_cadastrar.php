<?php

	if( isset($_GET["action"]) && ($_GET["action"] == "Cadastrar") ){
		$usuario = new Usuario();
		$usuario->nome = $_POST["nNome"];
		$usuario->sobrenome = $_POST["nSobrenome"];
		$usuario->email = strtolower($_POST["nEmail"]);
		$usuario->senha = $_POST["nSenha"];

		if( $_POST["nPermissao"] == "normal" )
			$usuario->admin = "0";
		elseif( $_POST["nPermissao"] == "admin" )
			$usuario->admin = "1";

		$usuarioDao = new UsuarioDAO();
		$usuarioDao->inserir($usuario);

		$inserirSucesso = true;
	}


?>


<div class="page-header text-center">
	<h1>Cadastrar Usuários</h1>
</div>

<div id="form">

	<?php
		if( $inserirSucesso ) { ?>

			<div class="alert alert-success" role="alert">
			  	<p><span class="glyphicon glyphicon-exclamation-sign"></span> Usuário cadastrado com sucesso!</p>
			</div>

		<?php } 
	?>


	<!-- Aqui começa o formulário de cadastro -->
	<form action="?page=UsuariosCadastrar&action=Cadastrar" method="post" role="form">

		<div class="form-group">
			<label for="idNome" class="control-label">Nome:</label>
			<input type="text" class="form-control" id="idNome" name="nNome" required />
		</div>

		<div class="form-group">
			<label for="idSobrenome" class="control-label">Sobrenome:</label>
			<input type="text" class="form-control" id="idSobrenome" name="nSobrenome" required />
		</div>

		<div class="form-group">
			<label for="idEmail" class="control-label">E-mail:</label>
			<input type="text" class="form-control" id="idEmail" name="nEmail" required />
		</div>

		<div class="form-group">
			<label for="idSenha" class="control-label">Senha Provisória:</label>
			<input type="password" class="form-control" id="idSenha" name="nSenha" required />
		</div>

		<div class="form-group">
			<label class="control-label">Permissão:</label><br/>

			<div class="row">
				<div class="col-sm-6">
					<label for="idNormal" class="radio-inline">
						<input type="radio" id="idNormal" name="nPermissao" value="normal" checked />
						Normal
					</label>
				</div>

				<div class="col-sm-6">
					<label for="idAdmin" class="radio-inline">
						<input type="radio" id="idAdmin" name="nPermissao" value="admin" />
						Administrador
					</label>
				</div>
			</div>
		</div>
		<br/>

		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
					<button type="submit" class="btn btn-success btn-block"/>Salvar</button>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					<button type="reset" class="btn btn-default btn-block"/>Limpar</button>
				</div>
			</div>
		</div>

	</form>

</div>