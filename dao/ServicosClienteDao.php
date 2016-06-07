<?php
class ServicosClienteDao{
	public $nomeTabela = 'tbl_clientes_servicos';
	public function add(ServicosClienteModel $registro){
		$stringSQL = "INSERT INTO {$this->nomeTabela} (ID_cliente, ID_servico, data_inicio, data_fim) VALUES (:clienteID, :servicoID, :dataInicio, :dataFim)";
		$con = ConnectionLib::getConnection();

		$clienteID 	= $registro->clienteID;
		$servicoID 	= $registro->servicoID;
		$dataInicio = $registro->dataInicio;
		$dataFim 	= $registro->dataFim;

		try{
			$query = $con->prepare($stringSQL);
			$query->bindParam(":clienteID", $clienteID, PDO::PARAM_INT);
			$query->bindParam(":servicoID", $servicoID, PDO::PARAM_INT);
			$query->bindParam(":dataInicio", $dataInicio, PDO::PARAM_STR);
			$query->bindParam(":dataFim", $dataFim, PDO::PARAM_STR);
			$query->execute();
			return "CADASTRO REALIZADO COM SUCESSO!";
		}catch (PDOException $e){
			return "ERRO AO INSERIR - SQL {$stringSQL} - {$e->getMessage()}";
		}
	}

	public function update(ServicosClienteModel $registro){
		$id = $registro->ID;
		$stringSQL = "UPDATE {$this->nomeTabela} SET clienteID = :clienteID, servicoID = :servicoID, data_inicio = :dataInicio, data_fim = :dataFim WHERE ID = :id";
		$con = ConnectionLib::getConnection();

		$clienteID 	= $registro->clienteID;
		$servicoID 	= $registro->servicoID;
		$dataInicio = $registro->dataInicio;
		$dataFim 	= $registro->dataFim;
		
		try{
			$query = $con->prepare($stringSQL);
			$query->bindParam(":id", $id, PDO::PARAM_INT);
			$query->bindParam(":clienteID", $clienteID, PDO::PARAM_INT);
			$query->bindParam(":servicoID", $servicoID, PDO::PARAM_INT);
			$query->bindParam(":dataInicio", $dataInicio, PDO::PARAM_STR);
			$query->bindParam(":dataFim", $dataFim, PDO::PARAM_STR);
			$query->execute();
			return "CADASTRO Atualizado COM SUCESSO!";
		}catch (PDOException $e){
			return "ERRO AO ATUALIZAR - SQL {$stringSQL} - {$e->getMessage()}";
		}
	}

	public function delete($registroID){
		// Cria sentença SQL com IN
		$arrIDs 	= explode(",", $registroID);
		// preenche inQuery com ? até o total de IDs
		$inQuery 	= implode(',', array_fill(0, count($arrIDs), '?'));

		$stringSQL 	= "DELETE FROM {$this->nomeTabela} WHERE ID IN ( {$inQuery} )";
		$con 		= ConnectionLib::getConnection();
		try{
			$query 	= $con->prepare($stringSQL);
			$query->execute($arrIDs);
			return "Registro Deletado COM SUCESSO!";
		}catch (PDOException $e){
			return "ERRO AO DELETAR - SQL {$stringSQL} - {$e->getMessage()}";
		}
	}

	public function listOne($registroID){
		$stringSQL 		= "SELECT reg.ID, reg.ID_cliente, cli.nome as nomeCliente, 
							reg.ID_servico, s.nome_servico as nomeServico, 
							reg.data_inicio, reg.data_fim
							FROM {$this->nomeTabela} reg, tbl_clientes cli, tbl_servicos s
							WHERE reg.ID = :id";
		$con 			= ConnectionLib::getConnection();
		try{
			$query 		= $con->prepare($stringSQL);
			$query->bindParam(":id", $registroID, PDO::PARAM_INT);
			$query->execute();
			$resultado 	= $query->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}catch (PDOException $e){
			return "ERRO AO SELECIONAR {$servicoID} - {$e->getMessage()}";
		}
	}

	public function listAll($busca = null, $numPagina = 0, $qtdadeRegistros = 20){
		$stringSQL 		= "SELECT reg.ID, reg.ID_cliente, cli.nome as nomeCliente, 
							reg.ID_servico, s.nome_servico as nomeServico, 
							reg.data_inicio, reg.data_fim
							FROM {$this->nomeTabela} reg, tbl_clientes cli, tbl_servicos s";
		if (!empty($busca))
			$stringSQL .= " WHERE cli.nome like :busca";
		$stringSQL 	   .= " ORDER BY cli.nome ASC LIMIT {$numPagina}, {$qtdadeRegistros}";
		$con 			= ConnectionLib::getConnection();
		$busca 			= "'%{$busca}%'";
		try{
			$query 		= $con->prepare($stringSQL);
			$query->bindParam(":busca", $busca, PDO::PARAM_STR);
			$query->execute();
			$resultado 	= $query->fetchAll(PDO::FETCH_ASSOC);

			$arr = array();
			foreach ($resultado as $result){
				array_push($arr, $result);
			}
			return $arr;
		}catch (PDOException $e){
			return "ERRO AO SELECIONAR - {$e->getMessage()}";
		}
	}

	public function listServicos($clienteID){
		$stringSQL 		= "SELECT reg.ID, reg.ID_cliente, cli.nome as nomeCliente, 
							reg.ID_servico, s.nome_servico as nomeServico, 
							reg.data_inicio, reg.data_fim
							FROM {$this->nomeTabela} reg, tbl_clientes cli, tbl_servicos s
							WHERE reg.ID_cliente = :id
							AND reg.ID_cliente = cli.ID
							AND reg.ID_servico = s.ID";
		$con 			= ConnectionLib::getConnection();
		try{
			$query 		= $con->prepare($stringSQL);
			$query->bindParam(":id", $clienteID, PDO::PARAM_INT);
			$query->execute();
			$resultado 	= $query->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}catch (PDOException $e){
			return "ERRO AO SELECIONAR {$servicoID} - {$e->getMessage()}";
		}	
	}
}
?>