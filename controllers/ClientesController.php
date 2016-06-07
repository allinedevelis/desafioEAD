<?php
class ClientesController{
	private $dao;
	private $daoLogin;
	private $view;
	private $model;

	public function __set($attribute, $value){
		$this->{$attribute} = $value;
	}

	public function __get($attribute){
		return $this->{$attribute};
	}

	public function indexAction(){
		header("Location: ?controller=clientes&action=listar");
	}

	/* Telas Sistema */
	public function listarAction(){
		$this->dao 		= new ClientesDao();
		$result 		= $this->dao->listAll();
		$result			= FilterValidatorLib::filterRequest($result);

		if (!empty($_COOKIE['sessionUserID'])){
			$this->daoLogin = new LoginDao();
			$flag 			= $this->daoLogin->findSession($_COOKIE['sessionUserID']);
		}

		// se nao existir sessão - tela login
		if (empty($flag)){
			$this->view = new ViewLib('formularioLogin');
			$this->view->addDados("title", "Página Principal");
			$this->view->addDados('tela', 'telaLogin');
			$this->view->render();
		}else{
			$this->view		= new ViewLib("areaClientes");
			$this->view->addDados("title", "Área de Clientes - Lista");
			$this->view->addDados("clientes", $result);
			$this->view->render();
		}	
	}

	public function cadastroAction(){
		$this->dao 		= new ClientesDao();
		$estados 		= $this->dao->listEstados();

		if (!empty($_COOKIE['sessionUserID'])){
			$this->daoLogin = new LoginDao();
			$flag 			= $this->daoLogin->findSession($_COOKIE['sessionUserID']);
		}

		// se nao existir sessão - tela login
		if (empty($flag)){
			$this->view = new ViewLib('formularioLogin');
			$this->view->addDados("title", "Página Principal");
			$this->view->addDados('tela', 'telaLogin');
			$this->view->render();
		}else{
			$this->view		= new ViewLib("formularioClientes");
			$this->view->addDados("title", "Área de Clientes - Adicionar Cliente");
			$this->view->addDados("action", "add");
			$this->view->addDados("estados", $estados);
			$this->view->render();	
		}		
	}

	public function edicaoAction(){
		if (!empty($_REQUEST['params'])){
			$this->model 			= new ClientesModel();
			$this->model->ID 		= $_REQUEST['params'];

			$this->dao 				= new ClientesDao();
			$infoCliente 			= $this->dao->listOne($this->model->ID);
			$infoCliente 			= FilterValidatorLib::filterRequest($infoCliente);
			$estados 				= $this->dao->listEstados();
			$cidades 				= $this->dao->listCidades($infoCliente['estadoID']);
			$cidades 				= FilterValidatorLib::filterRequest($cidades);
	
			if (!empty($_COOKIE['sessionUserID'])){
				$this->daoLogin = new LoginDao();
				$flag 			= $this->daoLogin->findSession($_COOKIE['sessionUserID']);
			}

			// se nao existir sessão - tela login
			if (empty($flag)){
				$this->view = new ViewLib('formularioLogin');
				$this->view->addDados("title", "Página Principal");
				$this->view->addDados('tela', 'telaLogin');
				$this->view->render();
			}else{
				$this->view 			= new ViewLib("formularioClientes");
				$this->view->addDados("title", "Área de Clientes - Editar Cliente");
				$this->view->addDados("action", "edit");
				$this->view->addDados("estados", $estados);
				$this->view->addDados("cidades", $cidades);
				$this->view->addDados('clientes', $infoCliente);
				$this->view->render();
			}			
		}
	}
	/* Telas Sistema FIM */

	public function listarCidadesAction(){
		if (!empty($_POST['estadoID'])){
			$this->dao 	= new ClientesDao();
			$cidades 	= $this->dao->listCidades($_POST['estadoID']);
			$html 		= '';
			foreach ($cidades as $value) {
				$flagSelected = ($_POST['cidadeID'] == $value['ID']) ? "selected='selected'" : '';
				$html 	.= "<option value={$value['ID']} {$flagSelected}>{$value['nome']}</option>";
			}
			echo $html;
		}
	}

	/* Functions Eventos Sistema */
	public function addAction(){
		if (!empty($_POST)){
			$this->model 			= new ClientesModel();
			$this->model->nome 		= $_POST['nome'];
			$this->model->email 	= $_POST['email'];
			$this->model->endereco 	= $_POST['endereco'];
			$this->model->bairro 	= $_POST['bairro'];
			$this->model->cep 		= $_POST['cep'];
			$this->model->cidade 	= $_POST['cidade'];
			$this->model->estado 	= $_POST['estado'];
			$this->model->telefone 	= $_POST['telefone'];
			$this->model->celular 	= $_POST['celular'];
			$this->dao 				= new ClientesDao();

			$result 				= $this->dao->add($this->model); 
			echo "<script>alert('{$result}')</script>";
			echo Application::redirect("?controller=clientes");
		}
	}

	public function editAction(){
		if (!empty($_POST)){
			$this->model 			= new ClientesModel();
			$_POST 					= FilterValidatorLib::filterRequest($_POST);
			$this->model->ID 		= $_POST['clienteID'];

			$this->model->nome 		= $_POST['nome'];
			$this->model->email 	= $_POST['email'];
			$this->model->endereco 	= $_POST['endereco'];
			$this->model->bairro 	= $_POST['bairro'];
			$this->model->cep 		= $_POST['cep'];
			$this->model->cidade 	= $_POST['cidade'];
			$this->model->estado 	= $_POST['estado'];
			$this->model->telefone 	= $_POST['telefone'];
			$this->model->celular 	= $_POST['celular'];

			$this->dao 				= new ClientesDao();
			$result 				= $this->dao->update($this->model);
			echo "<script>alert('{$result}')</script>";
			echo Application::redirect("?controller=clientes");
		}
	}

	public function delAction(){
		if (!empty($_REQUEST['params'])){
			$delID 			= $_REQUEST['params'];

			$this->dao 		= new ClientesDao();
			$result 		= $this->dao->delete($delID);
			echo "<script>alert('{$result}')</script>";
			echo Application::redirect("?controller=clientes");
		}
	}
	/* Functions Eventos Sistema FIM */
}
?>