<?php

 if (isset($_POST['servico_id']) ) {


   /*
    *apaga todas as servegorias do id atual
    */
   $sql_dserv = "DELETE FROM ".TABLE_PREFIX."_r_${var['pre']}_servico WHERE rls_${var['pre']}_id=?";

   if($qry_dserv = $conn->prepare($sql_dserv)) {

     $qry_dserv->bind_param('i', $res['item']);
     $qry_dserv->execute();
     $qry_dserv->close();

   } else echo $conn->error;



       /*
        *query que insere as servegorias na base
        */
       $sql_serv= "INSERT INTO ".TABLE_PREFIX."_r_${var['pre']}_servico
                  (rls_${var['pre']}_id,
                   rls_cat_id,
                   rls_pos
                  )
                  VALUES (?, ?, ?)";
       if( !($qry_serv=$conn->prepare($sql_serv)) ) {
         echo $conn->error;

       } else {

         /*
          *for que pega cada servegoria para adicionar
          */
         for ($i=0; $i<=count($_POST['servico_id']); $i++) {

             if ( isset($_POST['servico_id'][$i]) && !empty($_POST['servico_id'][$i]) ) {
               $qry_serv->bind_param('iii', $res['item'], $_POST['servico_id'][$i], $pos);
               $qry_serv->execute();
             }

         }

        $pos++;
        $qry_serv->close();

      }
}
