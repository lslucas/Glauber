<?php

$sql = "SELECT  ${var['pre']}_id,
		${var['pre']}_titulo,
		${var['pre']}_texto,
		${var['pre']}_status,
		${var['pre']}_data data_en,
		DATE_FORMAT(${var['pre']}_data,'%d/%m/%y') data
		
		FROM ".TABLE_PREFIX."_${var['path']}
		ORDER BY ${var['pre']}_data DESC";


 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';
  echo $conn->error;

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->store_result();
    $qry->bind_result($id, $titulo, $texto, $status, $data_en, $data);
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>


<table class="list">
   <thead> 
      <tr>
        <th width="250px">Título</th>
        <th>Texto</th>
      </tr>
   </thead>  
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {

$delete_images = "&prefix=r_${var['pre']}_imagem&pre=rdi&col=imagem&folder=${var['imagem_folderlist']}";
$row_actions = <<<end
<a href='?p=$p&delete&item=$id${delete_images}&noVisual' title="Clique para remover o ítem selecionado" class='tip trash' style="cursor:pointer;" id="${id}" name='$titulo'>Remover</a> | <a href="?p=$p&update&item=$id" title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a>
end;

$row_actions .= <<<end
 | <a href="?p=${p}&status&item=${id}&noVisual" title="Clique para alterar o status do ítem selecionado" class="tip status status${id}" style="cursor:pointer;" id="${id}" name="${titulo}">
end;

   if ($status==1)
     $row_actions .= '<font color="#000000">Ativo</font>';

     else $row_actions .= '<font color="#999999">Pendente</font>';


$row_actions .= '</a>';

?>

      <tr id="tr<?=$id?>">

        <td><?=$titulo?>
        <br/><?=$data?>
      	<div class='row-actions'><?=$row_actions?></div>
        </td>
        <td><?=$texto?></td>
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
