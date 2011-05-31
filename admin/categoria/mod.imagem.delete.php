<?php

  foreach($_GET as $chave=>$valor) {
   $res[$chave] = $valor;
  }


 $nao_apagado = $apagado = $erro_apagar = '';

     /*
      *pega o nome da imagem
      */
     $sql_slt = "SELECT cat_imagem FROM ".TABLE_PREFIX."_categoria WHERE cat_id=?";
     if( !($qry_slt = $conn->prepare($sql_slt)) ) {

        echo $conn->error;

     } else {

       $qry_slt->bind_param('i',$res['item']);
       $qry_slt->bind_result($arq);
       $qry_slt->execute();
       $qry_slt->fetch();
       $qry_slt->close();

     }


     /*
      *remove imagem
      */
     $sql_rem = "UPDATE ".TABLE_PREFIX."_categoria SET cat_imagem=NULL WHERE cat_id=?";
     if( !($qry_rem = $conn->prepare($sql_rem)) ) {

        $erro_apagar = $erro_apagar+1;
        echo $conn->error;

     } else {

	   $qry_rem->bind_param('i',$res['item']);

        if(strpos($res['folder'], ',')!==false) {

           $folder = explode(',',$res['folder']);
           for($j=0;$j<count($folder);$j++) {
            $arquivo = $folder[$j].'/'.$arq;

              if (!empty($folder[$j]) && is_file($arquivo)) {
               unlink($arquivo);
               $unlink_ok = 1;

	             $qry_rem->execute();

              } else $unlink_no = 1;

           }

        } else {

            $arquivo = $res['folder'].'/'.$arq;

              if (!empty($res['folder']) && is_file($arquivo)) {
               unlink($arquivo);
               $unlink_ok = 1;

	             $qry_rem->execute();

              } else $unlink_no = 1;

        }


		   if(isset($unlink_ok)) $apagado=$apagado+1;
		   if(isset($unlink_no)) $nao_apagado = $nao_apagado+1;


		}


      if($apagado==1)
       echo "foto apagada!<br>";
       elseif($apagado>1) echo $apagado." fotos apagadas!<br>";


      if($nao_apagado==1)
       echo "foto <b>não</b> existe!<br>";
       elseif($nao_apagado>1) echo $nao_apagado." foto já não existem!<br>";


      if($erro_apagar==1)
       echo "Erro ao tentar apagar!<br>";
       elseif($erro_apagar>1) echo $erro_apagar." erros ao tentar apagar!<br>";


     $qry_rem->close();
