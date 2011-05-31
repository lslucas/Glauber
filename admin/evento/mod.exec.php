<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = $valor;
  }


# include de mensagens do arquivo atual
 include_once 'inc.exec.msg.php';


 ## verifica se existe um titulo/nome/email com o mesmo nome do que esta sendo inserido
 $sql_valida = "SELECT ${var['pre']}_titulo FROM ".TABLE_PREFIX."_${var['path']} WHERE ${var['pre']}_titulo=?";
 $qry_valida = $conn->prepare($sql_valida);
 $qry_valida->bind_param('s', $res['titulo']); 
 $qry_valida->execute();
 $qry_valida->store_result();

  #se existe um titulo/nome/email assim nao passa
  if ($qry_valida->num_rows<>0 && $act=='insert') {
   echo $msgDuplicado;
   $qry_valida->close();


  #se nao existe faz a inserção
  } else {

     #autoinsert
     include_once $rp.'inc.autoinsert.php';


     $res['data_inicio'] = datept2en($res['data_inicio']);
     $res['data_termino'] = datept2en($res['data_termino']);
     $sql= "UPDATE ".TABLE_PREFIX."_${var['path']} SET

  		  ${var['pre']}_gal_id=?,
  		  ${var['pre']}_titulo=?,
  		  ${var['pre']}_data_inicio=?,
  		  ${var['pre']}_data_termino=?,
  		  ${var['pre']}_contato=?,
  		  ${var['pre']}_local=?,
  		  ${var['pre']}_texto=?,
  		  ${var['pre']}_url=?
	";
     $sql.=" WHERE ${var['pre']}_id=?";
     $qry=$conn->prepare($sql);
     $qry->bind_param('isssssssi', $res['gal_id'], $res['titulo'], $res['data_inicio'], $res['data_termino'], $res['contato'], txt_bbcode($res['local']), txt_bbcode($res['texto']), $res['url'], $res['item']); 
     $qry->execute();


   if ($qry==false) echo $msgExiste;
    else {

     $qry->close();

     echo $msgSucesso;

    }

 }
