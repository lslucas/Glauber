<?php
## NOTA: CASO EM NENHUM OUTRO MODULO SEJA DEFINIDO O ARQUIVO HEADER, ESSE SERA O ARQUIVO PADRAO


# CSS INCLUIDO NO inc.header.php
//<link href="css/reset.css" rel="stylesheet" />
$include_css = <<<end
<!-- <link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.1.css" media="screen" />-->
     <link rel="stylesheet" type="text/css" href="js/jGrowl-1.2.4/jquery.jgrowl.css"/>
     <style>
       div.growlUI { 
          background: url(images/warning.png) no-repeat;
         } div.growlUI h1, div.growlUI h2 {
          color: white;
          padding: 5px 5px 5px 60px;
          text-align: left;
          font-family:'Tahoma';
        }
     </style>
end;



$pag = isset($_GET['pg'])?'&pg='.$_GET['pg']:'';
# JS INCLUIDO NO inc.header.php, também pode conter codigo js <script>alert();</script>
$include_js = <<<end
<!--<script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
    <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.1.js"></script>-->
    <script type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="js/jGrowl-1.2.4/jquery.jgrowl.js"></script>
    <script type="text/javascript" src="${rp}js/jquery.validate.min.js"></script>

<script>
  $(function(){

      var num_total = $('#num_total').text();
      num_total = parseInt(num_total);


      // validação do formulario, todos os campos com a classe
      // class="required" serao validados
	var container = $('div.container-error');
	// validate the form when it is submitted
	var validator = $(".form").validate({
		errorContainer: container,
		errorClass: 'error-validate',
		errorLabelContainer: $("ol", container),
		wrapper: 'li',
		meta: "validate",
		rules:{
		 confirma_senha:{
		  required:true,
		  equalTo:"#senha"
		 }
		}
	});





  /*
	 *CHECK-ALL
   **************************/
	$('[name="check-all"]').click(function(){

	  if($(this).attr('checked')==true)
	   $('.check').attr('checked',true);

	   else $('.check').attr('checked',false);

	});


   $('#orderby').change(function(){
    window.location.href='?p=${p}${pag}&orderby='+$(this).val();
   });



	$('select[name=actions]').change(function() {
       var acao = $(this).val();
       var nChecked = $('.check:checked').length;


            if(acao=='delete' && nChecked>0) {
            $LOADING

                $.ajax({
                 type:'POST',
                 data:$('.check:checked').serialize(),
                 url: '${rp}?p=$p&delete&noVisual',

                 error:function() {
                    $.unblockUI();
                    $.growlUI('ERRO:','Erro inesperado!');
                 },

                 success:function(data) {
                    $.unblockUI();
                    $.growlUI('Resposta:',data);

                      $('.check:checked').each(function(i) {
                       $('#tr'+$(this).val()).hide();
                       $('#num_total').text(num_total-(i+1));
                      });

                    $('.check').attr('checked',false);
                 }

                });


            }


            if(acao=='ativar' && nChecked>0 || acao=='pendente' && nChecked>0) {
            $LOADING

                $.ajax({
                 type:'POST',
                 data:$('.check:checked').serialize()+'&acao='+acao,
                 url: '${rp}?p=$p&status&noVisual',

                 error:function() {
                    $.unblockUI();
                    $.growlUI('ERRO:','Erro inesperado!');
                 },

                 success:function(data) {
                    $.unblockUI();
                    $.growlUI('Resposta:',data);

                       if(acao=='ativar') {

                          $('.check:checked').each(function(i) {
                           $('.status'+$(this).val()).html('<font class="green">Ativo</font>');
                          });

                       } else {

                          $('.check:checked').each(function(i) {
                           $('.status'+$(this).val()).html('<font color="#999999">Pendente</font>');
                          });

                       }


                    $('.check').attr('checked',false);

                 }

                });


            }
         $.unblockUI();

	});







	/* APAGA 
	************************************/
	$(".trash").click(function(event){
	 event.preventDefault();
  	 var id_trash = $(this).attr('id');
  	 var href_trash = $(this).attr('href');
  	 var nome_trash = $(this).attr('name');

	  $.blockUI({
	   message: "<p>Tem certeza que deseja remover <b>"+nome_trash+"</b>?</p><br><input type='submit' value='sim' id='trash-sim'> <input type='button' value='não' id='trash-nao'>"
	  });

	// ACAO AO CLICAR EM NaO
	     $("#trash-nao").click(function(){
	      $.unblockUI();
	      return false;
	     });


	// ACAO AO CLICAR EM SIM
	     $("#trash-sim").click(function(){

          $LOADING
          $.ajax({
            type: "POST",
            url: href_trash,
            data: 'item='+id_trash,
            success: function(data){
             $.unblockUI();
             $.growlUI('Remoção',data);  
             $('#tr'+id_trash).hide();
             $('#num_total').text(num_total-1);
            }
          });

	     });



	});
	/* FIM: APAGA*/


	/* STATUS 
	************************************/
	$(".status").click(function(event){
	 event.preventDefault();
  	 var id_status = $(this).attr('id');
  	 var texto_status = $(this).text();
  	 var href_status  = $(this).attr('href');
  	 var nome_status  = $(this).attr('name');

    $LOADING
		$.ajax({
			type: "POST",
			url: href_status,
      data: 'item='+id_status,
			success: function(data){
			 $.unblockUI();
			 $.growlUI('Status',data);  

			 if(texto_status=='Ativo') {
         $('.status'+$(this).val()).html('<font color="#999999">Pendente</font>');

         } else {
			    $('.status'+id_status).html('<font class="green">Ativo</font>');
         }
			}
		});


	});
	/* FIM: STATUS*/



	/* MOSTRA AS ACOES AO PASSAR O MOUSE SOBRE A TR DO ÍTEM DA TABELA*/
	$('.list tr').bind('mouseenter',function(){
	 $(this).find('.row-actions').css('visibility','visible');
	}).bind('mouseleave',function(){
	 $(this).find('.row-actions').css('visibility','hidden');
	});
  });
</script>
end;

