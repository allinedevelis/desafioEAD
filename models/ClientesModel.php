<?php
class ClientesModel{
	private $ID;
	private $nome;
	private $email;
	private $endereco;
	private $bairro;
	private $cep;
	private $cidade;
	private $estado;
	private $telefone;
	private $celular;

	public function __construct(){}

	public function __set($attribute, $value){
		$this->{$attribute} = $value;
	}

	public function __get($attribute){
		return $this->{$attribute};
	}
}
?>