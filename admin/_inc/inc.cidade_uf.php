<?php

	$estado    = isset($_POST['estado']) ? $_POST['estado'] : 'SP';
	$cidade    = isset($_POST['cidade']) ? $_POST['cidade'] : '';


   include_once 'global.php';
   include_once 'db.php';
   include_once 'global_function.php';
   include_once $rp.'inc.auth.php';



	$sql = "SELECT cid_codigo, cid_municipio FROM ".TABLE_PREFIX."_cidade_uf WHERE cid_uf=? ORDER BY cid_municipio ASC";

   if($qry = $conn->prepare($sql)) {
    $qry->bind_param('s', $estado);
    $qry->bind_result($slt_codigo, $slt_cidade);
    $qry->execute();
    $qry->store_result();
    $num = $qry->num_rows;


      if ($num==0)
       die("<option value=''>Nenhum encontrado</option>\n");


        while($qry->fetch()) {

         echo "<option value='".$slt_codigo."'";

           if (!empty($cidade) && $cidade==$slt_codigo)
             echo ' selected';

         echo ">".($slt_cidade);
         echo "</option>\n";
        }



   } else echo $conn->error;
