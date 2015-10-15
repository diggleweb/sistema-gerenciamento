<?php
/*------------------------------------------------------------------------------
 * _script/GerenciadorConexao.php
 *
 *
 *
 *
 *
 *
 *
 *----------------------------------------------------------------------------*/

class GerenciadorConexao{
	
	/* Define um método público e estático para se conectar ao banco de dados */
	/* Público porque ele pode ser chamado de fora desta classe*/
	/* Estático porque ele pode ser acessado sem instanciar a classe */
	public static function conectar(){

		/* Abre uma conexão com o servidor MySQL e retorna um identificador */
		$conexao = mysql_connect("localhost", "root", "Junior89")
		or die('Nao foi possível estabelecer a conexão: ' . mysql_error() );
		
		/* Seleciona qual banco de dados será utilizado na conexão */
		mysql_select_db("SistemaGerenciamentoLoja", $conexao)
		or die('Banco de dados não encontrado: ' . mysql_error() );	
		
		/* Retorna o identificador da conexão que será utilizado mais tarde */
		/* Para fechar a conexão */
		return $conexao;

	}

}


?>