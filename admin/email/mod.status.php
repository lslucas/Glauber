<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = $valor;
  }


 if(!is_array($res['item']))
   $res['item'] = array($res['item']);



 foreach($res['item'] as $item) {


     $sql_guarda = "SELECT ${var['pre']}_email ,${var['pre']}_status FROM ${var['table']}";
     $sql_guarda.= " WHERE ${var['pre']}_id=?";

     if($qry_guarda = $conn->prepare($sql_guarda)) {

       $qry_guarda->bind_param('i', $item); 
       $ok = $qry_guarda->execute()==true?true:false;
       $num = $qry_guarda->num_rows();
       $qry_guarda->bind_result($nome,$status); 
       $qry_guarda->fetch(); 
       $qry_guarda->close();


       if ($ok || isset($res['acao'])) {


         if(isset($res['acao'])) {
          $novoStatus = $res['acao']=='ativar'?1:2;
          $novoStatusT = $res['acao']=='ativar'?'Ativo':'Pendente';

         } else {

          $novoStatus  = $status<>2?2:1;
          $novoStatusT = $status<>2?'Pendente':'Ativo';
         }


         $sql_status  = "UPDATE ${var['table']} SET ${var['pre']}_status=${novoStatus}";
         $sql_status .= " WHERE ${var['pre']}_id=?";
         $qry_status  = $conn->prepare($sql_status);
         $qry_status->bind_param('s', $item); 

           if ($qry_status->execute()) {
            echo "<b>${nome}</b> agora está <b>${novoStatusT}</b><br/>";
           }

         $qry_status->close();

       }



     } else echo 'ERROR: '.$conn->error;


  }
