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
		$conexao = mysqli_connect("127.0.0.1", "root", "Junior89","SistemaGerenciamento") or print(mysql_error());
		//or die('Não foi possível estabelecer a conexão: ' . mysql_error() );
		
		/* Verifica se a conexão com o banco foi bem sucedida */
		if( mysqli_connect_errno() )
  			echo "Falha ao conectar no banco de dados MySQL: " . mysqli_connect_error();
		
		/* Retorna o identificador da conexão que será utilizado mais tarde */
		/* Para fechar a conexão */
		return $conexao;

	}

}


?>