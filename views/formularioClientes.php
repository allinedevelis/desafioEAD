<?php 
$title 		= $this->getDados("title");
$action   	= $this->getDados('action');
$clientes 	= $this->getDados('clientes');
$estados  	= $this->getDados('estados');
$cidades  	= $this->getDados('cidades');

require_once(THEME_ROOT."header.php"); 
?>
	<h1>Área de Clientes - Cadastro</h1>
	<a class="btnPrincipal" href="?controller=default">Página Principal</a><br/><br/>
	<form action="?controller=clientes&action=<?php echo $action;?>" method="post" class="defaultForm" id="frmCliente" name="frmCliente">
		<input type="hidden" name="clienteID" id="clienteID" value="<?php echo $clientes['ID'];?>">
		<div class="field">
			<label for="nome">Nome</label>
			<input type="text" name="nome" id="nome" value="<?php echo $clientes['nome']?>" req="true">
		</div>
		<div class="field">
			<label for="email">Email</label>
			<input type="text" name="email" id="email" value="<?php echo $clientes['email']?>" req="true">
		</div>
		<div class="field">
			<label for="endereco">Endereço</label>
			<input type="text" name="endereco" id="endereco" value="<?php echo $clientes['endereco']?>" req="true">
		</div>
		<div class="field">
			<label for="bairro">Bairro</label>
			<input type="text" name="bairro" id="bairro" value="<?php echo $clientes['bairro']?>">
		</div>
		<div class="field">
			<label for="cep">CEP</label>
			<input class="cepMask" type="text" name="cep" id="cep" value="<?php echo $clientes['cep']?>" req="true">
		</div>
		<div class="field">
			<label for="estado">Estado</label>
			<input type="hidden" name="estadoID" id="estadoID" value="<?php echo $clientes['estadoID']?>">
			<select name="estado" id="estado" req="true">
				<option value="">-- Selecione --</option>
				<?php foreach ($estados as $indice => $value){ 
					$flagSelected = ($clientes['uf'] == $value['sigla']) ? "selected='selected'" : ''; 
				?>
				<option value="<?php echo $value['ID']?>" <?php echo $flagSelected;?>><?php echo $value['sigla'];?></option>
				<?php } ?>
			</select>
		</div>
		<div class="field">
			<label for="cidade">Cidade</label>
			<input type="hidden" name="cidadeID" id="cidadeID" value="<?php echo $clientes['cidadeID']?>">
			<select name="cidade" id="cidade" req="true">
				<?php foreach ($cidades as $indice => $value){ 
					$flagSelected = ($clientes['cidadeID'] == $value['ID']) ? "selected='selected'" : ''; 
				?>
				<option value="<?php echo $value['ID']?>" <?php echo $flagSelected;?>><?php echo $value['nome'];?></option>
				<?php } ?>
			</select>
		</div>
		<div class="field">
			<label for="telefone">Telefone</label>
			<input class="foneMask" type="text" name="telefone" id="telefone" value="<?php echo $clientes['telefone'];?>">
		</div>
		<div class="field">
			<label for="celular">Celular</label>
			<input class="foneMask" type="text" name="celular" id="celular" value="<?php echo $clientes['celular'];?>">
		</div>
		<input type="submit" name="btnEnviar" class="btnDefault" id="btnEnviar" value="Salvar Cliente">
		<input type="button" class="btnDefault" name="btnVoltar" id="btnVoltar" value="Voltar" onclick="javascript:history.back(-1);">
		<input type="hidden" name="controller" id="controller" value="clientes">
	</form>
<?php require_once(THEME_ROOT."footer.php"); ?>