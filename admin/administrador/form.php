  <div class='error container-error'><div class='error-icon'>Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="nome" class="error-validate">Informe o nome</label></li> 
		<li><label for="email" class="error-validate">Entre com um e-mail válido</label></li> 
		<li><label for="mod_id" class="error-validate">Selecione ao menos um módulo</label></li> 
	</ol> 
  </div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' class='form cmxform'>
 <input type='hidden' name='act' value='insert'>
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
<p class='header'>Administradores controlaram as áreas cujas quais possuem acesso dentro do painel de administração. Todos os campos com <b>- * -</b> são obrigatórios.</p>

<?php
 if ($act=='update' &&  $_GET['item']==$_SESSION['user']['id']) {
?>

  <div class='notice'><div class='notice-icon'>Para alterar sua senha <a href='<?=$rp?>?p=<?=$p?>&alterasenha'>clique aqui</a>.</div></div>

<?php } ?>


    <ol>
	<li>	
	  <label>Nome *<span class='small'>Digite o nome</span></label>
	  <input type='text' placeholder='Nome' name='nome' id='nome' class='required' value='<?=$val['nome']?>'>
	</li>

	<li>
	  <label>E-mail *<span class='small'>Digite um e-mail válido</span></label>
	  <input type='text' placeholder='E-mail' name='email' id='email' class='email required' value='<?=$val['email']?>'>
	</li>

	<li>
	<label>Módulos com acesso *<span class='small'>Selecione apenas os módulos cujos quais o administrador terá acesso</span></label>
	  <?php

	   if ($act=='insert') {
	    $sql_mod = "SELECT mod_id,mod_nome FROM ".TABLE_PREFIX."_modulo WHERE mod_status=1 AND mod_private=0";
	    $qry_mod = $conn->prepare($sql_mod);
	    $qry_mod->bind_result($id, $nome);

	    } else {
	     $sql_mod = "SELECT mod_id,mod_nome,(SELECT COUNT(ram_id) FROM ".TABLE_PREFIX."_r_adm_mod WHERE ram_mod_id=mod_id and ram_adm_id=".$val['id'].") checked FROM ".TABLE_PREFIX."_modulo WHERE mod_status=1 AND mod_private=0";
	    $qry_mod = $conn->prepare($sql_mod);
	    $qry_mod->bind_result($id, $nome,$checked);
	   }


	   $qry_mod->execute();
	   
	   $i=0;
	   while ($qry_mod->fetch()) {

	    if ($act=='update') {
	      $check[$id] = ($checked>0)?' checked':''; 

	    } else $check[$id] = '';


	    if ($i<>0) echo '<br>';
	  ?>
	   <input type='checkbox' class='required' name='mod_id[]' id='mod_id' value='<?=$id?>'<?=$check[$id]?>> <?=$nome?> 
	  <?php $i++;} $qry_mod->close(); ?>
	   
	</li>



    </ol>


        <div class='spacer'></div>

	<?php
	 if ($act=='insert') {
	?>

	<div class='notice'><span class='notice-icon'><b>Atenção:</b> A senha será gerada automaticamente e enviada para o e-mail do novo administrador.</span></div>

	<?php 
	 }
	?>


    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>


