<?php 
$title = $this->getDados("title");

require_once(THEME_ROOT."header.php"); 
?>
	<h1>Área de Login</h1>
	<form action="?controller=default&action=login" method="post" id="frmLogin" name="frmLogin" class="defaultForm">
		<div class="field">
			<label for="login">Login</label>
			<input type="text" name="login" id="login" value="" req="true">
		</div>
		<div class="field">
			<label for="senha">Senha</label>
			<input type="password" name="senha" id="senha" value="" req="true">
		</div>
		<div class="field">
			<input type="checkbox" name="manterSessao" id="manterSessao" value="true">
			<label id="lblManterSessao" for="manterSessao">Manter conectado</label>
		</div>
		<input type="button" name="btnEntrar" id="btnEntrar" value="Entrar" class="btnDefault">
	</form>
<?php require_once(THEME_ROOT."footer.php"); ?>