<?php
class EmpresaController{
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
		header("Location: ?controller=empresa&action=listar");
	}

	/* Telas Sistema */
	public function listarAction(){
		$this->dao 		= new EmpresaDao();
		$result 		= $this->dao->listAll();
		$result			= FilterValidatorLib::filterRequest($result);

		if (!empty($_REQUEST['format']) && $_REQUEST['format'] == 'json'){
			/* Output header */
			header('Content-type: application/json');
			echo json_encode($result);
		}else{
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
				$this->view		= new ViewLib("areaServicosEmpresa");
				$this->view->addDados("title", "Área Empresa - Lista Serviços");
				$this->view->addDados("servicos", $result);
				$this->view->render();
			}
		}
	}

	public function cadastroAction(){
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
			$this->view		= new ViewLib("formularioServico");
			$this->view->addDados("title", "Área Empresa - Adicionar serviço");
			$this->view->addDados("action", "add");
			$this->view->render();	
		}
	}

	public function edicaoAction(){
		if (!empty($_REQUEST['params'])){
			$this->model 			= new EmpresaModel();
			$this->model->ID 		= $_REQUEST['params'];

			$this->dao 				= new EmpresaDao();
			$info 					= $this->dao->listOne($this->model->ID);
			$info 					= FilterValidatorLib::filterRequest($info);
	
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
				$this->view 			= new ViewLib("formularioServico");
				$this->view->addDados("title", "Área Empresa - Editar Serviço");
				$this->view->addDados("action", "edit");
				$this->view->addDados('servico', $info);
				$this->view->render();
			}	
		}
	}
	/* Telas Sistema FIM */

	/* Functions Eventos Sistema */
	public function addAction(){
		if (!empty($_POST)){
			$this->model 			= new EmpresaModel();
			$_POST 					= FilterValidatorLib::filterRequest($_POST);
			$this->model->servico 	= $_POST['servico'];
			$this->dao 				= new EmpresaDao();

			$result 				= $this->dao->add($this->model); 
			echo "<script>alert('{$result}')</script>";
			echo Application::redirect("?controller=empresa");
		}
	}

	public function editAction(){
		if (!empty($_POST)){
			$this->model 			= new EmpresaModel();
			$_POST 					= FilterValidatorLib::filterRequest($_POST);
			$this->model->ID 		= $_POST['servicoID'];

			$this->model->servico 		= $_POST['servico'];
			
			$this->dao 				= new EmpresaDao();
			$result 				= $this->dao->update($this->model);
			echo "<script>alert('{$result}')</script>";
			echo Application::redirect("?controller=empresa");
		}
	}

	public function delAction(){
		if (!empty($_REQUEST['params'])){
			$delID 			= $_REQUEST['params'];

			$this->dao 		= new EmpresaDao();
			$result 		= $this->dao->delete($delID);
			echo "<script>alert('{$result}')</script>";
			echo Application::redirect("?controller=empresa");
		}
	}
	/* Functions Eventos Sistema FIM */
}
?>