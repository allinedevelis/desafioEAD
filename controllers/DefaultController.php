<?php
/**
 * Controlador padrão (será chamado quando não for especificado nenhum outro)
 */
class DefaultController{
	private $daoLogin;
	private $view;
	
	public function __construct(){}

	public function __set($attribute, $value){
		$this->{$attribute} = $value;
	}

	public function __get($attribute){
		return $this->{$attribute};
	}

	public function indexAction(){
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
			$this->view = new ViewLib('home');
			$this->view->addDados("title", "Página Principal");
			$this->view->render();
		}
	}

	public function loginAction(){
		if (!empty($_POST)){
			extract($_POST);
			$this->daoLogin = new LoginDao();
			$resultado 		= $this->daoLogin->listOne($login, $senha);

			if (!empty($resultado)){
				$sessionID = md5(uniqid("session"));
				// manterSessao = 1 ano / default = 1 dia
				$expirationTime = (isset($manterSessao)) ? (int) (60*60*24*365) : (int) (60*60*24); 
				setcookie("userID", $resultado['ID'], time()+$expirationTime, "/");
				setcookie("sessionUserID", $sessionID, time()+$expirationTime, "/");

				if (!empty($_COOKIE['sessionUserID']) && !empty($_COOKIE['userID'])){
					$this->daoLogin->updateSession($sessionID, $resultado['ID']);
					$this->view = new ViewLib('home');
					$this->view->addDados("title", "Página Principal");
					$this->view->render();
				}
			}else{
				echo "<script>alert('".utf8_decode('Usuário não encontrado!')."')</script>";
				echo Application::redirect("?controller=default&action=index");
			}
		}
	}

	public function logoutAction(){
		unset($_COOKIE['sessionUserID']);
		unset($_COOKIE['userID']);
		unset($_COOKIE['userNome']);
	    setcookie('userID', '', time() - 3600, "/");
	    setcookie('userNome', '', time() - 3600, "/");
	    setcookie('sessionUserID', '', time() - 3600, "/");

	    $this->view = new ViewLib('formularioLogin');
		$this->view->addDados("title", "Página Principal");
		$this->view->render();
	}
}
?>