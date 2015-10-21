<?php
/*------------------------------------------------------------------------------
 * _script/UsuarioDAO.php
 *
 *
 *
 *
 *
 *
 *
 *----------------------------------------------------------------------------*/

/* Inclui bibliotecas de classes */
include 'Usuario.php';
include_once "GerenciadorConexao.php";


class UsuarioDAO{

	/* Variável privada que armazena o identificador da conexão com o banco */
	private $conexao = null;

		/* Construtor da classe: estabelece conexão com o banco */
		/* Utiliza o método estático da classe GerenciadorConexao */
		public function __construct(){
			/* Recebe o identificador da conexão e armazena */
			$this->conexao = GerenciadorConexao::conectar();
		}

		/* Destrutor da classe: finaliza conexão com o banco */
		public function __destruct(){
			/* Verifica se a conexão havia sido estabelecida anteriormente */
			if($this->conexao)
				mysqli_close($this->conexao);
		}

/* -----------------------------------------------------------------------------
 * Aqui começa a implementação do CRUD
 *
 * C = Create 		-> 		Insere novas linhas na tabela
 * R = Retrieve 	-> 		Busca entradas na tabela
 * U = Update 		-> 		Atualiza linhas da tabela
 * D = delete 		->		Deleta linhas da tabela
 -----------------------------------------------------------------------------*/

 		/*Função para inserir novo usuário na tabela usuario do banco de dados*/
 		public function inserir($usuario){

 			/* Primeiro cria a query do MySQL */
 			$insert_query =	"INSERT INTO usuario (idusuario, nome, sobrenome, email, senha, admin) VALUES (DEFAULT,'".$usuario->nome."','".$usuario->sobrenome."','".$usuario->email."','".md5($usuario->senha)."',".$usuario->admin.")";
			
			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $insert_query)
			or die("Erro ao inserir usuário: " . mysql_error() );

 		}

 		/* Função para atualizar os dados de um dos usuários já cadastrados */
 		public function atualizar($usuario){
 			
 			/* Primeiro cria a query do MySQL */
 			$update_query =	"UPDATE usuario SET nome='".$usuario->nome."', sobrenome='".$usuario->sobrenome."', email='".$usuario->email."', senha = '".md5($usuario->senha)."', admin= ".$usuario->admin." WHERE idusuario=".$usuario->idusuario;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar usuário: " . mysql_error() );
 							
 		}

		/* Função para atualizar os dados de um dos usuários semm modificar a senha */
 		public function atualizarSemSenha($usuario){

 			/* Primeiro cria a query do MySQL */
 			$update_query =	"UPDATE usuario SET nome='".$usuario->nome."', sobrenome='".$usuario->sobrenome."', email='".$usuario->email."', admin= ".$usuario->admin." WHERE idusuario=".$usuario->idusuario;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar usuário: " . mysql_error() );

 		}

 		/* Função para excluir uma entrada de usuário do banco de dados */
 		public function excluir($id){

 			/* Primeiro cria a query do MySQL */
 			$delete_query = "DELETE FROM usuario WHERE idusuario = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or die("Erro ao excluir usuário: " . mysql_error() );

 		}

 		/* Função que lista todos os usuários e devolve em ordem alfabética */
 		public function listar(){

 			/* Primeiro cria a query do MySQL */
 			$list_query = "SELECT * FROM usuario ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $list_query)
 			or die("Erro ao listar usuários: " . mysql_error() );

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new Usuario();
 				//Preenche todos os campos do novo objeto
 				$retorno->idusuario = $row["idusuario"];
 				$retorno->nome = $row["nome"];
 				$retorno->sobrenome = $row["sobrenome"];
 				$retorno->email = $row["email"];
 				$retorno->senha = $row["senha"];
 				$retorno->admin = $row["admin"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */
 		public function buscaPorId($id){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM usuario WHERE idusuario = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao listar usuários por ID: " . mysql_error() );

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new Usuario();
 				//Preenche todos os campos do novo objeto
 				$retorno->idusuario = $row["idusuario"];
 				$retorno->nome = $row["nome"];
 				$retorno->sobrenome = $row["sobrenome"];
 				$retorno->email = $row["email"];
 				$retorno->senha = $row["senha"];
 				$retorno->admin = $row["admin"];
 			}
 			
 			return $retorno;

 		}

 		/*  */
 		public function buscaPorNome($nome){

 			/* Primeiro cria a query do MySQL */
 			$nome_query = "SELECT * FROM usuario WHERE nome LIKE '%".$nome."%' ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $nome_query)
 			or die("Erro ao listar usuários por nome: " . mysql_error() );

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new Usuario();
 				//Preenche todos os campos do novo objeto
 				$retorno->idusuario = $row["idusuario"];
 				$retorno->nome = $row["nome"];
 				$retorno->sobrenome = $row["sobrenome"];
 				$retorno->email = $row["email"];
 				$retorno->senha = $row["senha"];
 				$retorno->admin = $row["admin"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */
 		public function buscaPorSobrenome($sobrenome){

 			/* Primeiro cria a query do MySQL */
 			$nome_query = "SELECT * FROM usuario WHERE sobrenome LIKE = '%".$sobrenome."%' ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $nome_query)
 			or die("Erro ao listar usuários por sobrenome: " . mysql_error() );

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new Usuario();
 				//Preenche todos os campos do novo objeto
 				$retorno->idusuario = $row["idusuario"];
 				$retorno->nome = $row["nome"];
 				$retorno->sobrenome = $row["sobrenome"];
 				$retorno->email = $row["email"];
 				$retorno->senha = $row["senha"];
 				$retorno->admin = $row["admin"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */
 		public function buscaPorEmail($email){

 			/* Primeiro cria a query do MySQL */
 			$email_query = "SELECT * FROM usuario WHERE email = '".$email."'";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $email_query)
 			or die("Erro ao listar usuários por e-mail: " . mysql_error() );

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new Usuario();
 				//Preenche todos os campos do novo objeto
 				$retorno->idusuario = $row["idusuario"];
 				$retorno->nome = $row["nome"];
 				$retorno->sobrenome = $row["sobrenome"];
 				$retorno->email = $row["email"];
 				$retorno->senha = $row["senha"];
 				$retorno->admin = $row["admin"];
 			}
 			
 			return $retorno;

 		}

}
?>