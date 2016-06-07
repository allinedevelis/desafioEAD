<?php 
$title 		= $this->getDados("title");
$clientes 	= $this->getDados('clientes'); 

require_once(THEME_ROOT."header.php"); 
?>
	<h1>Área de Clientes - Lista</h1>
	<a class="btnPrincipal" href="?controller=default">Página Principal</a><br/><br/>
	<table border="1">
		<th>&nbsp;</th>
		<th>Nome</th>
		<th>Email</th>
		<th>Endereço</th>
		<th>Bairro</th>
		<th>Cep</th>
		<th>Local</th>
		<th>Telefone</th>
		<th>Celular</th>
		<th colspan="2">Opções</th>
		<th>Serviços</th>
		<?php if (!empty($clientes)){ $i = 1;
			foreach ($clientes as $info){ ?>							
			<tr>
				<td><input type="checkbox" name="del[]" id="del<?php echo $i?>" value="<?php echo $info['ID']?>"</td>
				<td><?php echo $info['nome'];?></td>
				<td><?php echo $info['email'];?></td>
				<td><?php echo $info['endereco'];?></td>
				<td><?php echo $info['bairro'];?></td>
				<td><?php echo $info['cep'];?></td>
				<td><?php echo "{$info['cidade']}/{$info['uf']}";?></td>
				<td><?php echo $info['telefone'];?></td>
				<td><?php echo $info['celular'];?></td>
				<td><a href="?controller=clientes&action=edicao&params=<?php echo $info['ID']?>">Editar</a></td>
				<td><a href="#" class="btnDel" deleteid="<?php echo $info['ID']?>">Excluir</a></td>
				<td><a href="?controller=servicosCliente&action=listar&params=<?php echo $info['ID']?>">Visualizar</a></td>
			</tr>
		<?php
				$i++; 
			}
		} 
		?>
	</table>
	<a class="btnTelas" href="?controller=clientes&action=cadastro">Cadastrar cliente</a>
	<a class="btnTelas" id="btnDelSelecionados" href="#">Excluir selecionados</a>
	<input type="hidden" name="controller" id="controller" value="clientes">
<?php require_once(THEME_ROOT."footer.php"); ?>