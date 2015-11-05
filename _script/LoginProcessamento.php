<?php
/*------------------------------------------------------------------------------
 * _script/LoginProcessamento.php
 *
 *
 *
 *
 *
 *
 *
 *----------------------------------------------------------------------------*/

/* Inicia nova sessão de navegação onde é possível setar variáveis de seção */
session_start("login");
/* Configura diretivas de processamento p/ mostrar e reportar erros do código*/
ini_set('error_reporting', E_ALL|E_STRICT);
ini_set('display_errors', 1);


/* Inclui classe UsuarioDAO */
require_once("UsuarioDAO.php");


/* Pega variáveis que vieram de index.php no método POST */
$email = strtolower($_POST["nEmail"]);
$senha = $_POST["nSenha"];


/* Cria novo objeto da classe UsuarioDAO */
$usuarioDao = new UsuarioDAO();

/* Manda buscar os dados do usuário com e-mail igual ao recebido de index.php*/
/* Se não encontrar nada no banco de dados, retorna null */
$usuario = $usuarioDao->buscaPorEmail($email);



/* Testa se encontrou algum usuário cadastrado com aquele e-mail */
if($usuario != null){
	/* Criptografa a senha recebida de index.php pra poder comparar */
	$senhaCriptografada = md5($senha);

	/* Agora testa se a senha recebida é igual à que consta do banco de dados*/
	if($senhaCriptografada == $usuario->senha){
		/* Seta variáveis de sessão com informações do usuario logado*/
		$_SESSION['id_usuario_logado'] = $usuario->idusuario;
		$_SESSION['nome_usuario_logado'] = $usuario->nome;
		$_SESSION['sobrenome_usuario_logado'] = $usuario->sobrenome;
		$_SESSION['email_usuario_logado'] = $usuario->email;
		$_SESSION['permissao_usuario_logado'] = $usuario->admin;

		//print_r($usuario);
		header('Location: ../console.php');
	}
	/* Caso a senha esteja incorreta gera ERRO 1*/
	else
		header('Location: ../index.php?ERRO=1');

}
/* Caso não tenha encontrado nenhum e-mail válido no banco de dados gera ERRO 1 */
else
	header('Location: ../index.php?ERRO=1')


?>