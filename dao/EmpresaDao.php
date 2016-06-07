<?php
class EmpresaDao{
	public $nomeTabela = "tbl_servicos";
	public function add(EmpresaModel $empresa){
		$stringSQL = "INSERT INTO {$this->nomeTabela} (nome_servico) VALUES (:servico)";
		$con = ConnectionLib::getConnection();

		$nomeServico = $empresa->servico;

		try{
			$query = $con->prepare($stringSQL);
			$query->bindParam(":servico", $nomeServico, PDO::PARAM_STR);
			$query->execute();
			return "CADASTRO REALIZADO COM SUCESSO!";
		}catch (PDOException $e){
			return "ERRO AO INSERIR - SQL {$stringSQL} - {$e->getMessage()}";
		}
	}

	public function update(EmpresaModel $empresa){
		$id = $empresa->ID;
		$stringSQL = "UPDATE {$this->nomeTabela} SET nome_servico = :nomeServico WHERE ID = :id";
		$con = ConnectionLib::getConnection();

		$nomeServico = $empresa->servico;
		
		try{
			$query = $con->prepare($stringSQL);
			$query->bindParam(":id", $id, PDO::PARAM_INT);
			$query->bindParam(":nomeServico", $nomeServico, PDO::PARAM_STR);
			$query->execute();
			return "CADASTRO Atualizado COM SUCESSO!";
		}catch (PDOException $e){
			return "ERRO AO ATUALIZAR - SQL {$stringSQL} - {$e->getMessage()}";
		}
	}

	public function delete($servicoID){
		// Cria sentença SQL com IN
		$arrIDs 	= explode(",", $servicoID);
		// preenche inQuery com ? até o total de IDs
		$inQuery 	= implode(',', array_fill(0, count($arrIDs), '?'));

		$stringSQL 	= "DELETE FROM {$this->nomeTabela} WHERE ID IN ( {$inQuery} )";
		$con 		= ConnectionLib::getConnection();
		try{
			$query 	= $con->prepare($stringSQL);
			$query->execute($arrIDs);
			return "Serviço Deletado COM SUCESSO!";
		}catch (PDOException $e){
			return "ERRO AO DELETAR - SQL {$stringSQL} - {$e->getMessage()}";
		}
	}

	public function listOne($servicoID){
		$stringSQL 		= "
							SELECT ID, nome_servico FROM {$this->nomeTabela}
							WHERE ID = :id";
		$con 			= ConnectionLib::getConnection();
		try{
			$query 		= $con->prepare($stringSQL);
			$query->bindParam(":id", $servicoID, PDO::PARAM_INT);
			$query->execute();
			$resultado 	= $query->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}catch (PDOException $e){
			return "ERRO AO SELECIONAR {$servicoID} - {$e->getMessage()}";
		}
	}

	public function listAll($busca = null, $numPagina = 0, $qtdadeRegistros = 20){
		$stringSQL 		= "SELECT ID, nome_servico FROM {$this->nomeTabela}";
		if (!empty($busca))
			$stringSQL .= " WHERE nome_servico like :busca";
		$stringSQL 	   .= " ORDER BY nome_servico ASC LIMIT {$numPagina}, {$qtdadeRegistros}";
		$con 			= ConnectionLib::getConnection();
		$busca 			= "'%{$busca}%'";
		try{
			$query 		= $con->prepare($stringSQL);
			$query->bindParam(":busca", $busca, PDO::PARAM_STR);
			$query->execute();
			$resultado 	= $query->fetchAll(PDO::FETCH_ASSOC);

			$arr = array();
			foreach ($resultado as $servico){
				array_push($arr, $servico);
			}
			return $arr;
		}catch (PDOException $e){
			return "ERRO AO SELECIONAR - {$e->getMessage()}";
		}
	}
}
?>