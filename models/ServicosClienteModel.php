<?php
class ServicosClienteModel{
	private $ID;
	private $clienteID;
	private $servicoID;
	private $dataInicio;
	private $dataFim;

	public function __construct(){}

	public function __set($attribute, $value){
		$this->{$attribute} = $value;
	}

	public function __get($attribute){
		return $this->{$attribute};
	}
}
?>