<?php

$sql = "SELECT  adm_id,
		adm_nome,
		adm_email,
		adm_status 
	
	  FROM ".TABLE_PREFIX."_${var['path']} 
	  WHERE ${var['pre']}_email<>'lslucas@gmail.com' AND ${var['pre']}_tipo IS NULL";


 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->bind_result($id, $nome, $email,$status);
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>

<!--
<select name='actions' class='min'>
  <option value=''>Ações</option>
  <option value='remove'>Remover</option>
  <option value='on'>Ativar</option>
  <option value='off'>Desativar</option>
</select>
<input type='button' value='aplicar' class='min'>
-->
<table class="list">
   <thead> 
      <tr>
 <!--       <th width="5px"><input type='checkbox' name='check-all' value='1'></th>-->
        <th>Nome</th>
        <th>E-mail</th>
        <th width="90px"></th>
        <th width="55px"></th>
      </tr>
   </thead>  
   <tbody>
<?php

    // Para cada resultado encontrado...
    while ($qry->fetch()) {
# | <a href='$base/$p?item=$id' title="Veja no site" class='tip view' style="cursor:pointer;">Ver</a>
$delete_modulos = "&prefix=r_${var['pre']}_mod&pre=ram&col=adm_id";
$row_actions = <<<end
<a href='?p=$p&delete&item=$id${delete_modulos}&noVisual' title="Clique para remover o ítem selecionado" class='tip trash' style="cursor:pointer;" id="${id}" name='$nome'>Remover</a> | <a href="?p=$p&update&item=$id" title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a>
end;
$permissoes='';
?>
      <tr id="tr<?=$id?>">
 <!--       <td><input type='checkbox' name='check' value='1'></td>-->
        <td><?=$nome?><div class='row-actions'><?=$row_actions?></div></td>
        <td><?=$email?></td>
        <td><?=$permissoes?></td>
        <td align='center'><a href='?p=<?=$p?>&status&item=<?=$id?>&noVisual' title="Clique para alterar o status do ítem selecionado" class='tip status status<?=$id?>' style="cursor:pointer;" id="<?=$id?>" name='<?=$nome?>'><?php if ($status==1) echo'<font color="#000000">Ativo</font>'; else echo '<font color="#999999">Pendente</font>'; ?></a></td>
      </tr>


<?php
    }

    $qry->close();
?>
    </tbody>
    </table>

<?php

  }
?>

