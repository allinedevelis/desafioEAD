<?php
class ServicosClienteController{
	private $daoEmpresa;
	private $modelEmpresa;

	private $daoCliente;
	private $modelCliente;

	private $daoRegistro;
	private $modelServicoCliente;

	private $daoLogin;
	public $view;
	
	public function __set($attribute, $value){
		$this->{$attribute} = $value;
	}

	public function __get($attribute){
		return $this->{$attribute};
	}

	public function indexAction(){
		header("Location: ?controller=default");
	}

	/* Telas Sistema */
	public function registroAction(){
		$this->daoEmpresa 	= new EmpresaDao();
		$listaServicos 		= $this->daoEmpresa->listAll();

		$this->daoCliente	= new ClientesDao();
		$listaClientes		= $this->daoCliente->listAll();

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
			$this->view			= new ViewLib("formularioRegistroServico");
			$this->view->addDados("title", "Área Contratação de Serviços - Adicionar");
			$this->view->addDados("action", "add");
			$this->view->addDados('listaServicos', $listaServicos);
			$this->view->addDados('listaClientes', $listaClientes);
			$this->view->render();	
		}		
	}

	public function listarAction(){
		if (!empty($_REQUEST['params'])){
			$this->daoRegistro 	= new ServicosClienteDao();
			$result 			= $this->daoRegistro->listServicos($_REQUEST['params']);
			$result				= FilterValidatorLib::filterRequest($result);

			$this->daoCliente 	= new ClientesDao();
			$cliente 			= $this->daoCliente->listOne($_REQUEST['params']);

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
				$this->view		= new ViewLib("areaServicosCliente");
				$this->view->addDados("title", "Área Contratação de Serviços - Listar");
				$this->view->addDados("infoCliente", $cliente);
				$this->view->addDados("listaServicos", $result);
				$this->view->render();
			}		
		}
	}
	/* Telas Sistema FIM */

	/* Functions Eventos Sistema */
	public function addAction(){
		if (!empty($_POST)){
			$_POST 									= FilterValidatorLib::filterRequest($_POST);

			$_POST['dataInicio'] 					= FilterValidatorLib::formatDate($_POST['dataInicio']);
			$_POST['dataFim'] 						= FilterValidatorLib::formatDate($_POST['dataFim']);

			$this->modelServicoCliente 				= new ServicosClienteModel();
			$this->modelServicoCliente->clienteID 	= $_POST['cliente'];
			$this->modelServicoCliente->servicoID 	= $_POST['servico'];
			$this->modelServicoCliente->dataInicio 	= $_POST['dataInicio'];
			$this->modelServicoCliente->dataFim 	= $_POST['dataFim'];
			
			$this->dao 								= new ServicosClienteDao();

			$result 								= $this->dao->add($this->modelServicoCliente); 
			echo "<script>alert('{$result}')</script>";
			echo Application::redirect("?controller=servicosCliente");
		}
	}
	
	public function delAction(){
		if (!empty($_REQUEST['params'])){
			$delID 			= $_REQUEST['params'];

			$this->daoRegistro	= new ServicosClienteDao();
			$result 			= $this->daoRegistro->delete($delID);
			echo "<script>alert('{$result}')</script>";
			echo Application::redirect("?controller=servicosCliente");
		}
	}
	/* Functions Eventos Sistema FIM */
}
?>