<?php

 $idsCat = $idsLoc = null;
 $whereCat = " cat_status=1 AND cat_area='local' ";
 $whereLoc = isset($_GET['cat']) && !empty($_GET['cat']) ? ' rlc_cat_id='.$_GET['cat'] : null;


 if(!empty($_SESSION['user']['tipo'])) {

     $sql_l = "SELECT  loc_id FROM ".TABLE_PREFIX."_local WHERE loc_contato=? ORDER BY loc_titulo ASC";
     if (!$qry_l = $conn->prepare($sql_l)) {
      echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql_l.'</p><hr>';
      echo $conn->error;

     } else {

       $qry_l->bind_param('s', $_SESSION['user']['id']);
       $qry_l->bind_result($id);
       $qry_l->execute();
       $qry_l->store_result();
       $num = $qry_l->num_rows;


         while($qry_l->fetch()) {
           $idsCat .= !empty($whereCat) ? $whereCat.' AND ' : null;
           $idsCat .=  " EXISTS(SELECT null FROM ".TABLE_PREFIX."_r_loc_categoria WHERE rlc_cat_id=cat_id AND rlc_loc_id=".$id.") OR ";

           $idsLoc .= !empty($whereLoc) ? $whereLoc." AND " : null;
           $idsLoc .= empty($where) ? " loc_id={$id} OR " : $where." AND loc_id={$id} OR ";
         }


       if(!empty($idsCat))
       $whereCat = 'WHERE '.substr($idsCat, 0, -4);

       if(!empty($idsLoc))
       $where    = 'WHERE '.substr($idsLoc, 0, -4);

     }
 }


 if($num==0 && !empty($_SESSION['user']['tipo']))
   echo 'Você não possui nenhum estabelecimento';


 else {


   $whereCat = !isset($idsCat) ? ' WHERE '.$whereCat : $whereCat;
   $sql_cat = "SELECT  cat_id, cat_titulo FROM ".TABLE_PREFIX."_categoria $whereCat ORDER BY cat_titulo ASC";
   if (!$qry_cat = $conn->prepare($sql_cat)) {
    echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql_cat.'</p><hr>';
    echo $conn->error;

    } else {

      $qry_cat->execute();
      $qry_cat->bind_result($cat_id, $cat_titulo);
      $i=0;
      $categorias='';

      while($qry_cat->fetch()) {

        if($i==0) {
          if(isset($_GET['cat']) && !empty($_GET['cat']))
          $categorias .= "<a href='?p=".$var['path']."'>";
          $categorias .= "Todas";
          if(isset($_GET['cat']) && !empty($_GET['cat']))
          $categorias .= "</a>";
        }

        $categorias .= " - ";

        if(isset($_GET['cat']) && $_GET['cat']<>$cat_id || !isset($_GET['cat']))
        $categorias .= "<a href='?p=".$var['path']."&cat=".$cat_id."'>";
        $categorias .= $cat_titulo;
        if(isset($_GET['cat']) && $_GET['cat']<>$cat_id || !isset($_GET['cat']))
        $categorias .= "</a>";

        $i++;
      }

    }



  $sql = "SELECT  ${var['pre']}_id,
      ${var['pre']}_titulo,
      ${var['pre']}_contato,
      (SELECT adm_nome FROM ".TABLE_PREFIX."_administrador WHERE adm_id=${var['pre']}_contato) contato_nome,
      ${var['pre']}_endereco,
      ${var['pre']}_status,
      ${var['pre']}_gal_id,
      DATE_FORMAT(${var['pre']}_timestamp,'%d/%m/%y') data_cadastro,
      (SELECT rli_imagem FROM ".TABLE_PREFIX."_r_${var['pre']}_imagem WHERE rli_${var['pre']}_id=${var['pre']}_id ORDER BY rli_pos ASC LIMIT 1) imagem
      
      FROM ".TABLE_PREFIX."_${var['path']}
      INNER JOIN ".TABLE_PREFIX."_r_loc_categoria
      ON rlc_loc_id=${var['pre']}_id

      $where
      GROUP BY ${var['pre']}_id

      ORDER BY ${var['pre']}_titulo ASC";
   if (!$qry = $conn->prepare($sql)) {
    echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';
    echo $conn->error;

    } else {

      $qry->execute();
      $qry->bind_result($id, $titulo, $id_contato, $contato, $endereco, $status, $gal_id, $data_cadastro, $imagem);
  ?>
  <h1><?=$var['mono_plural']?></h1>
  <p class='header'></p>

  <?php
    echo $categorias;
  ?>

  <table class="list">
     <thead>
        <tr>
          <th width="70px">Cadastro</th>
          <th width="200px">Título</th>
          <th>Endereço</th>
          <th width="20px">Fotos</th>
        </tr>
     </thead>
     <tbody>
  <?php

      $j=0;
      // Para cada resultado encontrado...
      while ($qry->fetch()) {


      $row_actions = null;
      if(empty($_SESSION['user']['tipo'])) {

        $delete_images = "&prefix=r_${var['pre']}_imagem&pre=rli&col=imagem&folder=${var['imagem_folderlist']}";
        $row_actions = "<a href='?p=$p&delete&item=$id&$delete_images&noVisual' title='Clique para remover o ítem selecionado' class='tip trash' style='cursor:pointer;' id='${id}' name='$titulo'>Remover</a> | ";

      }


      $row_actions .= "<a href='?p=$p&update&item=$id' title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a> | ";


      if(empty($_SESSION['user']['tipo'])) {

        $row_actions .= "<a href='?p=${p}&status&item=${id}&noVisual' title='Clique para alterar o status do ítem selecionado' class='tip status status${id}' style='cursor:pointer;' id='${id}' name='${titulo}'>";

      }
           if ($status==1)
             $row_actions .= '<font color="#000000">Ativo</font>'; 
           else $row_actions .= '<font color="#999999">Pendente</font>';


      if(empty($_SESSION['user']['tipo'])) {
        $row_actions .= '</a>';
      }


  ?>
        <tr id="tr<?=$id?>">

          <td><?=$data_cadastro?></td>
          <td><?=$titulo?><br/><i class='min'>
          <?php

            if(!empty($contato) && $contato!==0)
              echo $contato;

            else echo '--';
          ?>
          </i>
          <div class='row-actions'><?=$row_actions?></div></td>
          <td><?=$endereco?></td>
          <td><center><?=is_null($gal_id) || empty($gal_id) ?'não':'sim'?></center></td>

        </tr>



  <?php
       $j++;
      }

      $qry->close();
  ?>
      </tbody>
      </table>
  <?php

      }

   }
  ?>
