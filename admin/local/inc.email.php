<?php

#gera o html do email
$msg = $administrador_email_header;


    #if($res['act']=='insert') {

      $email_subject = SITE_NAME.": Nova notícia postada";
      $msg .= "
	      Acesse a administração para maiores informações.

	      <p><b>".$res['titulo']."</b>
	      <p>".$res['texto']."</p>
	      </p>

	      <br><br><b>Painel de administração:</b> <a href='".SITE_URL."' target='_blank'>".SITE_URL."</a>
	      ";

$msg .= $administrador_email_footer;


      //envia email
      require_once($rp."_inc/class.phpmailer.php");
      $mail = new phpmailer();
      $mail->From = EMAIL;
      $mail->FromName =  utf8_decode(SITE_NAME);
      $mail->ReplyTo = EMAIL;
      $mail->Mailer = "mail";
      $mail->Subject = utf8_decode($email_subject);
      $mail->IsHTML(true);
      $mail->Body = utf8_decode($msg);


	#pega o nome e email do usuario dono do ticket
	$sql_mailto= " SELECT adm_nome, adm_email FROM ".TABLE_PREFIX."_administrador";
	$sql_mailto.= " INNER JOIN ".TABLE_PREFIX."_r_adm_categoria ON rac_adm_id=adm_id";
	$sql_mailto.=" WHERE $arr_cat GROUP BY adm_email";

	$qry_mailto=$conn->prepare($sql_mailto);
	#$qry_mailto->bind_param('i',$cat_id); #pega cat_id de mod.exec.categoria.php já que esse é um include  
	$qry_mailto->execute();
	$qry_mailto->bind_result($mailto_nome, $mailto_email);
	$w=0;


	while($qry_mailto->fetch()) {

	  #manda email a todos os atuais cadastrados nas categorias selecionadas
	  $mail->AddAddress($mailto_email,utf8_decode($mailto_nome));

	  if($w==0) {
	    if(BBC1_EMAIL<>'') $mail->AddBCC(BBC1_EMAIL, BBC1_NOME);
	    if(BBC2_EMAIL<>'') $mail->AddBCC(BBC2_EMAIL, BBC2_NOME);
	    if(BBC3_EMAIL<>'') $mail->AddBCC(BBC3_EMAIL, BBC3_NOME);
	    if(BBC4_EMAIL<>'') $mail->AddBCC(BBC4_EMAIL, BBC4_NOME);
	  }

	  $mail->Send();
          $mail->ClearAddresses();

	 $w++;
	}

	$qry_mailto->close();



?>

