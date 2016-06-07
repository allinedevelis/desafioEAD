<?php 
$title 			= $this->getDados("title");
$action   		= $this->getDados('action');
$registro 		= $this->getDados('registro');
$listaClientes 	= $this->getDados('listaClientes');
$listaServicos 	= $this->getDados('listaServicos');

require_once(THEME_ROOT."header.php"); 
?>
	<h1>Área de Contratação de Serviços</h1>
	<a class="btnPrincipal" href="?controller=default">Página Principal</a><br/><br/>
	<form action="?controller=servicosCliente&action=<?php echo $action;?>" method="post" class="defaultForm" id="frmContratacao" name="frmContratacao">
		<input type="hidden" name="registroID" id="registroID" value="<?php echo $registro['ID'];?>">
		<div class="field">
			<label>Cliente</label>
			<select name="cliente" id="cliente" req="true">
				<option value="">-- Selecione --</option>
				<?php foreach ($listaClientes as $indice => $value){ 
					$flagSelected = ($registro['clienteID'] == $value['ID']) ? "selected='selected'" : ''; 
				?>
				<option value="<?php echo $value['ID']?>" <?php echo $flagSelected;?>><?php echo $value['nome'];?></option>
				<?php } ?>
			</select>
		</div>
		<div class="field">
			<label>Serviço</label>
			<select name="servico" id="servico" req="true">
				<option value="">-- Selecione --</option>
				<?php foreach ($listaServicos as $indice => $value){ 
					$flagSelected = ($registro['servicoID'] == $value['ID']) ? "selected='selected'" : ''; 
				?>
				<option value="<?php echo $value['ID']?>" <?php echo $flagSelected;?>><?php echo $value['nome_servico'];?></option>
				<?php } ?>
			</select>
		</div>
		<div class="field">
			<label for="dataInicio">Data de início</label>
			<input class="dateMask" type="text" name="dataInicio" id="dataInicio" value="<?php echo $registro['dataInicio'];?>" req="true">
		</div>
		<div class="field">
			<label for="dataFim">Data de Fim</label>
			<input class="dateMask" type="text" name="dataFim" id="dataFim" value="<?php echo $registro['dataFim'];?>" req="true">
		</div>
		<input type="submit" name="btnEnviar" id="btnEnviar" value="Salvar Contratação" class="btnDefault">
		<input type="hidden" name="controller" id="controller" value="servicosCliente">
		<br/><br/>
		<input type="button" name="btnVoltar" id="btnVoltar" value="Voltar" class="btnDefault" onclick="javascript:history.back(-1);">	
	</form>
<?php require_once(THEME_ROOT."footer.php"); ?>