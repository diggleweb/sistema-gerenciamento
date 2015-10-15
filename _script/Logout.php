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

/* Declara seção do navegador */
session_start();

/* Limpa todas variáveis de seção */
session_unset();

/* Destrói seção */
session_destroy();

/* Redireciona usuário para página inicial de login*/
header('Location: ../index.php');

?>