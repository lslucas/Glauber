<?php
 $res['ref'] = '_loc_id';
 $res['pre'] = 'rls';
 $res['prefix'] = 'r_loc_servico';
 $sql_field = 'rls'.$res['ref'];


 $sql_guarda = "SELECT ${res['pre']}_id id, $sql_field field FROM ".TABLE_PREFIX."_${res['prefix']} WHERE ${res['pre']}${res['ref']}=?";

 if($qry_guarda = $conn->prepare($sql_guarda)) {

   $qry_guarda->bind_param('i', $res['item']);
   $ok = $qry_guarda->execute()?true:false;
   $qry_guarda->store_result();
   $num = $qry_guarda->num_rows();
   $qry_guarda->close();


   if(isset($_GET['verifica'])) {

    echo $num;


    } elseif ($ok && $num>0) {

       $sql_rem = "DELETE FROM ".TABLE_PREFIX."_${res['prefix']} WHERE ${res['pre']}${res['ref']}=?";

       if($qry_rem = $conn->prepare($sql_rem)) {

         $qry_rem->bind_param('i',$res['item']);
         $qry_rem->execute();
         $qry_rem->close();

         echo "servegoria(s) apagada(s)!<br>";

       } else echo $conn->error;


   } else {
     echo "Não foi possível remover a servegoria!<br>";
   }



 } else echo $conn->error;
