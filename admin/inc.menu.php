  <nav>
     <ul id='menu-admin'>

     <?php

	$sql_niveis = "SELECT men_nivel 
			FROM ".TABLE_PREFIX."_menu 

			 WHERE men_status=1 
			 	AND men_nivel IS NOT NULL 
				AND EXISTS(SELECT null FROM ".TABLE_PREFIX."_r_adm_mod WHERE ram_adm_id=\"".$_SESSION['user']['id']."\" AND ram_mod_id=men_modulo_id)
				OR men_status=1
				AND men_nivel IS NOT NULL
				AND ".$_SESSION['user']['id']."=1
				AND men_tipo IS NULL

			  GROUP BY men_nivel 
			   ORDER BY men_nivel";
	$qry_niveis = $conn->query($sql_niveis);
	$i=0;

	while($nivel = $qry_niveis->fetch_assoc()) {


	  $sql_menu_pai = "SELECT men_id,
	  			  men_nome,
				  men_link,
				  men_tipo,
				  (SELECT mod_nome FROM ".TABLE_PREFIX."_modulo WHERE mod_id=men_modulo_id) modulo_nome 

				FROM ".TABLE_PREFIX."_menu 
				WHERE men_nivel=".$nivel['men_nivel']." 
				AND men_status=1 
				AND men_nome IS NOT NULL 
				AND EXISTS(SELECT null FROM ".TABLE_PREFIX."_r_adm_mod WHERE ram_adm_id=\"".$_SESSION['user']['id']."\" AND ram_mod_id=men_modulo_id)
				OR men_nivel=".$nivel['men_nivel']." 
				AND men_status=1 
				AND men_nome IS NOT NULL 
				AND ".$_SESSION['user']['id']."=1
				AND men_tipo IS NULL
				ORDER BY men_nome";
	  $qry_menu_pai = $conn->query($sql_menu_pai);
	  $j=0;



	    while ($row=$qry_menu_pai->fetch_assoc()){


	      $sql_menu_filho = "SELECT men_nome,men_link FROM ".TABLE_PREFIX."_menu WHERE men_pai=".$row['men_id'].' ORDER BY men_nome';
	      $qry_menu_filho = $conn->query($sql_menu_filho);
	      $class_menu=$has_submenu='';



		if ($qry_menu_filho->num_rows>0) { 

		  $class_menu =' has-submenu';
		  $has_submenu='<img src="images/arrow-up.png" border="0" class="arrow-menu up"><img src="images/arrow-down.png" border="0" class="arrow-menu down">';
	          $menu_pai = (!empty($row['men_nome'])) ? $row['men_nome'] : $row['modulo_nome'];

		} elseif (!empty($row['men_link'])) 

	          $menu_pai = (!empty($row['men_nome'])) ? '<a href="'.$row['men_link'].'">'.$row['men_nome'].'</a>' : '<a href="'.$row['men_link'].'">'.$row['modulo_nome'].'</a>';



		if ($j==0)
		  $class_menu.=' menu-top-first';



	 $hide_li='';
	 if($row['men_nome']=='Seu estabelecimento' && empty($_SESSION['user']['tipo'])) {
	  $hide_li = ' style="display:none;"';

	 } /*elseif($row['men_nome']=='Documentos') {
	  $class_menu.=' menu-top-first';
   }*/


	  echo "<li class='menu {$class_menu}'{$hide_li}><span>{$has_submenu}{$menu_pai}</span>";


    if ($qry_menu_filho->num_rows<>0)
		echo "<ul class='submenu'>";

    		while ($row_filho = $qry_menu_filho->fetch_assoc()){
         #if($row_filho['men_nome']=='Seu estabelecimento' && !is_null($_SERVER['user']['tipo']))
	       echo "<li class='{$hide_li}'><a href='".$row_filho['men_link']."'>".$row_filho['men_nome']."</a></li>";
		    }

	      if ($qry_menu_filho->num_rows<>0)
      		echo "</ul>";

	   ?>

       </li>

       <?php

       		$j++;
	        $qry_menu_filho->close();
		}

	       $qry_menu_pai->close();

	   $i++;
	   if ($i<>0 && $i<$qry_niveis->num_rows) {
	     echo "       <li class='separator'></li>";
	     $j=0;
	   }

	 } 

	 $qry_niveis->close();
	?>
     </ul>
   </nav>

