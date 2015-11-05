<!DOCTYPE html>
<html lan="pt-br">
<head>
	<title>Sistema de Gerenciamento | Login</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8"/>
	<meta name="generator" content="Jair Junior" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="_style/css/mystyle.css">
	<link rel="stylesheet" type="text/css" href="_style/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>


<body>

<div class="page-header text-center">
	<h1 class="center-block">Sistema de Gerenciamento</h1>
</div>

<div class="container" id="form-log-in">
	<!-- Cria formulário de login na tela -->
	<form action="_script/LoginProcessamento.php" method="post" role="form">

		<!-- Verifica a existência de erro no processo de Login -->
		<?php if(isset($_GET["ERRO"]) && $_GET["ERRO"] == "1"){ ?>
			<div class="alert alert-danger" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				Usuário e/ou senha inválidos!
			</div>
		<?php }else if(isset($_GET["ERRO"]) && $_GET["ERRO"] == "2"){ ?>
			<div class="alert alert-danger" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				Efetue o login!
			</div>
		<?php } ?>

		<!-- Campo para e-mail -->
		<div class="form-group">
			<label for="idEmail" class="control-label">E-mail:</label>
			<div class="input-group">
				<input type="text" class="form-control" id="idEmail" name="nEmail" placeholder="Seu e-mail" required />
				<span class="input-group-addon" id="basic-addon1">@</span>
			</div>
		</div>

		<!-- Campo para senha -->
		<div class="form-group">
			<label for="idSenha" class="control-label">Senha:</label>
			<div class="input-group">
				<input type="password" class="form-control" id="idSenha" name="nSenha" placeholder="Sua senha" required />
				<span class="input-group-addon" id="sizing-addon3">
					<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
				</span>
			</div>
		</div>

		<!-- Botão de login -->
		<div class="text-center">
			<button type="submit" class="btn btn-success" id="btn-log-in"> 
				Efetuar Login &nbsp;&nbsp;<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
			</button>
		</div>

	</form>
</div>



<script type="text/javascript" src="_style/js/bootstrap.min.js"></script>
</body>

</html>