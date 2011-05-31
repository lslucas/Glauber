<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = $valor;
  }

 if(!is_array($res['item']))
   $res['item'] = array($res['item']);



 $sql_guarda = "SELECT ${var['pre']}_email FROM ${var['table']} WHERE ${var['pre']}_id=?";
 if(!($qry_guarda = $conn->prepare($sql_guarda))) {
   echo "ERRO: ".$conn->error;

  } else {

     $qry_guarda->bind_param('i', $item);

        foreach($res['item'] as $item) {
           $qry_guarda->execute()==true?true:false;

        }

     $qry_guarda->store_result();
     $num = $qry_guarda->num_rows;
     $qry_guarda->bind_result($nome); 
     $qry_guarda->fetch(); 
     $qry_guarda->close();



     if(isset($_GET['verifica'])) {
       echo $num;


      } elseif ($num>0) {




       foreach($res['item'] as $item) {


            $sql_rem = "DELETE FROM ${var['table']} WHERE ${var['pre']}_id=?";

            if($qry_rem = $conn->prepare($sql_rem)) {


                $qry_rem->bind_param('i', $item); 
                if ($qry_rem->execute()) {
                  echo "<b>${nome}</b> removido! ";


                  # CASO EXISTA REMOVE AS IMAGENS E PDFS 
                  if (file_exists($var['path'].'/mod.cat-interesse.delete.php')) 
                   include $var['path'].'/mod.cat-interesse.delete.php';

                }

                $qry_rem->close();
            }


       }


     } else echo "ID inválido<br>";


 }
