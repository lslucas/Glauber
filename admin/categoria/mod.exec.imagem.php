<?php

 if (isset($_FILES)) {

  include_once "_inc/class.upload.php";



  if (isset($_FILES['imagem']['name']) && is_file($_FILES['imagem']['tmp_name']) ) {


	 $filename = $res['item'].'_'.rand();
	 $handle = new Upload($_FILES['imagem']);

     // then we check if the file has been uploaded properly
     // in its *temporary* location in the server (often, it is /tmp)
     if ($handle->uploaded) {

       $handle->file_new_name_body  = $filename;
       $handle->image_resize        = true;
       #$handle->image_ratio_x        = true;
       $handle->image_ratio_crop    = true;
       $handle->image_x             = $var['imagemWidth'];
       $handle->image_y             = $var['imagemHeight'];
       $handle->process($var['path_imagem']);
       if (!$handle->processed) echo 'error : ' . $handle->error;

       $imagem = $handle->file_dst_name;

         $sql_img = "UPDATE ".TABLE_PREFIX."_categoria SET cat_imagem=? WHERE cat_id=?";
         if( !($qry_img = $conn->prepare($sql_img)) ) {

           echo $conn->error;

         } else {

           $qry_img->bind_param('si', $imagem, $res['item']);
           $qry_img->execute();
           $qry_img->close();
         }


     }


  }


}
