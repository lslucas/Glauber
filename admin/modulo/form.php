  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="nome" class="error-validate">Informe o nome</label></li> 
		<li><label for="nome_singular" class="error-validate">Informe o singular de "nome"</label></li> 
		<li><label for="nome_plural" class="error-validate">Informe o plural de "nome"</label></li> 
		<li><label for="genero" class="error-validate">Informe o gênero de "nome"</label></li> 
		<li><label for="path" class="error-validate">Entre com o diretório do módulo</label></li> 
		<li><label for="pre" class="error-validate">Entre com o prefixo ou abreviação do módulo</label></li> 
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
<p class='header'>Todos os campos com <b>- * -</b> são obrigatórios.</p>

    <ol>
	<li>	
	    <label>Nome *<span class='small'>Digite o nome</span></label>
	    <input type='text' name='nome' id='nome' class='required' value='<?=$val['nome']?>'>
	</li>

	<li>
	  <label>Nome Singular *<span class='small'>Nome do módulo em singular</span></label>
	  <input type='text' name='nome_singular' id='nome_singular' class='required' value='<?=$val['nome_singular']?>'>
	</li>

	<li>
	  <label>Nome Plural *<span class='small'>Nome do módulo em plural</span></label>
	  <input type='text' name='nome_plural' id='nome_plural' class='required' value='<?=$val['nome_plural']?>'>
	</li>

	<li>
	  <label>Genero *<span class='small'>Gênero do módulo, exe: nov<b>o</b> "Menu" ou nov<b>a</b> "Roda"</span></label>
	  <input type='text' name='genero' id='genero' class='required' value='<?=$val['genero']?>'>
	  <br>&nbsp;
	</li>

	<li>
	  <label>Pasta *<span class='small'>Pasta onde está instalado o módulo, exe: <b>modulo</b></span></label>
	  <input type='text' name='path' id='path' class='required' value='<?=$val['path']?>'>
	  <br>&nbsp;
	</li>

	<li>
	  <label>Prefixo *<span class='small'>Prefixo para uso na tabela de banco de dados</span></label>
	  <input type='text' name='pre' id='pre' class='required' value='<?=$val['pre']?>'>
	  <br>&nbsp;
	</li>

	<li>
	  <label>Ícone<span class='small'>Ícone do módulo da pasta images</span></label>
	  <input type='text' name='icone' id='icone' value='<?=$val['icone']?>'>
	</li>

	<li>
	  <label>Visível? *<span class='small'>Se o módulo será visivel no menu</span></label>
	  <select name='display' id='display'>
	    <option value='1'<?php if ($act=='update' && $val['display']==1) echo ' selected';?>>Sim</option>
	    <option value='0'<?php if ($act=='update' && $val['display']==0) echo ' selected';?>>Não</option>
	  </select>
	</li>



    </ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>


