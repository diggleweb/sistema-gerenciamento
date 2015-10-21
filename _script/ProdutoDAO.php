<?php
/*------------------------------------------------------------------------------
 * _script/ProdutoDAO.php
 *
 *
 *
 *
 *
 *
 *
 *----------------------------------------------------------------------------*/

/* Inclui bibliotecas de classes */
include 'Produto.php';
include_once "GerenciadorConexao.php";


class ProdutoDAO{

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

 		/*Função para inserir novo produto na tabela produto do banco de dados*/
 		public function inserir($produto){

 			/* Primeiro cria a query do MySQL */
 			$insert_query =	"INSERT INTO produto (idproduto, nome, quantidade, custo, preco, descricao, idcategoria) VALUES (DEFAULT,'".$produto->nome."',".$produto->quantidade.",".$produto->custo.",".$produto->preco.",'".$produto->descricao."',".$produto->idcategoria.")";
			
			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $insert_query)
			or die("Erro ao inserir produto: " . mysql_error() );

 		}

 		/* Função para atualizar os dados de um dos produtos já cadastrados */
 		public function atualizar($produto){
 			
 			/* Primeiro cria a query do MySQL */
 			$update_query =	"UPDATE produto SET nome = '".$produto->nome."', quantidade = ".$produto->quantidade.", custo = ".$produto->custo.", preco = ".$produto->preco.", descricao = '".$produto->admin."', idcategoria = ".$produto->idcategoria." WHERE idproduto = ".$produto->idproduto;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar produto: " . mysql_error() );
 							
 		}

 		/* Função para excluir uma entrada de produto do banco de dados */
 		public function excluir($id){

 			/* Primeiro cria a query do MySQL */
 			$delete_query = "DELETE FROM produto WHERE idproduto = " . $id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or die("Erro ao excluir produto: " . mysql_error() );

 		}

 		/* Função que lista todos os produtos e devolve em ordem alfabética */
 		public function listar(){

 			/* Primeiro cria a query do MySQL */
 			$list_query = "SELECT * FROM produto ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $list_query)
 			or die("Erro ao listar produtos: " . mysql_error() );

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Produto
 				$retorno = new Produto();
 				//Preenche todos os campos do novo objeto
 				$retorno->idproduto = $row["idproduto"];
 				$retorno->nome = $row["nome"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->custo = $row["custo"];
 				$retorno->preco = $row["preco"];
 				$retorno->descricao = $row["descricao"];
 				$retorno->idcategoria = $row["idcategoria"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */
 		public function buscaPorId($id){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM produto WHERE idproduto = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao listar produtos por ID: " . mysql_error() );

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				$retorno = new Produto();
 				//Preenche todos os campos do novo objeto
 				$retorno->idproduto = $row["idproduto"];
 				$retorno->nome = $row["nome"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->custo = $row["custo"];
 				$retorno->preco = $row["preco"];
 				$retorno->descricao = $row["descricao"];
 				$retorno->idcategoria = $row["idcategoria"];
 			}
 			
 			return $retorno;

 		}

 		/*  */
 		public function buscaPorNome($nome){

 			/* Primeiro cria a query do MySQL */
 			$nome_query = "SELECT * FROM produto WHERE nome LIKE = '%".$nome."%' ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $nome_query)
 			or die("Erro ao listar produtos por nome: " . mysql_error() );

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				$retorno = new Produto();
 				//Preenche todos os campos do novo objeto
 				$retorno->idproduto = $row["idproduto"];
 				$retorno->nome = $row["nome"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->custo = $row["custo"];
 				$retorno->preco = $row["preco"];
 				$retorno->descricao = $row["descricao"];
 				$retorno->idcategoria = $row["idcategoria"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/* Função que busca todos produtos cadastrados em determinada categoria */
		public function buscaPorCategoria($idcategoria){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM produto WHERE idcategoria = ".$idcategoria;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao buscar produtos por categoria cadastrada: " . mysql_error() );

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new Produto();
 				//Preenche todos os campos do novo objeto
 				$retorno->idproduto = $row["idproduto"];
 				$retorno->nome = $row["nome"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->custo = $row["custo"];
 				$retorno->preco = $row["preco"];
 				$retorno->descricao = $row["descricao"];
 				$retorno->idcategoria = $row["idcategoria"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;
 		}
}

}
?>