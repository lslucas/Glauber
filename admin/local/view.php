<?php 
  if(isset($_GET['noMenu'])) 
  	echo '<div style="padding:20px;">';
?>

<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>
<?php

# id da pergunta pai
$item = $_GET['item'];


 $sql_cat = "SELECT rnc_not_id, 
		   (SELECT cat_titulo 
			   FROM ".TABLE_PREFIX."_categoria 
			   WHERE cat_id=rnc_cat_id) 
	   
		FROM ".TABLE_PREFIX."_r_not_categoria WHERE rnc_not_id=?
	    ";

 if (!$qry_cat = $conn->prepare($sql_cat)) {
   echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql_cat.'</p><hr>';
   $categoria[$id] = 'Sem categoria';

  } else {

    $qry_cat->bind_param('i', $item); 
    $qry_cat->execute();
    $qry_cat->bind_result($adm_id, $cat);
    $categoria = '';
    

   while($qry_cat->fetch()) {

	if(!isset($categoria))
	 $categoria = $cat;

	  else 
	    $categoria .= ', '.$cat;

       }

    $qry_cat->close();

   } 





/*
 *query das perguntas pais
 */
$sql = "SELECT  ${var['pre']}_id,
		${var['pre']}_titulo,
		${var['pre']}_texto,
		${var['pre']}_status,
		${var['pre']}_data data_en,
		DATE_FORMAT(${var['pre']}_data,'%d/%m/%Y') data,
		(SELECT rni_imagem FROM ".TABLE_PREFIX."_r_${var['pre']}_imagem WHERE rni_${var['pre']}_id=${var['pre']}_id ORDER BY rni_pos ASC LIMIT 1) imagem 
		
		FROM ".TABLE_PREFIX."_${var['path']} 
		WHERE ${var['pre']}_id=?
		ORDER BY ${var['pre']}_data DESC";

  if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';
  echo $conn->error;

  } else {
   $qry->bind_param('i', $item);
   $qry->execute();
   $qry->store_result();
   $qry->bind_result($id, $titulo, $texto, $status, $data_en, $data, $imagem);
   $num = $qry->num_rows;
   $qry->fetch();
   $qry->close();
?>

  <div align='right'>

	  <?php if(!isset($_GET['noMenu'])) { ?>
		  <a href='index.php' title="Voltar para listagem" class="tip">Voltar para listagem</a> 
		  - <a href='?p=<?=$p?>&view&item=<?=$item?>&noMenu=1' title="Imprimir" class="tip" target='_blank'>Imprimir</a>

	  <?php } else { ?>
		  <a href='javascript:window.print();' title="Imprimir" class="tip">Imprimir</a>
		  - <a href='javascript:window.close();' title="Imprimir" class="tip">Fechar</a>
		  <script>window.print();</script>
	  <?php } ?>

  </div>

  <h4><?=$titulo?></h4>
  <br/><h6><?=$data?></h6>

  <br clear='all'/>
  <br/>
  <p>
  <?php 

    $arquivo = $var['path_imagem'].'/'.$imagem;
    if(!empty($imagem) && file_exists($arquivo)) 
      echo '<p align="center"><img src="'.$arquivo.'" border=0 hspace=10 vspace=10></p>';
  ?>
  <br/>
  <?=nl2br($texto)?></p>

<?php 

  }

?>

<?php 
  if(isset($_GET['noMenu'])) 
  	echo '</div>';
?>


