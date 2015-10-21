<?php

require_once ('CategoriaDAO.php');


/* Se a opção for de Editar, reencaminha para a página de edição
 * repassando a opção selecionada no formulário da página anterior (ID da categoria) */
if( isset($_GET["nEditar"]) && isset($_GET["nSelect"]) ){
	$id = $_GET["nSelect"];
	header("Location: ../categoria_editar.php?id=".$id);
}
/* Se for para Excluir, volta para a página anterior categoria_listagem.php,
 * pois o processamento é feito lá no script do começo da página */
elseif( isset($_GET["nExcluir"]) && isset($_GET["nSelect"]) ){
	$id = $_GET["nSelect"];
	header("Location: ../categoria_listagem.php?excluir=1&id=".$id);
}
/* Se nenhuma opção coincidir, volta para a página anterior sem modificar nada */
else
	header("Location: ../categoria_listagem.php");

?>