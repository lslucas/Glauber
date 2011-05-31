<form action="index.php" method="post" class='cmxform form login'>
<?php
 $noFooter=1;
 #mostra msg caso haja
 if (isset($msgNotice) && !empty($msgNotice)) {
  echo "<div class='${classNotice}'><span class='${classNotice}-icon'>$msgNotice</span></div>";
 }

?>


  <ol class='label-100'>
	<li>	
	  <label>E-mail</label>
	  <input type='text' name='username' class='required'>
	</li>

	<li>	
	  <label>Senha</label>
	  <input type='password' name='password' class='required'>
	</li>

    <p align='center'>
    <input type='submit' value='LOGIN' class='first'></p>
    <div class='spacer'></div>

</form>
