<?php
 #defini maximo de memoria permitida
 ini_set("memory_limit","128M");
 #define o charset padrão do php
 ini_set('default_charset','utf-8'); 
 #define o horario padrao
 date_default_timezone_set('America/Sao_Paulo');
# EMAILS
########
 define('EMAIL','lslucas@gmail.com');
 define('BBC1_EMAIL',EMAIL);
 define('BBC2_EMAIL','');
 define('BBC3_EMAIL','');
 define('BBC4_EMAIL','');
 define('BBC1_NOME','Lucas Serafim');
 define('BBC2_NOME','');
 define('BBC3_NOME','');
 define('BBC4_NOME','');
 define('ADM_EMAIL','lslucas@gmail.com');


# CONEXAO COM DB
################

 if ($_SERVER['HTTP_HOST']=='localhost') {

	 define('DB_SERVER','127.0.0.1');
	 define('DB_USER','root');
	 define('DB_PASS','');
	 define('DB_DATABASE','glauber');

	 error_reporting(E_ALL);
	 ini_set('display_errors','On');

 } else {
	 define('DB_SERVER','187.45.196.196');
	 define('DB_USER','glaubermattina');
	 define('DB_PASS','solteiro.22');
	 define('DB_DATABASE','glaubermattina');

	 ini_set('display_errors','Off');
 }
#prefixo das tabelas
 define('TABLE_PREFIX','gl'); 


# VARIAVEIS DE CONTROLE
#######################
# variavel que define a raiz do back-end
 if ($_SERVER['HTTP_HOST']=='localhost')
  $host = 'http://localhost/';

  else
   $host = 'http://'.$_SERVER['HTTP_HOST'].'/beta/admin/';

 $path = 'admin';
 $base = $host.$path.'/';


#rp relative path, caminho relativo para a raiz do back-end
 if(!isset($rp)) {
 if (@!file_exists('inc.header.php')) {
   if (@file_exists('../inc.header.php')) $rp = '../';
   if (@file_exists('../../inc.header.php')) $rp = '../../';

 } else $rp = '';
 }




# VARIAVEIS GLOBAIS
###################

 define('SITE_NAME','Glauber');
 if ($_SERVER['HTTP_HOST']=='localhost') define('SITE_URL','http://localhost/glauber/');
 else define('SITE_URL',$host);
 define('HOST', $_SERVER['HTTP_HOST']);
 define('RODAPE','<a href="'.SITE_URL.'">'.SITE_NAME.'</a>');

 define('SITE_ADM_IMGPATH','images');
 define('FILE_LOGO','logo.jpg');
 define('SITE_ADMLOGO','<img src="'.SITE_ADM_IMGPATH.'/'.FILE_LOGO.'" border="0">');
 define('URL_ADMLOGO','<img src="'.SITE_URL.SITE_ADM_IMGPATH.'/'.FILE_LOGO.'" border="0">');

 define('PATH_FILE',$rp.'../upload');
 define('PATH_IMG',$rp.'../images');

# DEBUG
#######

 define('DEBUG',0);
 define('DEBUG_LOG',$rp.'debug.log');





# variavel que define o path
 $p  = isset($_GET['p'])?$_GET['p']:'';
# actual path, o local atual no sistema
 $ap = !empty($p)?$rp.$p.'/':'';
# se esta dentro de um modulo verifica ql o status, insert/update ou nenhum
 if(isset($_GET['insert']))
  $act = 'insert';
  elseif(isset($_GET['update']))
   $act='update';
   else 
    $act='';


## TINYMCE BBCODE
// theme : "advanced",
// 
// 
$TinyMCE = <<<end
	script_url : "${rp}js/tinymce/jscripts/tiny_mce/tiny_mce.js",
	mode : "exact",
	theme : "advanced",
	skin_variant : "silver",
	plugins : "safari,iespell,contextmenu,paste,directionality,noneditable,visualchars,xhtmlxtras,template,inlinepopups",
	onchange_callback: function(editor) {
		tinyMCE.triggerSave();
		$("#" + editor.id).valid();
	},


	// Theme options
	theme_advanced_buttons1 : "bold,italic,|,forecolor,backcolor,|,hr,removeformat,|,image,cleanup,|,cut,copy,paste,pastetext,pasteword,|,undo,redo,|,link,unlink,anchor",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "none",
	theme_advanced_resizing : true,
	content_css : "${rp}css/tinymce.css"

end;

#HTML DO EMAIL DO ADMINISTRADOR
$SITE_NAME = SITE_NAME;
$administrador_email_header = <<<end
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>$SITE_NAME</title>
<style type='text/css'>
  <!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-size: 12px;
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	background-repeat: no-repeat;
	background-position: center center;
	background-attachment: fixed;

} h1,h2,h3,h4,h5 {
	color: #145675;
	font-weight: bolder;
	font-size: 12pt;

} a {
 color: #145675;
 background-color: transparent;
 text-decoration: none;
 font-weight: normal;

} a:visited {
 color: #036EBF;
 text-decoration: none;

} a:hover {
 color: #78251B;
 background-color: #d0baba;
 text-decoration: none;
} .central {
 width:450px;
 margin:20px;
}
}-->
  </style>

</head>
<body>
<div class="central">
 <h3>$SITE_NAME</h3>
end;

$administrador_email_footer = <<<end
</div>
</body>
</html>

end;


$LOADING = <<<EOF
  // BOX DE CARREGAMENTO
  $.blockUI({
   message: "<img src='images/loading.gif'>",
   css: { 
     top:  ($(window).height()-32)/2+'px', 
     left: ($(window).width()-32)/2+'px', 
     width: '32px' 
   }
  });
EOF;
