<?php
//ini_set('error_reporting', E_ALL|E_STRICT);
//ini_set('display_errors', 1);

require_once ('UsuarioDAO.php');


$usuarioDao = new UsuarioDAO();

$acao = $_POST["nAcao"];
echo $acao;

if( $acao == "editar" || $acao == "cadastrar" ) {
	$usuario = new Usuario();
	$usuario->idusuario = $_POST["nIdUsuario"];
	$usuario->nome = $_POST["nNome"];
	$usuario->sobrenome = $_POST["nSobrenome"];
	$usuario->email = $_POST["nEmail"];
	$usuario->senha = $_POST["nSenha"];
	
	if( $_POST["nPermissao"] == "normal" )
		$usuario->admin = "0";
	elseif( $_POST["nPermissao"] == "admin" )
		$usuario->admin = "1";

	if($acao == "editar")
		$usuarioDao->atualizar($usuario);
	else
		$usuarioDao->inserir($usuario);
}

elseif($acao == "excluir"){
	$usuarioDao->excluir( $_POST["nIdUsuario"] );
}



header("Location: ../usuario_listagem.php")


?>