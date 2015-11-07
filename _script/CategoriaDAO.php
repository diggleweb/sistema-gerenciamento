<?php
/*------------------------------------------------------------------------------
 * _script/CategoriaDAO.php
 *
 *
 *
 *
 *
 *
 *
 *----------------------------------------------------------------------------*/

/* Inclui bibliotecas de classes */
include 'Categoria.php';
include_once "GerenciadorConexao.php";


class CategoriaDAO{

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

 		/*Função para inserir nova categoria na tabela categorias do banco de dados*/
 		public function inserir($categoria){

 			/* Primeiro cria a query SQL */
 			$insert_query =	"INSERT INTO categorias (idcategoria, nome, idpai) VALUES (DEFAULT, '".$categoria->nome."', ".$categoria->idpai.")";
			
			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $insert_query)
			or die("Erro ao inserir categoria: " . mysql_error() );

 		}

 		/* Função para atualizar os dados de uma categoria já cadastrada (nome e ID do pai) */
 		public function atualizar($categoria){
 			
 			/* Primeiro cria a query SQL */
 			$update_query =	"UPDATE categorias SET nome = '".$categoria->nome."', idpai = ".$categoria->idpai." WHERE idcategoria = ".$categoria->idcategoria;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar categoria: " . mysql_error() );
 							
 		}

		/* Função para atualizar somente o nome de uma categoria já cadastrada */
 		public function atualizarNome($categoria){
 			
 			/* Primeiro cria a query SQL */
 			$update_query =	"UPDATE categorias SET nome = '".$categoria->nome."' WHERE idcategoria = ".$categoria->idcategoria;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar nome da categoria: " . mysql_error() );
 							
 		}

 		/* Função para excluir uma categoria e suas subcategorias do banco de dados */
 		public function excluir($id){

 			/* Cria primeira query SQL para excluir categoria repassada como argumento*/
 			$delete_query = "DELETE FROM categorias WHERE idcategoria = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or die("Erro ao excluir categoria primaria: " . mysql_error() );

			/* Cria segunda query SQL para excluir subcategorias (se houver)
			 * Se não haver subcategorias, não surte efeito nenhum */
 			$delete_query = "DELETE FROM categorias WHERE idpai = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or die("Erro ao excluir subcategorias: " . mysql_error() );

 		}

 		/* Função que lista todas as categorias existentes na tabela */
 		public function listar(){

 			//Faz acesso ao banco de dados
 			$list_query = "SELECT * FROM categorias";
 			$result = mysqli_query($this->conexao, $list_query) or die("Erro ao listar categorias: " . mysql_error() );

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Categoria
 				$retorno = new Categoria();
 				//Preenche todos os campos do novo objeto
 				$retorno->idcategoria = $row["idcategoria"];
 				$retorno->categoria = $row["categoria"];
 				$retorno->idpai = $row["idpai"];
 				
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		//Função recursva que cria uma lista na tela em bootstrap com as categorias e subcategorias cadastradas no banco
 		public function listarCategorias($id, $nivel){
 			
 			//Se nenhum parâmetro foi passado inicialmente
 			if(!$id) $id = 0;
 			if(!$nivel) $nivel = 0;

 			//Faz acesso ao banco de dados
 			$query = "SELECT * FROM categorias WHERE idpai = ".$id;
 			$result = mysqli_query($this->conexao, $query) or die("Erro ao criar lista de categorias: " . mysql_error() );

 			//Laço iterativo e recursivo
 			$i = 0;
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){

 				//Se entrou em um novo nivel de subcategorias, incrementa nível (categorias primárias possuem nível 0)
				if( ($row["idpai"] != 0) && ($i == 0) ) 
 					$nivel++;


 				//Se for mostrar a primeira categoria do nível 0, começa a <ul>
 				if( ($i == 0) && ($row["idpai"] == 0) )
 					echo "<ul class='nav nav-pills nav-stacked'>\n";
 				//Se for mostrar a primeira subcateria de qualquer outro nível, começa a <ul> com collapse e id
 				elseif( ($i == 0) && ($row["idpai"] != 0) ){
 					$idList = "subCats_Pai-".$row["idpai"];
 					echo "<ul class='nav nav-pills nav-stacked collapse' id='$idList'>\n";
 				}


 				//Verifica se a categoria em questão possui subcategorias
 				$possui_sub_cats = self::possuiSubCat( $row["idcategoria"] );


 				//Se for uma categoria primária e possuir subcategorias
 				if( ($row["idpai"] == 0) && $possui_sub_cats ){
					$idSubList = "subCats_Pai-".$row["idcategoria"];
					echo "<li class='active'><a href='#' data-toggle='collapse' data-target='#$idSubList'> <strong>".$row["categoria"]."</strong> </a>\n"; 					
				}
				//Se for uma categoria primaria e não possui subcategorias
				elseif( ($row["idpai"] == 0) && !$possui_sub_cats ){
					echo "<li class='active'><a href='#'> <strong>".$row["categoria"]."</strong> </a></li>\n";	
				}
				//Se for uma subcategoria e possuir subcategorias
				elseif( ($row["idpai"] != 0) && $possui_sub_cats ){
					$idSubList = "subCats_Pai-".$row["idcategoria"];
					echo "<li><a href='#' data-toggle='collapse' data-target='#$idSubList'> ".$row["categoria"]." </a>\n"; 					
				}
				//Se for uma subcategoria e não possui subcategorias
				elseif( ($row["idpai"] != 0) && !$possui_sub_cats ){
					echo "<li><a href='#'> ".$row["categoria"]." </a></li>\n";	
				}

				//Se possuir subcategorias, faz um nova chamada recursiva para listar estas subcategorias
				if( $possui_sub_cats ){
 					self::listarCategorias( $row["idcategoria"], $nivel );
 					echo "</li>\n";
 				}
 				//incrementa contador
 				$i++;
 			}

 			//finaliza lista <ul>
 			if($i > 0)
 				echo "</ul>\n";

 		}

 		/* Função que diz se a categoria tem pelo menos uma subcategoria */
 		public function possuiSubCat($id){
 			
 			$query = "SELECT * FROM categorias WHERE idpai = ".$id;
 			$result = mysqli_query($this->conexao, $query) or die("Erro ao verificar se categoria possui subcategorias: " . mysql_error() );

 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
 				return true;
 			else
 				return false;
 			
 		}

 		/* Função que busca uma entrada na tabela Categorias e retorna o array preenchido com campos associados */
 		public function buscaPorId($id){

 			/* Primeiro cria a query SQL */
 			$id_query = "SELECT * FROM categorias WHERE idcategoria = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao buscar categorias por ID: " . mysql_error() );

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Categoria
 				$retorno = new Categoria();
 				//Preenche todos os campos do novo objeto
 				$retorno->idcategoria = $row["idcategoria"];
 				$retorno->nome = $row["nome"];
 				$retorno->idpai = $row["idpai"];
 			}
 			return $retorno;
 		}

 		/* Função que busca categorias de acordo com o ID da categoria pai */
 		public function buscaPorIdPai($idpai){

 			/* Primeiro cria a query SQL */
 			$idpai_query = "SELECT * FROM categorias WHERE idpai = ".$idpai." ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $idpai_query)
 			or die("Erro ao listar categorias por ID do pai: " . mysql_error() );

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Categoria
 				$retorno = new Categoria();
 				//Preenche todos os campos do novo objeto
 				$retorno->idcategoria = $row["idcategoria"];
 				$retorno->nome = $row["nome"];
 				$retorno->idpai = $row["idpai"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}
 			return $lista;
 		}

 		/* Função que verifica se há produtos cadastrados em determinada categoria ou subcategoria
 		 * Se o $idcategoria passado como argumento for de uma subcategoria, verifica somente ela
 		 * Se for de uma categoria primária, verifica também todas as suas subcategorias */
		public function verificaProdutosRelacionados($idcategoria){

			/* Primeiro verifica se a categoria selecionada é primária */
			/* Para tanto, pega somente o campo do idpai */
			$query = "SELECT idpai FROM categorias WHERE idcategoria = ".$idcategoria;
 			$result = mysqli_query($this->conexao, $query)
 			or die("Erro ao buscar idpai da categoria repassada: " . mysql_error() );			

 			/* Salva o idpai da categoria consultada */
 			$cat_idpai = mysqli_fetch_array($result, MYSQLI_ASSOC);

			/* Array para guardar os produtos que estão relacionados a alguma categoria ou subcategoria
			 * Será usado mais adiante nesta função e é ele que será retornado */
	 		$id_prod_rel = array();

 			/* Se a categoria repassada como argumento for primária (cat_idpai == 0) 
 			 * A primeira coisa a se fazer é buscar produtos cadastrados diretamente na categoria primária
 			 * Caso não encontre nenhum, passa a buscar em suas subcategorias */
 			if( $cat_idpai["idpai"] == 0 ) {

				/* Esta query busca produtos relacionados diretamente com a categoria primária */
 				$query = "SELECT idproduto FROM produto WHERE idcategoria = ".$idcategoria;
		 		$result = mysqli_query($this->conexao, $query)
		 		or die("Erro ao buscar produtos cadastrado diretamente na categoria primaria: " . mysql_error() );

		 		/* Varre o resultado por linhas e armazena no array os IDs dos produtos relacionados */
	 			while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
	 				$id_prod_rel[] = $row["idproduto"];

	 			/* Se não encontrou produtos diretamente na categoria primária
	 			 * Deve então procurar em suas subcategorias */
	 			if( $id_prod_rel == null ){
	 				/* Esta query busca o ID de todas as subcategorias existentes naquela categoria */
	 				$query = "SELECT idcategoria FROM categorias WHERE idpai = ".$idcategoria;
		 			$result = mysqli_query($this->conexao, $query)
		 			or die("Erro ao buscar ID das subcategorias: " . mysql_error() );

		 			/* Cria array para armazenar os IDs das subcategorias encontradas */
		 			$sub_cats_id = array();

		 			/* Varre o resultado por linhas e armazena no array os IDs das subcategorias */
		 			while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
		 				$sub_cats_id[] = $row["idcategoria"];


		 			/* Se o array não estiver vazio, então existem subcategorias cadastradas */
		 			if($sub_cats_id != null){
		 				/* Loop para fazer pesquisa por produtos cadastrados nas subcategorias encontradas */
		 				foreach ($sub_cats_id as $key => $id_subcat){
		 					/* Esta query pega todos produtos relacionados à subcategoria em análise */
		 					$query = "SELECT idproduto FROM produto WHERE idcategoria = ".$id_subcat;
				 			$result = mysqli_query($this->conexao, $query)
				 			or die("Erro ao buscar produtos relacionados as subcategorias: " . mysql_error() );
							
				 			/*Pega linha por linha do $result e salva no array de produtos */
				 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
				 				$id_prod_rel[] = $row["idproduto"];

		 				}
		 			}
		 		}
 			}
 			/* Se for somente uma subcategoria ($cat_idpai["idpai"] != 0), busca relação somente com ela mesma */ 
 			else{
 				/* Esta query busca produtos relacionados diretamente com uma subcategoria */
 				$query = "SELECT idproduto FROM produto WHERE idcategoria = ".$idcategoria;
		 		$result = mysqli_query($this->conexao, $query)
		 		or die("Erro ao buscar produtos cadastrado diretamente na subcategooria: " . mysql_error() );

		 		/* Varre o resultado por linhas e armazena no array os IDs dos produtos relacionados */
	 			while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
	 				$id_prod_rel[] = $row["idproduto"];

 			}

 			return $id_prod_rel;

 		}

 		/* Cria um objeto <select> do HTML com todas categorias e subcategorias, indentadas e numeradas
 		 * Recebe o ID da categoria que deseja-se deixar pré-selecionada */
 		public function selectOption($selected){

 			/* Abre tag HTML do select */
			echo "<select id='idSelect' name='nSelect'>";

			/* Cria primeira query para descobrir todas as categorias primarias (idpai = 0)*/
			$query1 = "SELECT idcategoria, nome FROM categorias WHERE idpai = 0 ORDER BY nome";
 			$cats_1 = mysqli_query($this->conexao, $query1)
 			or die("Erro ao listar categorias primarias: " . mysql_error() );

 			/* Cria uma opção na lista que ficará habilitada por default caso nenhum ID tenha sido passado 
 			 * Esta opção não poderá ser escolhida pelo categoria */
 			if( $selected == 0 || $select == null ){ ?> 
 				<option disabled selected>-- Selecione uma categoria --</option>
 			<?php }

 			/* Entra em um laço para imprimir as opções dentro do select
 			 * Também efetua uma nova query que buscará scateubgorias das categorias primárias
 			 * Exemplo: resistor -> filme metálico
 			 * Exemplo: capacitor -> poliéster */
 			$i = 1;
 			$j = 1;
 			while( $row1 = mysqli_fetch_array($cats_1, MYSQLI_ASSOC) ){ ?>
 				<!-- Mostra o nome da categoria primária com numeração e valor igual ao seu ID -->
				<option value="<?php echo $row1["idcategoria"]; ?>" <?php if($selected == $row1["idcategoria"]){ ?> selected <?php } ?> ><?php echo "$i - ".$row1["nome"]; ?></option>
				
				<?php 
				/* Agora busca por subcategorias que possuam o id da categoria como idpai */
				$query2 = "SELECT idcategoria, nome FROM categorias WHERE idpai = ".$row1["idcategoria"]." ORDER BY nome";
	 			$cats_2 = mysqli_query($this->conexao, $query2)
	 			or die("Erro ao listar subcategorias: " . mysql_error() );

	 			/* Varre o array de subcategorias encontradas e as coloca na lista identadas e numeradas */
	 			while( $row2 = mysqli_fetch_array($cats_2, MYSQLI_ASSOC) ){ 
	 				// Cria um espaçamento para concatenar depois
	 				$sub1 = str_repeat("&nbsp;", 5); ?>
					<option value="<?php echo $row2["idcategoria"]; ?>" <?php if($selected == $row2["idcategoria"]){ ?> selected <?php } ?> ><?php echo $sub1."$i.$j - ".$row2["nome"]; ?></option>

					<?php $j++;
		 		}
		 		$i++;
		 		$j = 1;
	 		}
	 		echo "</select>";
 		}

}

?>