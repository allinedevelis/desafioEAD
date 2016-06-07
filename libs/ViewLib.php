<?php
class ViewLib{
	private $nomeView;
	private $dadosView;

	public function __construct($nomeView){
		$this->nomeView 	= $nomeView;
		$this->dadosView 	= array();
	}

	public function __set($attribute, $value){
		$this->$attribute = $value;
	}

	public function __get($attribute){
		return $this->$attribute;
	}

	public function render($nomeView = null){
		$viewFile = (empty($this->nomeView)) ? $nomeView : $this->nomeView;

		if (file_exists(ROOT."views/{$viewFile}.php")){
			require_once(ROOT."views/{$viewFile}.php");
		}else{
			return "Arquivo {$viewFile} não encontrado!";
		}
	}

	public function addDados($indice, $dados){
		$this->dadosView[$indice] = $dados;
	}

	public function getDados($indice = false){
		if (empty($indice)){
			return $this->dadosView;
		}else{
			if (isset($this->dadosView[$indice]))
				return $this->dadosView[$indice];
			else
				return false;
		}
	}
}
?>