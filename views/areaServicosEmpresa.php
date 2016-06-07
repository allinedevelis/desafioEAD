<?php 
$title 		= $this->getDados("title");
$servicos 	= $this->getDados('servicos'); 

require_once(THEME_ROOT."header.php"); 
?>
	<h1>Área Empresa - Lista Serviços</h1>
	<a class="btnPrincipal" href="?controller=default">Página Principal</a><br/><br/>
	<table border="1">
		<th>&nbsp;</th>
		<th>Nome Serviço</th>
		<th colspan="2">Opções</th>
		<?php if (!empty($servicos)){ $i = 1;
			foreach ($servicos as $info){ ?>							
			<tr>
				<td><input type="checkbox" name="del[]" id="del<?php echo $i?>" value="<?php echo $info['ID']?>"</td>
				<td><?php echo $info['nome_servico'];?></td>
				<td><a href="?controller=empresa&action=edicao&params=<?php echo $info['ID']?>">Editar</a></td>
				<td><a href="#" class="btnDel" deleteid="<?php echo $info['ID']?>">Excluir</a></td>
			</tr>
		<?php
				$i++; 
			}
		} 
		?>
	</table>
	<a class="btnTelas" href="?controller=empresa&action=cadastro">Cadastrar serviço</a>
	<a class="btnTelas" id="btnDelSelecionados" href="#">Excluir selecionados</a>
	<input type="hidden" name="controller" id="controller" value="empresa">
<?php require_once(THEME_ROOT."footer.php"); ?>