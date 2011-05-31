<?php
## NOTA: CASO EM NENHUM OUTRO MODULO SEJA DEFINIDO O ARQUIVO HEADER, ESSE SERA O ARQUIVO PADRAO


# CSS INCLUIDO NO inc.header.php
$def_include_css = <<<end
<link href="${rp}css/reset.css" rel="stylesheet" />
    <link href="${rp}css/style.css" rel="stylesheet" />
    <link href="${rp}js/tipTip.css" rel="stylesheet" />
end;


# JS INCLUIDO NO inc.header.php, também pode conter codigo js <script>alert();</script>
$def_include_js = <<<end
<script type="text/javascript" src="${rp}js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="${rp}js/jquery.tipTip.js"></script>
    <script type="text/javascript" src="${rp}js/inc.layout.js"></script>
    <script type="text/javascript" src="${rp}js/inc.menu.js"></script>
    <script type="text/javascript" src="${rp}js/inc.panel.js"></script>

    <script>
    $(function(){
	//TIP TIP
	$(".tip").tipTip({maxWidth: "auto", edgeOffset: 10});

	// Acao ao clicar no botao voltar
	$('#form-back').click(function(){
	 window.location='${rp}?p=${p}';
	 return true;
	});

    });
    </script>
end;

?>
