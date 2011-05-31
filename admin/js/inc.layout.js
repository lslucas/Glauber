    $(function(){

	/* LAYOUT
	******************** */
	 // largura atual do documento
   	 var docWidth = $(document).width();

	 // largura em tempo real do documento
	 $(window).resize(function(){
   	  docWidth = $(document).width();
         });

	 // largura do menu lateral
   	 var navWidth = $('nav').width();
	 // correcao da largura, para margens
 	 var margemCorrecao = 65;

	 // define a largura de container
	 $('.container').width(docWidth-(navWidth+margemCorrecao));

	/* //LAYOUT
	******************** */
    });
