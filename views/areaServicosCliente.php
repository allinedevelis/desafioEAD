<?php 
$title 			= $this->getDados("title");
$infoCliente   	= $this->getDados('infoCliente');
$listaServicos 	= $this->getDados('listaServicos'); 

require_once(THEME_ROOT."header.php"); 
?>
	<h1>Área Cliente - Lista Serviços</h1>
	<a class="btnPrincipal" href="?controller=default">Página Principal</a><br/><br/>
	<p><strong>Cliente: </strong><?php echo $infoCliente['nome']; ?></p>
	<p>Serviços contratados: </p>

	<table border="1">
		<th>&nbsp;</th>
		<th>Nome</th>
		<th>Data Início</th>
		<th>Data Fim</th>
		<th>Status / Dias restantes</th>
		<th colspan="2">Opções</th>
		<?php if (!empty($listaServicos)){ $i = 1;
			foreach ($listaServicos as $info){ 
				$dataAtual 	= date('Y-m-d');
				$dataIni  	= $info['data_inicio'];
				$dataFim  = new DateTime( $info['data_fim'] );
		
				$info['data_inicio'] 	= FilterValidatorLib::formatDate($info['data_inicio'], 'br');
				$info['data_fim'] 		= FilterValidatorLib::formatDate($info['data_fim'], 'br');

				if ($dataAtual > $dataIni ){
					$dataHoje = new DateTime( $dataAtual );
					$intervalo = $dataFim->diff( $dataHoje );				
					$texto = "Dias restantes: {$intervalo->d}";
				}else{
					$texto = "Serviço não iniciado";
				}
			?>							
			<tr>
				<td><input type="checkbox" name="del[]" id="del<?php echo $i?>" value="<?php echo $info['ID']?>"</td>
				<td><?php echo $info['nomeServico']; ?></td>
				<td><?php echo $info['data_inicio']; ?></td>
				<td><?php echo $info['data_fim']; ?></td>
				<td><?php echo $texto;?></td>
				<td><a href="#" class="btnDel" deleteid="<?php echo $info['ID']?>">Excluir</a></td>
			</tr>
		<?php
				$i++; 
			}
		} 
		?>
	</table>
	<a class="btnTelas" href="?controller=servicosCliente&action=registro">Contratar serviço</a>
	<a class="btnTelas" id="btnDelSelecionados" href="#">Excluir selecionados</a>
	<input type="button" name="btnVoltar" id="btnVoltar" value="Voltar" class="btnTelas" onclick="javascript:history.back(-1);">
	<input type="hidden" name="controller" id="controller" value="servicosCliente">
<?php require_once(THEME_ROOT."footer.php"); ?>