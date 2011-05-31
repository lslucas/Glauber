<?php


$sql = "SELECT 
		adm_id,
		adm_nome,
		adm_email,
		adm_status

	
	FROM ".TABLE_PREFIX."_${var['table']} 
	WHERE adm_email<>'lslucas@gmail.com' AND adm_tipo='user'
	";

 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->bind_result($id, $nome, $email, $status);
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>

<table class="list">
   <thead> 
      <tr>
        <th width="5px"></th>
        <th>Nome</th>
        <th>E-mail</th>
        <th width="90px"></th>
      </tr>
   </thead>
   <tbody>
<?php

    // Para cada resultado encontrado...
    while ($qry->fetch()) {


$row_actions = <<<end
<a href='?p=$p&delete&item=$id&noVisual' title="Clique para remover o ítem selecionado" class='tip trash' style="cursor:pointer;" id="${id}" name='$nome'>Remover</a> | <a href="?p=$p&update&item=$id" title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a>
end;

$row_actions .= "
 | <a href='?p=${p}&status&item=${id}&table=${var['table']}&noVisual' title='Clique para alterar o status do ítem selecionado' class='tip status status${id}' style='cursor:pointer;' id='${id}' name='${nome}'>";

  if ($status==1) 
    $row_actions .= '<font color="#000000">Ativo</font>'; 

    else $row_actions .= '<font color="#999999">Pendente</font>'; 

$row_actions .="</a>";

?>
      <tr id="tr<?=$id?>">
        <td></td>
        <td><?=$nome?><div class='row-actions'><?=$row_actions?></div></td>
        <td><?=$email?></td>
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
