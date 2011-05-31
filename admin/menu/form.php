<div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="modulo_id" class="error-validate">Selecione o módulo</label></li> 
		<li><label for="pai" class="error-validate">Informe o módulo pai</label></li> 
		<li><label for="nome" class="error-validate">Digite o nome do menu</label></li> 
		<li><label for="nivel" class="error-validate">Informe o peso do menu</label></li> 
	</ol> 
  </div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' class='form cmxform'>
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
	  if (!isset($_GET['pai'])) {
	?>

	<li>
	 <label>Módulo *<span class='small'>Módulo do novo ítem de menu</span></label>
	  <select name='modulo_id' id='modulo_id' class='required'>
	    <option value=''>Selecione</option>
	<?php

	  $sql_mod = "SELECT mod_id,mod_nome FROM ".TABLE_PREFIX."_modulo WHERE mod_status=1";
	  $qry_mod = $conn->prepare($sql_mod);
	  $qry_mod->bind_result($id, $nome);
	  $qry_mod->execute();
	 
    	  while ($qry_mod->fetch()) {
	?>
   	   <option value='<?=$id?>'<?php if ($act=='update' && $val['modulo_id']==$id) echo ' selected';?>> <?=$nome?></option>
	<?php } $qry_mod->close(); ?>
	  </select> 
	</li>


	<?php
	  } else {
	?>

	<li>
	 <label>Pai *<span class='small'>Selecione um módulo pai</span></label>
	  <select name='pai' id='pai' class='required'>
	    <option value=''>Selecione</option>
	<?php

	  $sql_mod = "SELECT men_id,(SELECT mod_nome FROM ".TABLE_PREFIX."_modulo WHERE men_modulo_id=mod_id) men_nome FROM ".TABLE_PREFIX."_menu WHERE men_status=1 AND men_modulo_id IS NOT NULL";
	  $qry_mod = $conn->prepare($sql_mod);
	  $qry_mod->bind_result($id, $nome);
	  $qry_mod->execute();
	 
    	  while ($qry_mod->fetch()) {
	?>
   	   <option value='<?=$id?>'<?php if ($act=='update' && $val['pai']==$id || isset($_GET['pai']) && $_GET['pai']==$id) echo ' selected';?>> <?=$nome?></option>
	<?php } $qry_mod->close(); ?>
	  </select> 
	</li>

	<?php
	  }
	?>


	<?php
	  if (isset($_GET['pai'])) {
	?>

	<li>	
	  <label>Nome *<span class='small'>Digite o nome</span></label>
	  <input type='text' name='nome' id='nome' class='required' value='<?=$val['nome']?>'>
	</li>

	<?php
	  }
	?>


	<li>
	 <label>Link<?php if (isset($_GET['pai'])) echo " *";?><span class='small'>Digite um link válido</span></label>
	 <input type='text' name='link'<?php if (isset($_GET['pai'])) echo " class='required'";?> value='<?=$val['link']?>'>
	</li>


	<?php
	  if (!isset($_GET['pai'])) {
	?>

	<li>	
	  <label>Peso *<span class='small'>Bloco de ítens na visualização</span></label>
	  <input type='text' name='nivel' id='nivel' class='required' value='<?=$val['nivel']?>'>
	</li>

	<?php
	  }
	?>


    </ol>

    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>


