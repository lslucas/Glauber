<?php

  foreach($_GET as $chave=>$valor) {
   $res[$chave] = $valor;
  }



 $sql_guarda = "SELECT ${var['pre']}_titulo FROM ".TABLE_PREFIX."_${var['path']} WHERE ${var['pre']}_id=?";

 if( !($qry_guarda = $conn->prepare($sql_guarda)) ) {
   echo $conn->error;

 } else {

   $qry_guarda->bind_param('i', $res['item']); 
   $ok = $qry_guarda->execute()==true?true:false;
   $num = $qry_guarda->num_rows();
   $qry_guarda->bind_result($nome);
   $qry_guarda->fetch();
   $qry_guarda->close();



   if(isset($_GET['verifica'])) {

    echo $num;


    } elseif ($ok) {


          $sql_rem = "DELETE FROM ".TABLE_PREFIX."_${var['path']} WHERE ${var['pre']}_id=?";
          if ( !($qry_rem = $conn->prepare($sql_rem)) ) {
            echo $conn->error;

          } else {

           $qry_rem->bind_param('i', $res['item']); 
           $qry_rem->execute();
           $qry_rem->close();


            echo "<b>${nome}</b> removido com êxito!<br>";

            # CASO EXISTA REMOVE AS IMAGENS E PDFS 

            if (file_exists($var['path'].'/mod.imagem.delete.php')) 
             include_once $var['path'].'/mod.imagem.delete.php';

            if (file_exists($var['path'].'/mod.categoria.delete.php')) 
             include_once $var['path'].'/mod.categoria.delete.php';


            if (file_exists($var['path'].'/mod.servico.delete.php')) 
             include_once $var['path'].'/mod.servico.delete.php';

          }



   } else {
     echo "Não foi possível remover <b>${nome}</b><br>";
   }


 }
