<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title><?=$pg_title?></title>
    <meta charset="UTF-8" />
    <!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> -->

    <meta name="description" content="admin <?=SITE_NAME?>" />
    <meta name="keywords" content="admin html5 css tableless" />
    <meta name="autors" content="Lucas Serafim, lslucas@gmail.com" />
    
    <!-- STYLESHEETS -->
    <?php 

	if (isset($def_include_css)) 
	 echo $def_include_css; 

	if (isset($include_css)) 
	 echo $include_css;

     ?>
    
   
    <!-- JQUERY -->
    <?php 

	if (isset($def_include_js)) 
	 echo $def_include_js; 

	if (isset($include_js)) 
	 echo $include_js;

     ?>
   
</head>

<body>
 <!-- CABECALHO -->


 <header>

       <a href='<?=$rp?>index.php' class='tip logo' title='Voltar para home'><!--<?=SITE_ADMLOGO?>--><?=SITE_NAME?></a>
       <?php if (isset($isSearch)) {?>
       <!-- SEARCH FORM -->
       <!-- SE FOR SETADO isSearch mostra o form de busca -->
       <form name='searchform' id='searchform' action='search.php'>
	 <input type='text' name='search' id='search' class='tip header_search' title='Digite um termo para a busca e tecle [enter]' value='busca'>
       </form>
       <!-- //SEARCH FORM -->
       <?php } ?>

        <?php 
          if (isset($_SESSION['user'])) { 

            $user_p_update = empty($_SESSION['user']['tipo'])?'administrador':'usuario';
	?>
       <span class='wellcome'>Olá, <a href='<?=$rp?>?p=<?=$user_p_update?>&update&item=<?=$_SESSION['user']['id']?>' class='tip' title='Clique para editar informações ou alterar senha'><?=$_SESSION['user']['nome']?></a> | <a href='<?=$rp?>index.php?logout' title='Sair da administração' class='tip'>Log Out</a><span>
       <?php } ?>

 </header>
 <!-- //CABECALHO -->



  <?php
   if ($noMenu==0) {

    include_once 'inc.menu.php';

   }
   ?>
 <!-- CONTAINER -->
 <div class='container'>

 <!-- subCONTAINER 
 <div class='subcontainer'>
-->

