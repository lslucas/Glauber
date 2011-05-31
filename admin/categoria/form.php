  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<!--<li><label for="imagem" class="error-validate">Envia a imagem da categoria</label></li> -->
		<li><label for="titulo" class="error-validate">Informe o título</label></li> 
		<li><label for="area" class="error-validate">Selecione a área da categoria</label></li>
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


<!--
	<li>	
	  <label>Imagem</label>
	  <?php
		
	    if ($act=='update' && !empty($val['imagem']) ) {


		      echo '<table id="posImagem" cellspacing="0" cellpadding="2">';
	  ?>
		<tr id="<?=$r_id?>">
		  <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

		  <td class='small'>
        [<a href='?p=<?=$p?>&delete_imagem&item=<?=$_GET['item']?>&prefix=<?=$var['path']?>&pre=<?=$var['pre']?>&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-imagem' style="cursor:pointer;" id="<?=$_GET['item']?>">remover</a>]
		  </td>

		  <td>

		    <a href='$imagThumb?width=100%' id='imag' class='betterTip'>
		     <img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a>

			 <div id='imagThumb' style='float:left;display:none;'>
			 <?php 
			 
			    if (file_exists(substr($var['path_imagem'],0)."/".$val['imagem']))
			     echo "<img src='".substr($var['path_imagem'],0)."/".$val['imagem']."'>";

			       else echo "<center>imagem não existe.</center>";
			  ?>
			 </div>

		  </td>
		</tr>

	      <?php

  		   echo '</table><br>';

	       } else {

       ?>
		 <div class='divImagem'>
		   <input class="imagem" type='file' name='imagem' id='imagem' style="height:18px;font-size:7pt;margin-bottom:8px;">
		   <br><span class='small'>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
		 </div>
		 </p>
      <?php

        }

      ?>
   </li>
-->


	<li>	
	  <label>Título *<span class='small'>Digite o título da categoria</span></label>
	  <input type='text' name='titulo' id='titulo' class='required' value='<?=$val['titulo']?>'>
	</li>


<!--
	<li>
	<label>Área *<span class='small'>Área da categoria</span></label>
     <select class='required' name='area' id='area'>
        <option value=''>Selecione</option>
        <option value='local'<?=$val['area']=='local'?' selected':''?>>Estabelecimentos</option>
        <option value='icoservico'<?=$val['area']=='icoservico'?' selected':''?>>Icones de Serviços</option>
     </select>
	</li>
-->


 </ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>


