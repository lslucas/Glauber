<?php

 if (isset($_POST['cat_id']) ) {


   /*
    *apaga todas as categorias do id atual
    */
   $sql_dcat = "DELETE FROM ".TABLE_PREFIX."_r_${var['pre']}_categoria WHERE rlc_${var['pre']}_id=?";

   if($qry_dcat = $conn->prepare($sql_dcat)) {

     $qry_dcat->bind_param('i', $res['item']);
     $qry_dcat->execute();
     $qry_dcat->close();

   } else echo $conn->error;



       /*
        *query que insere as categorias na base
        */
       $sql_cat= "INSERT INTO ".TABLE_PREFIX."_r_${var['pre']}_categoria
                  (rlc_${var['pre']}_id,
                   rlc_cat_id,
                   rlc_pos
                  )
                  VALUES (?, ?, ?)";
       if( !($qry_cat=$conn->prepare($sql_cat)) ) {
         echo $conn->error;

       } else {

         /*
          *for que pega cada categoria para adicionar
          */
         for ($i=0; $i<=count($_POST['cat_id']); $i++) {

             if ( isset($_POST['cat_id'][$i]) && !empty($_POST['cat_id'][$i]) ) {
               $qry_cat->bind_param('iii', $res['item'], $_POST['cat_id'][$i], $pos);
               $qry_cat->execute();
             }

         }

        $pos++;
        $qry_cat->close();

      }
}
