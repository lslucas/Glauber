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


     $res['destaque'] = !isset($res['destaque']) ? 0 : 1;
     $res['ativa_gal'] = !isset($res['ativa_gal']) ? 0 : 1;
     $sql= "UPDATE ".TABLE_PREFIX."_${var['path']} SET

  		  ${var['pre']}_gal_id=?,
  		  ${var['pre']}_ativa_gal=?,
  		  ${var['pre']}_titulo=?,
  		  ${var['pre']}_contato=?,
  		  ${var['pre']}_telefone=?,
  		  ${var['pre']}_endereco=?,
  		  ${var['pre']}_cep=?,
  		  ${var['pre']}_url=?,
  		  ${var['pre']}_texto=?,
  		  ${var['pre']}_algomais=?,
  		  ${var['pre']}_maisinfo=?,
  		  ${var['pre']}_destaque=?
	";
     $sql.=" WHERE ${var['pre']}_id=?";
     $qry=$conn->prepare($sql);
     $qry->bind_param('iisssssssssii', $res['gal_id'], $res['ativa_gal'], $res['titulo'], $res['contato'], $res['telefone'], $res['endereco'], $res['cep'], $res['url'], txt_bbcode($res['texto']), txt_bbcode($res['algomais']), txt_bbcode($res['maisinfo']), $res['destaque'], $res['item']);
     $qry->execute();



    if ($qry==false) echo $msgExiste;
     else {


     $qry->close();


     #insere as fotos/galeria 
     include_once 'mod.exec.imagem.php';

    #insere a categorias
     include_once 'mod.exec.categoria.php';

    #insere os serviços
     include_once 'mod.exec.servico.php';


     echo $msgSucesso;

    }

 }
