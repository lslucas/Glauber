  <div class='error container-error'><div class='error-icon'>Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol>
		<li><label for="nome" class="error-validate">Informe o nome</label></li> 
		<li><label for="email" class="error-validate">Entre com um e-mail válido</label></li> 
	</ol>
  </div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' class='form cmxform'>
  <input type='hidden' name='act' value='<?=$act?>'>
  <input type='hidden' name='mod_id[]' value='26'>


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

<?php
 if ($act=='update' &&  $_GET['item']==$_SESSION['user']['id']) {
?>

  <div class='notice'><div class='notice-icon'>Para alterar sua senha <a href='<?=$rp?>?p=<?=$p?>&alterasenha'>clique aqui</a>.</div></div>

<?php } ?>


    <ol>
	<li>	
	  <label>Nome *<span class='small'>Digite o nome</span></label>
	  <input type='text' placeholder='Preencha o nome' name='nome' id='nome' class='required' value='<?=$val['nome']?>'>
	</li>

	<li>
	  <label>E-mail *<span class='small'>Digite um e-mail válido</span></label>
	  <input type='text' placeholder='Entre com um e-mail válido' name='email' id='email' class='email required' value='<?=$val['email']?>'>
	</li>


  </ol>


        <div class='spacer'></div>

	<?php
	 if ($act=='insert') {
	?>

	<div class='notice'><span class='notice-icon'><b>Atenção:</b> A senha será gerada automaticamente e enviada para o e-mail do novo usuário.</span></div>

	<?php 
	 }
	?>


    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>


