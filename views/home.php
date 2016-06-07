<?php 
$title = $this->getDados("title");

require_once(THEME_ROOT."header.php"); 
?>
	<h1>Bem-vindo(a)! O que deseja fazer?</h1>
	<div align="center">
		<a class="btnDefault" href="?controller=servicosCliente&action=registro">Contratar serviço</a>
		<br/><br/>
		<a class="btnDefault" href="?controller=clientes">Área Clientes</a>
		<br/><br/>
		<a class="btnDefault" href="?controller=empresa">Área Empresa</a>
	</div>
<?php require_once(THEME_ROOT."footer.php"); ?>