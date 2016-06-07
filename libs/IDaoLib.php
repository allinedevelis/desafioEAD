<?php
interface IDaoLib{
	public function add(ClientesModel $cliente);
	public function update(ClientesModel $cliente);
	public function delete($clienteID);

	public function listOne($clienteID);
	public function listAll($busca = null, $numPagina = 0, $qtdadeRegistros = 20);
}
?>