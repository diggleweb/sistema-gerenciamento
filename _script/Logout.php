<?php
/*------------------------------------------------------------------------------
 * _script/Logout.php
 *
 *
 *
 *
 *
 *
 *
 *----------------------------------------------------------------------------*/

/* Declara sessão do navegador */
session_start("login");

/* Limpa todas variáveis de sessão */
session_unset();

/* Destrói sessão */
session_destroy();

/* Redireciona usuário para página inicial de login*/
header('Location: ../index.php');

?>