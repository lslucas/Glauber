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
 $sql_guarda = "SELECT ${res['pre']}_id id,$sql_field field FROM ".TABLE_PREFIX."_${res['prefix']} WHERE ${res['pre']}${res['ref']}=?";
 $qry_guarda = $conn->prepare($sql_guarda);
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

/*
      if ($num==0)
       echo 'Arquivo já não existe!';

       else
	echo 'não removido';
*/
	echo $num;


  } elseif ($ok) {

     $sql_rem = "DELETE FROM ".TABLE_PREFIX."_${res['prefix']} WHERE ${res['pre']}_id=?";
     $qry_rem = $conn->prepare($sql_rem);


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
			}

		     }


		  echo "Arquivo removido com êxito!<br>";

		} else
		        echo "Erro ao apagar o arquivo!<br>";


	}
      } #fecha for 

     $qry_rem->close();



 } else {
   echo "Não foi possível remover o arquivo";
 }


?>
