<?php

$sql = "SELECT  ${var['pre']}_id,
		${var['pre']}_titulo,
		${var['pre']}_contato,
		${var['pre']}_status,
		${var['pre']}_data_inicio data_inicio_en,
		${var['pre']}_data_termino data_termino_en,
		DATE_FORMAT(${var['pre']}_data_inicio,'%d/%m/%y') data_inicio,
		DATE_FORMAT(${var['pre']}_data_termino,'%d/%m/%y') data_termino
		
		FROM ".TABLE_PREFIX."_${var['path']}
		ORDER BY ${var['pre']}_data_inicio DESC";


 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';
  echo $conn->error;

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->bind_result($id, $nome, $contato, $status, $data_inicio_en, $data_termino_en, $data_inicio, $data_termino);
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>


<table class="list">
   <thead> 
      <tr>
        <th width="250px">Contato</th>
        <th>Título</th>
      </tr>
   </thead>  
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {
$row_actions = <<<end
<a href='?p=$p&delete&item=$id&noVisual' title="Clique para remover o ítem selecionado" class='tip trash' style="cursor:pointer;" id="${id}" name='$nome'>Remover</a> | <a href="?p=$p&update&item=$id" title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a>
end;

$row_actions .= <<<end
 | <a href="?p=${p}&status&item=${id}&noVisual" title="Clique para alterar o status do ítem selecionado" class="tip status status${id}" style="cursor:pointer;" id="${id}" name="${nome}">
end;

   if ($status==1)
     $row_actions .= '<font color="#000000">Ativo</font>'; 
     
     else $row_actions .= '<font color="#999999">Pendente</font>';


$row_actions .= '</a>';



$permissoes='';
?>
      <tr id="tr<?=$id?>">

        <td><?=$contato?></td>
        <td>
	
	<?=$nome?>
        <br/><i class='min'>
        <?php

          if(!empty($data_termino))
            echo 'De '.$data_inicio.' até '.$data_termino;

           else echo 'Dia '.$data_inicio;

        ?>
        </i>
	<div class='row-actions'><?=$row_actions?></div></td>

      </tr>



<?php
     $j++;
    }

    $qry->close();
?>
    </tbody>
    </table>
<?php

    }
?>
