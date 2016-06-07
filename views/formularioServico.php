<?php 
$title 		= $this->getDados("title");
$action   	= $this->getDados('action');
$servico 	= $this->getDados('servico');

require_once(THEME_ROOT."header.php"); 
?>
	<h1>Área Empresa - Serviços</h1>
	<a href="?controller=default">Página Principal</a><br/><br/>
	<form action="?controller=empresa&action=<?php echo $action;?>" method="post" class="defaultForm" name="frmServico" id="frmServico">
		<input type="hidden" name="servicoID" id="servicoID" value="<?php echo $servico['ID'];?>">
		<div class="field">
			<label for="servico">Nome do Serviço</label>
			<input type="text" name="servico" id="servico" value="<?php echo $servico['nome_servico']?>" req="true">
		</div>
		<input type="button" name="btnVoltar" id="btnVoltar" class="btnDefault" value="Voltar" onclick="javascript:history.back(-1);">
		<br/><br/>
		<input type="submit" name="btnEnviar" id="btnEnviar" value="Salvar" class="btnDefault">
		<input type="hidden" name="controller" id="controller" value="empresa">
	</form>
<?php require_once(THEME_ROOT."footer.php"); ?>