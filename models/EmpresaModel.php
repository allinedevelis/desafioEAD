<?php
class EmpresaModel{
	private $ID;
	private $servico;

	public function __construct(){}

	public function __set($attribute, $value){
		$this->{$attribute} = $value;
	}

	public function __get($attribute){
		return $this->{$attribute};
	}
}
?>