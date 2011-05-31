  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="titulo" class="error-validate">Preencha o nome do estabelecimento</label></li>
		<li><label for="gal_id" class="error-validate">Selecione uma galeria válida</label></li>
		<li><label for="cat_id" class="error-validate">Informe o tipo do estabelecimento</label></li>
		<li><label for="contato" class="error-validate">Nome do responsável</label></li>
		<li><label for="endereco" class="error-validate">Local, endereço do estabelecimento</label></li>
		<li><label for="url" class="error-validate">URL inválida, a url sempre inicia com <b>http://</b></label></li>
		<li><label for="texto" class="error-validate">Informe o texto descritivo</label></li>
		<li><label for="algomais" class="error-validate">Informe o texto para Algo mais</label></li>
		<li><label for="maisinfo" class="error-validate">Informe o texto para Mais informações</label></li>
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

  <?php

    if(empty($_SESSION['user']['tipo'])) {

  ?>
	<li>	
	  <label>Tipo *<span class='small'>Tipo do estabelecimento</span></label>
	  <?php
	    $statusCat=1;


		if($act=='insert') 
		  $sql_categoria = "SELECT cat_id, 
								   cat_titulo
			  						FROM ".TABLE_PREFIX."_categoria 
        						WHERE cat_status=? AND cat_area='local'";

		  else
			$sql_categoria = "SELECT cat_id, 
									 cat_titulo,
									 (SELECT COUNT(rlc_id) FROM ".TABLE_PREFIX."_r_loc_categoria WHERE rlc_cat_id=cat_id and rlc_loc_id='".$val['id']."') checked
									 
									  FROM ".TABLE_PREFIX."_categoria 
						        WHERE cat_status=? AND cat_area='local'";

	    $qry_categoria = $conn->prepare($sql_categoria);
	    $qry_categoria->bind_param('i', $statusCat);
	    $qry_categoria->execute();

		 if($act=='insert')
	       $qry_categoria->bind_result($id, $nome);

		   else $qry_categoria->bind_result($id, $nome, $checked);




	      $i=0;
	      while ($qry_categoria->fetch()) {

	       if ($act=='update') {
	        $check[$id] = ($checked>0)?' checked':''; 

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
  <?php

    } else {


        $sql_adm = "SELECT cat_titulo, cat_id FROM ".TABLE_PREFIX."_r_loc_categoria 
                      INNER JOIN ".TABLE_PREFIX."_categoria ON cat_id=rlc_cat_id
                    WHERE rlc_loc_id=?";
        if($qry_adm = $conn->prepare($sql_adm)) {

          $qry_adm->bind_param('i', $val['id']);
          $qry_adm->execute();
          $qry_adm->bind_result($nome, $id);
          $qry_adm->fetch();
          $qry_adm->close();


          echo "<li><label>Tipo<span class='small'>Tipo do estabelecimento</span></label>";
          echo "$nome";
          echo "</li>";
          echo "<input type='hidden' name='cat_id[]' value={$id}>";

        } else echo $conn->error;

    }

  ?>


	<li>	
	  <label>Imagem<span class='small'><a href='javascript:void(0);' class='addImagem' id='min'>adicionar + imagens</a></span></label>
	  <?php
		  
	    if ($act=='update') {
				  
		    $sql_gal = "SELECT rli_id,rli_imagem,rli_pos FROM ".TABLE_PREFIX."_r_${var['pre']}_imagem WHERE rli_${var['pre']}_id=? AND rli_imagem IS NOT NULL ORDER BY rli_pos ASC;"; 
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
		    [<a href='?p=<?=$p?>&delete_imagem&item=<?=$r_id?>&prefix=r_<?=$var['pre']?>_imagem&pre=rli&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-imagem' style="cursor:pointer;" id="<?=$r_id?>">remover</a>]
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


  <?php

    if(empty($_SESSION['user']['tipo'])) {

  ?>
	<li>	
	  <label>Galeria de fotos<span class='small'>Existe fotos do local</span></label>
    <select name='gal_id' id='gal_id'/>
      <option>Nenhuma</option>
	  <?php
	    $statusCat=1;


			$sql_gal = "SELECT gal_id, gal_titulo FROM ".TABLE_PREFIX."_galeria WHERE gal_status=1 ORDER BY gal_data DESC";

	    if($qry_gal = $conn->prepare($sql_gal)) {

	      $qry_gal->execute();
        $qry_gal->bind_result($gal_id, $gal_nome);


	      while ($qry_gal->fetch()) {

	       if ($act=='update') {
	        $check = isset($val['gal_id']) && $val['gal_id']==$gal_id ?' selected':'';

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
  <?php

    }

  ?>


	<li>	
	  <label>Mostrar Galeria de fotos<span class='small'>Ativa exibição de galeria de fotos, caso exista</span></label>
    <input type='checkbox' name='ativa_gal' id='ativa_gal' value=1<?=$val['ativa_gal']==1?' checked':null?>/> Mostrar galeria
    <br/><br/>
	</li>


	<li>	
	  <label>Nome *<span class='small'>Nome do estabelecimento</span></label>
	  <input type='text' name='titulo' id='titulo' class='required' value='<?=$val['titulo']?>'>
	</li>



  <?php

      if(empty($_SESSION['user']['tipo'])) {
  ?>
	<li>	
	  <label>Responsável *<span class='small'>Responsável pelo negócio</span></label>
    <select id='contato' name='contato' class='required'>
      <option>Selecione</option>
      <option value=0>Sem responsável</option>
      <?php


        $sql_adm = "SELECT adm_id, adm_nome FROM ".TABLE_PREFIX."_administrador
                      WHERE adm_status=1 AND adm_tipo='user'";

        if(!$qry_adm = $conn->prepare($sql_adm))
          echo $conn->error;

        else {

          $qry_adm->execute();
          $qry_adm->bind_result($id, $nome);

            while ($qry_adm->fetch()) {

             if ($act=='update') {
              $check[$id] = ($val['contato']==$id)?' selected':'';

              } else $check[$id] = '';
      ?>
	    <option value='<?=$id?>'<?=$check[$id]?>> <?=$nome?></option>
      <?php

        $i++;
        }
       $qry_adm->close();

       }

      ?>
    </select>
	
	</li>
  <?php

      } else {

        $sql_adm = "SELECT adm_nome, adm_email FROM ".TABLE_PREFIX."_administrador WHERE adm_id=?";
        if($qry_adm = $conn->prepare($sql_adm)) {

          $qry_adm->bind_param('i', $_SESSION['user']['id']);
          $qry_adm->execute();
          $qry_adm->bind_result($nome, $email);
          $qry_adm->fetch();
          $qry_adm->close();


        echo "<li><label>Responsável<span class='small'>Responsável pelo negócio</span></label>";
        echo "$nome - ".$email;
        echo "</li>";
        echo "<input type='hidden' name='contato' value={$_SESSION['user']['id']}>";

        }

      }

  ?>


	<li>	
	  <label>Site<span class='small'>URL do estabelecimento</span></label>
	  <input type='text' name='url' id='url' class='url' value='<?=$val['url']?>'>
	</li>


	<li>	
	  <label>CEP<span class='small'>CEP do estabelecimento</span></label>
	  <input type='text' name='cep' id='cep' value='<?=$val['cep']?>'>
	</li>


	<li>
	  <label>Endereço *<span class='small'>Endereço do estabelecimento, favor <b>não</b> colocar cidade e estado pois trata-se apenas de São Francisco</span></label>
	  <textarea name='endereco' id='endereco' class='tinymce required' cols='80' rows='7'><?=$val['endereco']?></textarea>
	</li>


	<li>
	  <label>Telefones<span class='small'>Telefones de contato do estabelecimento</span></label>
	  <textarea name='telefone' id='telefone' class='' cols='80' rows='3'><?=$val['telefone']?></textarea>
	</li>



	<li>
	  <label>Texto<span class='small'>Descritivo sobre o estabelecimento</span></label>
	  <textarea name='texto' id='texto' class='tinymce' cols='80' rows='15'><?=$val['texto']?></textarea>
	</li>


	<li>
	  <label>Algo mais<span class='small'>Serviços e vantagens</span></label>
	  <textarea name='algomais' id='algomais' class='tinymce' cols='80' rows='5'><?=$val['algomais']?></textarea>
	</li>


	<li>
	  <label>Mais informações<span class='small'>Eventos/Workshops ou extras</span></label>
	  <textarea name='maisinfo' id='maisinfo' class='tinymce' cols='80' rows='5'><?=$val['maisinfo']?></textarea>
	</li>


	<li>	
	  <label>Serviços *<span class='small'>Serviços disponíveis para o público</span></label>
	  <?php


		if($act=='insert')
		  $sql_categoria = "SELECT cat_id, 
                               cat_titulo
                               FROM ".TABLE_PREFIX."_categoria 
                               WHERE cat_status=1 AND cat_area='icoservico'";

		  else
			$sql_categoria = "SELECT cat_id, 
									 cat_titulo,
									 (SELECT COUNT(rls_id) FROM ".TABLE_PREFIX."_r_loc_servico WHERE rls_cat_id=cat_id and rls_loc_id='".$val['id']."') checked
									 
									  FROM ".TABLE_PREFIX."_categoria 
						        WHERE cat_status=1 AND cat_area='icoservico'";

	    $qry_categoria = $conn->prepare($sql_categoria);
	    $qry_categoria->execute();

		 if($act=='insert')
	       $qry_categoria->bind_result($id, $nome);

		   else $qry_categoria->bind_result($id, $nome, $checked);




	      $i=0;
	      while ($qry_categoria->fetch()) {

	       if ($act=='update') {
	        $check[$id] = ($checked>0)?' checked':''; 

	        } else $check[$id] = '';


	  ?>
    <span style='display:inline-block;width:200px;'><input type='checkbox' class='required' name='servico_id[]' id='servico_id' value='<?=$id?>'<?=$check[$id]?>> <?=$nome?></span>
	  <?php

	    $i++;
	    }
	   $qry_categoria->close();
	  ?>
	
	</li>


  <?php

    if(empty($_SESSION['user']['tipo'])) {

  ?>
	<li>	
	  <label>Destaque<span class='small'>Se será um destaque na listagem</span></label>
	  <input type='checkbox' name='destaque' id='destaque' value='1'<?=$val['destaque']==1 ? ' checked':''?>>
	</li>
  <?php

    } else echo "<input type='hidden' name='destaque' value='{$val['destaque']}'/>";
  ?>

 </ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>
