  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="titulo" class="error-validate">Informe o título</label></li> 
		<li><label for="data" class="error-validate">Entre com uma data válida</label></li> 
		<li><label for="galeria" class="error-validate">Envia alguma imagem/foto</label></li> 
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
	  <label>Título *<span class='small'>Digite o título</span></label>
	  <input type='text' name='titulo' id='titulo' class='required' value='<?=$val['titulo']?>'>
	</li>


	<li>
	  <label>Data *<span class='small'>Entre com a data</span></label>
	  <input type='text' id='data' name='data' class='required  highlight-days-67 range-low-<?=date('Y-m-d',strtotime('-2 year'))?> range-high-<?=date('Y-m-d',strtotime('+5 month'))?> split-date' size='10' value='<?=dateen2pt($val['data'],'/')?>'>
	</li>


	<li>	
	  <label>Área *<span class='small'>Em qual área do site será exibida essa galeria</span></label>
	  <?php
	    $statusCat=1;


		$sql_categoria = "SELECT cat_id, cat_titulo FROM ".TABLE_PREFIX."_categoria 
							WHERE cat_status=? AND cat_area='area'";

	    $qry_categoria = $conn->prepare($sql_categoria);
	    $qry_categoria->bind_param('i', $statusCat);
	    $qry_categoria->execute();
	    $qry_categoria->bind_result($id, $nome);


	      $i=0;
	      while ($qry_categoria->fetch()) {

	       if ($act=='update') {
	        $check[$id] = ($id==$val['cat_id'])?' checked':''; 

	        } else $check[$id] = '';


	       if ($i<>0) echo '<br>';
	  ?>
	        <input type='radio' class='required' name='cat_id[]' id='cat_id' value='<?=$id?>'<?=$check[$id]?>> <?=$nome?> 
	  <?php 

	    $i++;
	    }
	   $qry_categoria->close();
	  ?>
	
	</li>


	<li>	
	  <label>Fotos<span class='small'><a href='javascript:void(0);' class='addImagem' id='min'>adicionar + fotos</a></span></label>
	  <span id='min' style='color:#ccc;'>Para alterar a posição da foto, não clique sobre a foto, passe o mouse na coluna ao lado da foto até que fique cinza, clique e arraste para a posição desejada</span>
	  <br/><br/>
	  <?php
	    if ($act=='update') {

		    $sql_gal = "SELECT rgi_id,rgi_imagem,rgi_pos FROM ".TABLE_PREFIX."_r_gal_imagem WHERE rgi_gal_id=? AND rgi_imagem IS NOT NULL ORDER BY rgi_pos ASC;"; 
		    $qr_gal = $conn->prepare($sql_gal);
		    $qr_gal->bind_param('s',$_GET['item']);
		    $qr_gal->execute();
		    $qr_gal->bind_result($g_id,$g_imagem,$g_pos);
		    $i=0;

		      echo '<table id="posGaleria" cellspacing="0" cellpadding="2">';
		      while ($qr_gal->fetch()) {
	  ?>
		<tr id="<?=$g_id?>">
		  <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

		  <td class='small' width='60px' valign=bottom>
		    [<a href='?p=<?=$p?>&delete_galeria&item=<?=$g_id?>&prefix=r_gal_imagem&pre=rgi&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-galeria' style="cursor:pointer;" id="<?=$g_id?>">remover</a>]
		  </td>

		  <td height=60px>

<!--
		    <a href='$imagThumb<?=$i?>?width=100%' id='imag<?=$i?>' class='betterTip'>
		     <img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a>

-->
<!--			 <div id='imagThumb<?=$i?>' style='float:left;display:none;'>-->
			 <?php 
			 
			    if (file_exists(substr($var['path_thumb'],0)."/".$g_imagem))
			     echo "<img src='".substr($var['path_thumb'],0)."/".$g_imagem."' width=60>";

			       else echo "[imagem não existe]";
			  ?>
<!--			 </div>-->

		  </td>
		</tr>

	      <?php
		      $i++;	

			}
		   echo '</table><br>';

	       }
	       ?>


		 <div class='divImagem'>
		   <input class="galeria" type='file' name='galeria0' id='galeria' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px;" accept="image/*">
		   <br><span class='small'>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
		 </div>
		 </p>
        </li>


  </ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>
