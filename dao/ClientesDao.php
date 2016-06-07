<?php
class ClientesDao implements IDaoLib{
	public $nomeTabela = "tbl_clientes";
	public function add(ClientesModel $cliente){
		$stringSQL = "INSERT INTO {$this->nomeTabela} (nome, email, endereco, bairro, cep, cidade, estado, telefone, celular) VALUES (:nome, :email, :endereco, :bairro, :cep, :cidade, :estado, :telefone, :celular)";
		$con = ConnectionLib::getConnection();

		$nome 		= $cliente->nome;
		$email 		= $cliente->email;
		$endereco 	= $cliente->endereco;
		$bairro 	= $cliente->bairro;
		$cep 		= $cliente->cep;
		$cidade 	= $cliente->cidade;
		$estado 	= $cliente->estado;
		$telefone 	= $cliente->telefone;
		$celular 	= $cliente->celular;

		try{
			$query = $con->prepare($stringSQL);
			$query->bindParam(":nome", $nome, PDO::PARAM_STR);
			$query->bindParam(":email", $email, PDO::PARAM_STR);
			$query->bindParam(":endereco", $endereco, PDO::PARAM_STR);
			$query->bindParam(":bairro", $bairro, PDO::PARAM_STR);
			$query->bindParam(":cep", $cep, PDO::PARAM_STR);
			$query->bindParam(":cidade", $cidade, PDO::PARAM_INT);
			$query->bindParam(":estado", $estado, PDO::PARAM_INT);
			$query->bindParam(":telefone", $telefone, PDO::PARAM_STR);
			$query->bindParam(":celular", $celular, PDO::PARAM_STR);
			$query->execute();
			return "CADASTRO REALIZADO COM SUCESSO!";
		}catch (PDOException $e){
			return "ERRO AO INSERIR - SQL {$stringSQL} - {$e->getMessage()}";
		}
	}

	public function update(ClientesModel $cliente){
		$id = $cliente->ID;
		$stringSQL = "UPDATE {$this->nomeTabela} SET nome = :nome, email = :email, endereco = :endereco, 
							bairro = :bairro, cep = :cep, cidade = :cidade, estado = :estado, 
							telefone = :telefone, celular = :celular
						WHERE ID = :id";
		$con = ConnectionLib::getConnection();

		$nome 		= $cliente->nome;
		$email 		= $cliente->email;
		$endereco 	= $cliente->endereco;
		$bairro 	= $cliente->bairro;
		$cep 		= $cliente->cep;
		$cidade 	= $cliente->cidade;
		$estado 	= $cliente->estado;
		$telefone 	= $cliente->telefone;
		$celular 	= $cliente->celular;

		try{
			$query = $con->prepare($stringSQL);
			$query->bindParam(":id", $id, PDO::PARAM_INT);
			$query->bindParam(":nome", $nome, PDO::PARAM_STR);
			$query->bindParam(":email", $email, PDO::PARAM_STR);
			$query->bindParam(":endereco", $endereco, PDO::PARAM_STR);
			$query->bindParam(":bairro", $bairro, PDO::PARAM_STR);
			$query->bindParam(":cep", $cep, PDO::PARAM_STR);
			$query->bindParam(":cidade", $cidade, PDO::PARAM_INT);
			$query->bindParam(":estado", $estado, PDO::PARAM_INT);
			$query->bindParam(":telefone", $telefone, PDO::PARAM_STR);
			$query->bindParam(":celular", $celular, PDO::PARAM_STR);
			$query->execute();
			return "CADASTRO Atualizado COM SUCESSO!";
		}catch (PDOException $e){
			return "ERRO AO ATUALIZAR - SQL {$stringSQL} - {$e->getMessage()}";
		}
	}

