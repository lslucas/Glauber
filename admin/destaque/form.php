  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="titulo" class="error-validate">Informe o título</label></li> 
		<li><label for="data_inicio" class="error-validate">Entre com uma data válida</label></li> 
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
	  <label>Imagem<span class='small'><!--<a href='javascript:void(0);' class='addImagem' id='min'>adicionar + imagens</a>--></span></label>
	  <?php

	    if ($act=='update') {

		    $sql_gal = "SELECT rdi_id,rdi_imagem,rdi_pos FROM ".TABLE_PREFIX."_r_${var['pre']}_imagem WHERE rdi_${var['pre']}_id=? AND rdi_imagem IS NOT NULL ORDER BY rdi_pos ASC;"; 
		    $qr_gal = $conn->prepare($sql_gal);
		    $qr_gal->bind_param('s',$_GET['item']);
		    $qr_gal->execute();
		    $qr_gal->bind_result($r_id,$r_imagem,$r_pos);
		    $i=0;

		      echo '<table id="posImagem" cellspacing="0" cellpadding="2">';
		      while ($qr_gal->fetch()) {
	  ?>
		<tr id="<?=$r_id?>">
		  <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

		  <td class='small'>
		    [<a href='?p=<?=$p?>&delete_imagem&item=<?=$r_id?>&prefix=r_<?=$var['pre']?>_imagem&pre=rdi&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-imagem' style="cursor:pointer;" id="<?=$r_id?>">remover</a>]
		  </td>

		  <td>

		    <a href='$imagThumb<?=$i?>?width=100%' id='imag<?=$i?>' class='betterTip'>
		     <img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a>

			 <div id='imagThumb<?=$i?>' style='float:left;display:none;'>
			 <?php 
			 
			    if (file_exists(substr($var['path_thumb'],0)."/".$r_imagem))
			     echo "<img src='".substr($var['path_thumb'],0)."/".$r_imagem."'>";

			       else echo "<center>imagem não existe.</center>";
			  ?>
			 </div>

		  </td>
		</tr>

	      <?php
		      $i++;	

			}
		   echo '</table><br>';

	       }
	       ?>


		 <div class='divImagem'>
		   <input class="imagem" type='file' name='imagem0' id='imagem' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px;">
		   <br><span class='small'>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
		 </div>
		 </p>
        </li>




	<li>	
	  <label>Relacionado com<span class='small'>Galeria de fotos, estabelecimentos, notícias ou agenda</span></label>
    <select name='idrel' id='idrel'/>
      <option>Selecione</option>
      <option> - Agenda</option>
	  <?php

			$sql_agd = "SELECT eve_id, eve_titulo FROM ".TABLE_PREFIX."_evento WHERE eve_status=1 ORDER BY eve_data_inicio DESC";

	    if($qry_agd = $conn->prepare($sql_agd)) {

	      $qry_agd->execute();
        $qry_agd->bind_result($agd_id, $agd_nome);


	      while ($qry_agd->fetch()) {

	       if ($act=='update') {
	        $check = ( isset($val['idrel']) && $val['area'].$val['idrel']=='agd'.$agd_id )?' selected':'';

	        } else $check = '';


	  ?>
	    <option value='agd<?=$agd_id?>'<?=$check?>> <?=$agd_nome?></option>
	  <?php

	      $i++;
	      }
      }

	   $qry_agd->close();
	  ?>
      <option>&nbsp;</option>
      <option> - Estabelecimentos</option>
	  <?php

			$sql_loc = "SELECT loc_id, loc_titulo FROM ".TABLE_PREFIX."_local WHERE loc_status=1 ORDER BY loc_titulo ASC";

	    if($qry_loc = $conn->prepare($sql_loc)) {

	      $qry_loc->execute();
        $qry_loc->bind_result($loc_id, $loc_nome);


	      while ($qry_loc->fetch()) {

	       if ($act=='update') {
	        $check = ( isset($val['idrel']) && $val['area'].$val['idrel']=='loc'.$loc_id )?' selected':'';

	        } else $check = '';


	  ?>
	    <option value='loc<?=$loc_id?>'<?=$check?>> <?=$loc_nome?></option>
	  <?php

	      $i++;
	      }

	     $qry_loc->close();

      } else echo $conn->error;

	  ?>
      <option>&nbsp;</option>
      <option> - Notícia</option>
	  <?php

			$sql_not = "SELECT not_id, not_titulo FROM ".TABLE_PREFIX."_noticia WHERE not_status=1 ORDER BY not_data DESC";

	    if($qry_not = $conn->prepare($sql_not)) {

	      $qry_not->execute();
        $qry_not->bind_result($not_id, $not_nome);


	      while ($qry_not->fetch()) {

	       if ($act=='update') {
	        $check = ( isset($val['idrel']) && $val['area'].$val['idrel']=='not'.$not_id )?' selected':'';

	        } else $check = '';


	  ?>
	    <option value='not<?=$not_id?>'<?=$check?>> <?=$not_nome?></option>
	  <?php

	      $i++;
	      }
      }

	   $qry_not->close();
	  ?>
      <option>&nbsp;</option>
      <option> - Galeria de fotos</option>
	  <?php
	    $statusCat=1;


			$sql_gal = "SELECT gal_id, gal_titulo FROM ".TABLE_PREFIX."_galeria WHERE gal_status=1 ORDER BY gal_data DESC";

	    if($qry_gal = $conn->prepare($sql_gal)) {

	      $qry_gal->execute();
        $qry_gal->bind_result($gal_id, $gal_nome);


	      while ($qry_gal->fetch()) {

	       if ($act=='update') {
	        $check = ( isset($val['idrel']) && $val['area'].$val['idrel']=='gal'.$gal_id )?' selected':'';

	        } else $check = '';


	  ?>
	    <option value='gal<?=$gal_id?>'<?=$check?>> <?=$gal_nome?></option>
	  <?php

	      $i++;
	      }
      }

	   $qry_gal->close();
	  ?>
    </select><br/><br/><br/>
	
	</li>



	<li>	
	  <label>Título *<span class='small'>Nome do evento</span></label>
	  <input type='text' name='titulo' id='titulo' class='required' value='<?=$val['titulo']?>'> <span class='min' id='limit-titulo'></span>
	</li>


	<li>
	  <label>Data *<span class='small'>Entre com a data</span></label>
	  <input type='text' id='data' name='data' class='required  highlight-days-67 range-low-<?=date('Y-m-d',strtotime('-2 year'))?> range-high-<?=date('Y-m-d',strtotime('+5 month'))?> split-date' size='10' value='<?=dateen2pt($val['data'],'/')?>'>
	</li>


	<li>
	  <label>Texto *<span class='small'>Digite um texto</span></label>
    <span class='min' id='limit-texto'></span>
    <br/>
	  <textarea name='texto' id='texto' class='required tinymce' cols='80' rows='15'><?=$val['texto']?></textarea>
	</li>


	<li>	
	  <label>Link externo <span class='small'>Apenas caso o destaque seja um link externo</span></label>
	  <input type='text' name='url' id='url' class='url' value='<?=$val['url']?>'>
	</li>

    </ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>
