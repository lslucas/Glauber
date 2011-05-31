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


     $res['data'] = datept2en($res['data']);
     $res['area'] = substr($res['idrel'], 0, 3);
     $res['idrel'] = (int) substr($res['idrel'], 3);
     $sql= "UPDATE ".TABLE_PREFIX."_${var['path']} SET

  		  ${var['pre']}_idrel=?,
  		  ${var['pre']}_area=?,
  		  ${var['pre']}_titulo=?,
  		  ${var['pre']}_data=?,
  		  ${var['pre']}_texto=?,
  		  ${var['pre']}_url=?
          ";
     $sql.=" WHERE ${var['pre']}_id=?";

     if( !($qry=$conn->prepare($sql)) ) {
       echo $conn->error;

     } else {


       $qry->bind_param('isssssi', $res['idrel'], $res['area'], $res['titulo'],
                                   $res['data'], txt_bbcode($res['texto']),
                                   $res['url'], $res['item']);
       $qry->execute();


       if ($qry==false) echo $msgExiste;
        else {

         $qry->close();

         echo $msgSucesso;
         #insere as fotos/galeria do artigo
         include_once 'mod.exec.imagem.php';

        }

     }



 }
