<?php
$msg = $administrador_email_header;
  if ($act=='insert') {
    $email_subject = SITE_NAME.": Seus dados de acesso";
    $msg .= "
	     <!--<center><img src='".URL_ADMLOGO."'></center><p />-->
	     Olá ".$res['nome'].", agora você tem dados de acesso da administração do ".SITE_NAME.":

	     <p><b>Usuário:</b> ".$res['email']."
	     <br><b>Senha:</b> ".$res['senha']."
	     <br><b>Painel de administração:</b> <a href='".SITE_URL."' target='_blank'>".SITE_URL."</a>

	     <p>Lembrando que é possível alterar sua senha!</p>";

   } elseif ($act=='update') {
    $email_subject = SITE_NAME.": Informações do usuário alteradas";
    $msg .= "
	     <!--<center><img src='".URL_ADMLOGO."'></center><p />-->
	     Olá ".$res['nome'].", seus dados foram alterados com êxito na administração do ".SITE_NAME.":

	     <p><b>Usuário:</b> ".$res['email']."
	     <br><b>Senha:</b> continua a mesma! 
	     <br><b>Painel de administração:</b> <a href='".SITE_URL."' target='_blank'>".SITE_URL."</a>
	    ";

   } else {
    $email_subject = SITE_NAME.": Senha alterada";
    $msg .= "
	     <!--<center><img src='".URL_ADMLOGO."'></center><p />-->
	     Olá ".$res['nome'].", sua senha foi alterada!

	     <p><b>Usuário:</b> ".$res['email']."
	     <br><b>Senha:</b> ".$res['senha']." 
	     <br><b>Painel de administração:</b> <a href='".SITE_URL."' target='_blank'>".SITE_URL."</a>
	    ";
   }
$msg .= $administrador_email_footer;

      require_once($rp."_inc/class.phpmailer.php");
      $mail = new phpmailer();
      $mail->From = EMAIL;
      $mail->FromName =  utf8_decode(SITE_NAME);
      $mail->ReplyTo = EMAIL;
      $mail->Mailer = "mail";
      $mail->Subject = utf8_decode($email_subject);
      $mail->IsHTML(true);

      $mail->AddAddress($res['email'],utf8_decode($res['nome']));
      if(BBC1_EMAIL<>'') $mail->AddBCC(BBC1_EMAIL, BBC1_NOME);
      if(BBC2_EMAIL<>'') $mail->AddBCC(BBC2_EMAIL, BBC2_NOME);
      if(BBC3_EMAIL<>'') $mail->AddBCC(BBC3_EMAIL, BBC3_NOME);
      if(BBC4_EMAIL<>'') $mail->AddBCC(BBC4_EMAIL, BBC4_NOME);
      $mail->Body = utf8_decode($msg);
      $mail->Send();
      $mail->ClearAddresses();

?>

