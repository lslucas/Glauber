<?php
 if (!isset($res)) {

  foreach($_GET as $chave=>$valor) {
   $res[$chave] = $valor;
  }
  $res['ref'] = '_id';

 } else {

  $res['ref'] = '_'.$var['pre'].'_id';

 }



 $sql_field = $res['pre'].'_'.$res['col'];
 $sql_guarda = "SELECT ${res['pre']}_id id, $sql_field field FROM ".TABLE_PREFIX."_${res['prefix']} WHERE ${res['pre']}${res['ref']}=?";

 if( ($qry_guarda = $conn->prepare($sql_guarda)) ) {

   $qry_guarda->bind_param('i',$res['item']);
   $ok = $qry_guarda->execute()?true:false;
   $qry_guarda->bind_result($id,$field);
   $num = $qry_guarda->num_rows();

     $row_id=$row_field='';
     while($qry_guarda->fetch()) {
      $row_id   .= $id.',';
      $row_field.= $field.',';
     }

    $row_id=substr($row_id,0,-1);
    $row['id'] = explode(',',$row_id);

    $row_field=substr($row_field,0,-1);
    $row['field'] = explode(',',$row_field);



   $qry_guarda->close();



   if(isset($_GET['verifica'])) {

    echo $num;


    } elseif ($ok) {

       $sql_rem = "DELETE FROM ".TABLE_PREFIX."_${res['prefix']} WHERE ${res['pre']}_id=?";

       if ( !($qry_rem = $conn->prepare($sql_rem)) ) {
         echo $conn->error();

       } else {


         #variaveis de contagem de arquivos apagados ou nao
         $apagado = $nao_apagado = $erro_apagar = 0;

         for($i=0;$i<count($row['id']);$i++) { 
          if (!empty($row['id'][$i])) {


                 $id  = $row['id'][$i];
                 $arq = $row['field'][$i];


             $qry_rem->bind_param('i',$id);
             $qry_rem->execute();


          if ($qry_rem) {

               $folder = explode(',',$res['folder']);
               for($j=0;$j<count($folder);$j++) {
                $arquivo = $folder[$j].'/'.$arq;

            if (!empty($folder[$j]) && is_file($arquivo)) {

             unlink($arquivo);
             $unlink_ok = 1;

            } else $unlink_no = 1;

               }

             if(isset($unlink_ok)) $apagado=$apagado+1;
             if(isset($unlink_no)) $nao_apagado = $nao_apagado+1;


          } else
            $erro_apagar = $erro_apagar+1;


        }
            } #fecha for 

            if($apagado==1)
             echo "imagem apagada!<br>";
             elseif($apagado>1) echo $apagado." imagens apagados!<br>";


            if($nao_apagado==1)
             echo "imagem <b>não</b> já não existe!<br>";
             elseif($nao_apagado>1) echo $nao_apagado." imagens já não existem!<br>";


            if($erro_apagar==1)
             echo "Erro ao tentar apagar!<br>";
             elseif($erro_apagar>1) echo $erro_apagar." erros ao tentar apagar!<br>";


           $qry_rem->close();



       }


   } else {
     echo "Não foi possível remover o arquivo!<br>";
   }




 } else echo $conn->error;