	public function delete($clienteID){
		// Cria sentença SQL com IN
		$arrIDs 	= explode(",", $clienteID);
		// preenche inQuery com ? até o total de IDs
		$inQuery 	= implode(',', array_fill(0, count($arrIDs), '?'));

		$stringSQL 	= "DELETE FROM {$this->nomeTabela} WHERE ID IN ( {$inQuery} )";
		$con 		= ConnectionLib::getConnection();
		try{
			$query 	= $con->prepare($stringSQL);
			$query->execute($arrIDs);
			return "CLIENTE Deletado COM SUCESSO!";
		}catch (PDOException $e){
			return "ERRO AO DELETAR - SQL {$stringSQL} - {$e->getMessage()}";
		}
	}

	public function listOne($clienteID){
		$stringSQL 		= "
							SELECT cli.ID, cli.nome, cli.email, cli.endereco, cli.bairro, cli.cep, 
									cid.ID as cidadeID, cid.nome as cidade, uf.ID as estadoID, uf.sigla as uf, cli.telefone, cli.celular
							FROM {$this->nomeTabela} cli, tbl_cidades cid, tbl_estados uf
							WHERE cid.ID = cli.cidade
							AND uf.ID = cli.estado
							AND cli.ID = :id";
		$con 			= ConnectionLib::getConnection();
		try{
			$query 		= $con->prepare($stringSQL);
			$query->bindParam(":id", $clienteID, PDO::PARAM_INT);
			$query->execute();
			$resultado 	= $query->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}catch (PDOException $e){
			return "ERRO AO SELECIONAR O CLIENTE {$clienteID} - {$e->getMessage()}";
		}
	}

	public function listAll($busca = null, $numPagina = 0, $qtdadeRegistros = 20){
		$stringSQL 		= "SELECT cli.ID, cli.nome, cli.email, cli.endereco, cli.bairro, cli.cep, 
									cid.nome as cidade, uf.sigla as uf, cli.telefone, cli.celular
							FROM {$this->nomeTabela} cli, tbl_cidades cid, tbl_estados uf
							WHERE cid.ID = cli.cidade
							AND uf.ID = cli.estado";
		if (!empty($busca))
			$stringSQL .= " AND nome like :busca";
		$stringSQL 	   .= " ORDER BY cli.nome ASC LIMIT {$numPagina}, {$qtdadeRegistros}";
		$con 			= ConnectionLib::getConnection();
		$busca 			= "'%{$busca}%'";
		try{
			$query 		= $con->prepare($stringSQL);
			$query->bindParam(":busca", $busca, PDO::PARAM_STR);
			$query->execute();
			$resultado 	= $query->fetchAll(PDO::FETCH_ASSOC);

			$arrClientes = array();
			foreach ($resultado as $cliente){
				array_push($arrClientes, $cliente);
			}
			return $arrClientes;
		}catch (PDOException $e){
			return "ERRO AO SELECIONAR - {$e->getMessage()}";
		}
	}

	public function listEstados(){
		$stringSQL 	= "SELECT ID, sigla FROM tbl_estados";
		$con 		= ConnectionLib::getConnection();
		try{
			$query 	= $con->prepare($stringSQL);
			$query->execute();
			$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
			$arrEstados = array();

			foreach($resultado as $estado){
				array_push($arrEstados, $estado);
			}
			return $arrEstados;
		}catch (PDOException $e){
			return "Erro ao retornar os estados - {$e->getMessage()}";	
		}
	}

	public function listCidades($estadoID){
		$stringSQL 	= "SELECT ID, nome FROM tbl_cidades WHERE ID_estado = :estadoID";
		$con 		= ConnectionLib::getConnection();
		try{
			$query = $con->prepare($stringSQL);
			$query->bindParam(":estadoID", $estadoID, PDO::PARAM_INT);
			$query->execute();
			$resultado = $query->fetchAll(PDO::FETCH_ASSOC);

			$arrCidades = array();
			foreach ($resultado as $cidades){
				array_push($arrCidades, $cidades);
			}
			return $arrCidades;
		}catch (PDOException $e){
			return "Erro ao retornar as cidades do estado {$estadoID} - {$e->getMessage()}";		
		}
	}
}

?>