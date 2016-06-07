<?php
class LoginDao{
	public $nomeTabela = "tbl_usuarios";
	public function listOne($login, $senha){
		$senhaUser		= md5($senha);
		$stringSQL 		= "SELECT ID, login, senha, ativo FROM {$this->nomeTabela}
							WHERE login = :login
							AND senha = :senha
							AND ativo = 'S'";
		$con 			= ConnectionLib::getConnection();
		try{
			$query 		= $con->prepare($stringSQL);
			$query->bindParam(":login", $login, PDO::PARAM_STR);
			$query->bindParam(":senha", $senhaUser, PDO::PARAM_STR);
			$query->execute();
			$resultado 	= $query->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}catch (PDOException $e){
			return "ERRO AO SELECIONAR USUÁRIO - {$e->getMessage()}";
		}
	}

	public function updateSession($sessionID, $userID){
		$stringSQL = "UPDATE {$this->nomeTabela} SET ID_session = :sessionID 
						WHERE ID = :userID";
		$con 			= ConnectionLib::getConnection();
		try{
			$query 		= $con->prepare($stringSQL);
			$query->bindParam(":sessionID", $sessionID);
			$query->bindParam(":userID", $userID, PDO::PARAM_INT);
			$query->execute();
			return "ATUALIZADO";
		}catch (PDOException $e){
			return "ERRO- {$e->getMessage()}";
		}
	}

	public function findSession($sessionID){
		$stringSQL 		= "SELECT ID, ID_session, login, senha, ativo FROM {$this->nomeTabela}
							WHERE ID_session = :sessionID
							AND ativo = 'S'";
		$con 			= ConnectionLib::getConnection();
		try{
			$query 		= $con->prepare($stringSQL);
			$query->bindParam(":sessionID", $sessionID);
			$query->execute();
			$resultado 	= $query->fetch(PDO::FETCH_ASSOC);
			if (!empty($resultado)){
				return true;
			}
			return false;
		}catch (PDOException $e){
			return "ERRO AO SELECIONAR USUÁRIO - {$e->getMessage()}";
		}
	}
}
?>