  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="titulo" class="error-validate">Informe o título</label></li> 
		<li><label for="data_inicio" class="error-validate">Entre com uma data de início</label></li> 
		<li><label for="data_termino" class="error-validate">Entre com uma data de término</label></li> 
		<li><label for="contato" class="error-validate">Informe o contato</label></li> 
		<li><label for="local" class="error-validate">Informe o local do evento</label></li> 
		<li><label for="texto" class="error-validate">Necessário informar algum texto</label></li> 
		<li><label for="url" class="error-validate">URL inválida</label></li> 
	</ol> 
  </div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' id='form_<?=$p?>' class='form cmxform' enctype="multipart/form-data">
 <input type='hidden' name='act' value='<?=$act?>'>
<?php
  if ($act=='update')
    echo "<input type='hidden' name='item' value='${_GET['item']}'>";
?>

<h1>
<?php 
  if ($act=='insert') echo $var['insert'];
   else echo $var['update'];
?>
</h1>
<p class='header'>Todos os campos com <b>- * -</b> são obrigatórios.</p>



    <ol>


	<li>	
	  <label>Galeria de fotos<span class='small'>Existe fotos do local</span></label>
    <select name='gal_id' id='gal_id'/>
      <option>Selecione</option>
	  <?php
	    $statusCat=1;


			$sql_gal = "SELECT gal_id, gal_titulo FROM ".TABLE_PREFIX."_galeria WHERE gal_status=1 ORDER BY gal_data DESC";

	    if($qry_gal = $conn->prepare($sql_gal)) {

	      $qry_gal->execute();
        $qry_gal->bind_result($gal_id, $gal_nome);


	      while ($qry_gal->fetch()) {

	       if ($act=='update') {
	        $check = ( isset($val['gal_id']) && $val['gal_id']==$gal_id )?' selected':'';

	        } else $check = '';


	  ?>
	    <option value='<?=$gal_id?>'<?=$check?>> <?=$gal_nome?></option>
	  <?php

	      $i++;
	      }
      }

	   $qry_gal->close();
	  ?>
    </select>
	
	</li>



	<li>	
	  <label>Título *<span class='small'>Nome do evento</span></label>
	  <input type='text' name='titulo' id='titulo' class='required' value='<?=$val['titulo']?>'>
	</li>


	<li>
	  <label>Data Início *<span class='small'>Entre com a data de início</span></label>
	  <input type='text' id='data_inicio' name='data_inicio' class='required  highlight-days-67 range-low-<?=date('Y-m-d',strtotime('-2 year'))?> range-high-<?=date('Y-m-d',strtotime('+5 month'))?> split-date' size='10' value='<?=dateen2pt($val['data_inicio'],'/')?>'>
	</li>


	<li>
	  <label>Data Término<span class='small'>Entre com a data de término</span></label>
	  <input type='text' id='data_termino' name='data_termino' class='highlight-days-67 range-low-<?=date('Y-m-d',strtotime('-2 year'))?> range-high-<?=date('Y-m-d',strtotime('+5 month'))?> split-date' size='10' value='<?=dateen2pt($val['data_termino'],'/')?>'>
	</li>


	<li>	
	  <label>Contato<span class='small'>Responsável</span></label>
	  <input type='text' name='contato' id='contato' value='<?=$val['contato']?>'>
	</li>


	<li>
	  <label>Texto *<span class='small'>Digite um texto</span></label>
	  <textarea name='texto' id='texto' class='required tinymce' cols='80' rows='15'><?=$val['texto']?></textarea>
	</li>


	<li>
	  <label>Local<span class='small'>Endereço e telefones do local</span></label>
	  <textarea name='local' id='local' class='tinymce' cols='80' rows='7'><?=$val['local']?></textarea>
	</li>


	<li>	
	  <label>Site <span class='small'>Site do evento</span></label>
	  <input type='text' name='url' id='url' class='url' value='<?=$val['url']?>'>
	</li>

    </ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>
