<?php
#INICIO MSG ERROS
################
# ERRO DUBPLICADO
$nomeAcao = $act=='insert'?'incluid'.$var['genero']:'alterad'.$var['genero'];


$msgDuplicado = <<<end

 <p class='error'><span class='error-icon'>Já existe $var[um] com o título <b>- $res[titulo] -</b></span></p>
 <br>
 <p align='center'>
  <a href='?p=$p&insert'>Volte e preencha novamente</a> - <a href='?p=$p'>Ir para a listagem</a>
 </p>

end;
# ERRO CONSULTA
$msgErro = <<<end

 <p class='error'><span class='error-icon'>Houve um erro!</span></p>
 <br>
 <pre>$conn->error()</pre>

end;
# SUCESSO CONSULTA
$msgSucesso = <<<end

 <p class='success'><span class='success-icon'>Ítem $nomeAcao com êxito!</span></p>
 <br>
 <p align='center'>
  <a href='?p=$p&insert'>Incluir $var[novo]</a> - <a href='?p=$p'>Ir para a listagem</a>
 </p>

end;
##/FIM MSG ERROS
################
?>
