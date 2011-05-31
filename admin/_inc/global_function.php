<?php
/*
 *retorna apenas numeros
 */
function numeric($var) {
  return preg_replace('/[^0-9]/', '', $var);
}

/*
 *USA API DO GOOGLE MAPS E RETORNA A LATITUDE E LONGITUDE DE ACORDO COM O ENDEREÇO
 */
function getLatLng($address) {


  if(!defined('MAPS_HOST'))
    define("MAPS_HOST", "maps.google.com");

  if(!defined('KEY')) 
    define("KEY", "ABQIAAAA4LKmp8EeHJIt0QNYBBHhQBS9Z1_403QFoKn5hjOlOB17X0DoXRQPiwLlgavMnlf-8-_0snf8-yg1-A");

  // Initialize delay in geocode speed
  $delay = 0;
  $base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml" . "&key=" . KEY;
  $request_url = $base_url . "&q=" . urlencode($address);

  $xml = simplexml_load_file($request_url) or die("url not loading");
  $status = $xml->Response->Status->code;


  if (strcmp($status, "200") == 0) {
    $coordinates = $xml->Response->Placemark->Point->coordinates;
    $coordinatesSplit = explode(",", $coordinates);

    // Format: Longitude, Latitude, Altitude
    $lat = $coordinatesSplit[1];
    $lng = $coordinatesSplit[0];

   return $lat.', '.$lng;

  } else if (strcmp($status, "620") == 0) {

    // sent geocodes too fast
    $delay += 100000;

  } else {

    // failure to geocode
    $geocode_pending = false;
    echo "Address " . $address . " failed to geocoded. ";
    echo "Received status " . $status . "\n";

  }

}


/* LIMIT NEWLINE
 * limitBreaks, prevents texts with a lot of enters/breaks after each other
 *
 * @param string $sText
 * @param int $iAmount default 2, numbers of newlines that may occur after eachother
 * @return string, cleaned up string with limited number of newlines
 */
function limitBreaks($sText, $iAmount=2) {
  return preg_replace("/[\r\n]{".($iAmount+1).",}\t*[\r\n]*/", str_repeat(PHP_EOL, $iAmount), $sText);
}


/*
 *Converte de float para moeda e aplica desconto
 */
function monetary_off($valor, $desconto, $reverse=0) {


  if($reverse===1) {

   $valor = preg_replace('/[^0-9,]/', '', $valor);
   $valor = preg_replace('/[, ]/', '.', $valor);

   $desconto = preg_replace('/[^0-9,]/', '', $desconto);
   $desconto = preg_replace('/[, ]/', '.', $desconto);

   $descontado = $valor*($desconto/100);
   $valor = $valor-$descontado;


   return number_format($valor, 2, '.', '');

  } else {

    $descontado = $valor*($desconto/100);
    $valor = $valor-$descontado;


    return number_format($valor, 2, ',', '.');

  }

}


/*
 *Converte de Float para moeda
 */
function monetary($number, $reverse=0) {


  if($reverse===1) {
   $number = preg_replace('/[^0-9,]/', '', $number);
   $number = preg_replace('/[, ]/', '.', $number);
   return number_format($number, 2, '.', '');

  } else return number_format($number, 2, ',', '.');


}




/*
 *Para formularios, retorna o valor
 *de acordo com o tipo de campo e o nome do campo
 */
function returnVal($nome, $valor, $input) {
  global $val;

  $return = '';
  if(isset($val[$nome]) && !empty($val[$nome])) {

    if($val[$nome]==$valor) {

        switch($input) {
            case 'select': $return = ' selected';
          break;
            case 'checkbox' or 'radio': $return = ' checked';
          break;
            case 'text': $return = ' value="'.$val[$nome].'"';
          break;
            default: $return = $val[$nome];
          break;
        }

    }
  }

 return $return;


}

/*
 * pega extensão de arquivo da string
 */
function file_extension($filename) {

 return end(explode(".", $filename));

}


/**
 * Converts all accent characters to ASCII characters.
 *
 * If there are no accent characters, then the string given is just returned.
 *
 * @param string $string Text that might have accent characters
 * @return string Filtered string with replaced "nice" characters.
 */

function remove_accents($string) {
 if (!preg_match('/[\x80-\xff]/', $string))
  return $string;
 if (seems_utf8($string)) {
  $chars = array(
  // Decompositions for Latin-1 Supplement
  chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
  chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
  chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
  chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
  chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
  chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
  chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
  chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
  chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
  chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
  chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
  chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
  chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
  chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
  chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
  chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
  chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
  chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
  chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
  chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
  chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
  chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
  chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
  chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
  chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
  chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
  chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
  chr(195).chr(191) => 'y',
  // Decompositions for Latin Extended-A
  chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
  chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
  chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
  chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
  chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
  chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
  chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
  chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
  chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
  chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
  chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
  chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
  chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
  chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
  chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
  chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
  chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
  chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
  chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
  chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
  chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
  chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
  chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
  chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
  chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
  chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
  chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
  chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
  chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
  chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
  chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
  chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
  chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
  chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
  chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
  chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
  chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
  chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
  chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
  chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
  chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
  chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
  chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
  chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
  chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
  chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
  chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
  chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
  chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
  chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
  chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
  chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
  chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
  chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
  chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
  chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
  chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
  chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
  chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
  chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
  chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
  chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
  chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
  chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
  // Euro Sign
  chr(226).chr(130).chr(172) => 'E',
  // GBP (Pound) Sign
  chr(194).chr(163) => '');
  $string = strtr($string, $chars);
 } else {
  // Assume ISO-8859-1 if not UTF-8
  $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
   .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
   .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
   .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
   .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
   .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
   .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
   .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
   .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
   .chr(252).chr(253).chr(255);
  $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
  $string = strtr($string, $chars['in'], $chars['out']);
  $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
  $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
  $string = str_replace($double_chars['in'], $double_chars['out'], $string);
 }
 return $string;
}

/**
 * Checks to see if a string is utf8 encoded.
 *
 * @author bmorel at ssi dot fr
 *
 * @param string $Str The string to be checked
 * @return bool True if $Str fits a UTF-8 model, false otherwise.
 */
function seems_utf8($Str) { # by bmorel at ssi dot fr
 $length = strlen($Str);
 for ($i = 0; $i < $length; $i++) {
  if (ord($Str[$i]) < 0x80) continue; # 0bbbbbbb
  elseif ((ord($Str[$i]) & 0xE0) == 0xC0) $n = 1; # 110bbbbb
  elseif ((ord($Str[$i]) & 0xF0) == 0xE0) $n = 2; # 1110bbbb
  elseif ((ord($Str[$i]) & 0xF8) == 0xF0) $n = 3; # 11110bbb
  elseif ((ord($Str[$i]) & 0xFC) == 0xF8) $n = 4; # 111110bb
  elseif ((ord($Str[$i]) & 0xFE) == 0xFC) $n = 5; # 1111110b
  else return false; # Does not match any model
  for ($j = 0; $j < $n; $j++) { # n bytes matching 10bbbbbb follow ?
   if ((++$i == $length) || ((ord($Str[$i]) & 0xC0) != 0x80))
   return false;
  }
 }
 return true;
}

function utf8_uri_encode($utf8_string, $length = 0) {
 $unicode = '';
 $values = array();
 $num_octets = 1;
 $unicode_length = 0;
 $string_length = strlen($utf8_string);
 for ($i = 0; $i < $string_length; $i++) {
  $value = ord($utf8_string[$i]);
  if ($value < 128) {
   if ($length && ($unicode_length >= $length))
    break;
   $unicode .= chr($value);
   $unicode_length++;
  } else {
   if (count($values) == 0) $num_octets = ($value < 224) ? 2 : 3;
   $values[] = $value;
   if ($length && ($unicode_length + ($num_octets * 3)) > $length)
    break;
   if (count( $values ) == $num_octets) {
    if ($num_octets == 3) {
     $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
     $unicode_length += 9;
    } else {
     $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
     $unicode_length += 6;
    }
    $values = array();
    $num_octets = 1;
   }
  }
 }
 return $unicode;
}

/**
 * Sanitizes title, replacing whitespace with dashes.
 *
 * Limits the output to alphanumeric characters, underscore (_) and dash (-).
 * Whitespace becomes a dash.
 *
 * @param string $title The title to be sanitized.
 * @return string The sanitized title.
 */
function slugify($title) {
 $title = strip_tags($title);
 // Preserve escaped octets.
 $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
 // Remove percent signs that are not part of an octet.
 $title = str_replace('%', '', $title);
 // Restore octets.
 $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);
 $title = remove_accents($title);
 if (seems_utf8($title)) {
  if (function_exists('mb_strtolower')) {
   $title = mb_strtolower($title, 'UTF-8');
  }
  $title = utf8_uri_encode($title, 200);
 }
 $title = strtolower($title);
 $title = preg_replace('/&.+?;/', '', $title); // kill entities
 $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
 $title = preg_replace('/\s+/', '-', $title);
 $title = preg_replace('|-+|', '-', $title);
 $title = trim($title, '-');
 return $title;
}

/*
 *tiny mce
 */
function parse_mytag($content) {

        // Find the tags
        preg_match_all('/\<span style="font-weight: bold;"([^>]*)\>(.*?)\<\/span\>/is', $content, $matches);

        // Loop through each tag
        for ($i=0; $i < count($matches['0']); $i++) {
                $tag = $matches['0'][$i];
                $text = $matches['2'][$i];

                $new = '<b>';
                $new .= $text;
                $new .= '</b>';

                // Replace with actual HTML
                $content = str_replace($tag, $new, $content);
        }

        return $content;
}



/*
 *Mostra a quanto tempo foi feito/postado
 */
/* Works out the time since the entry post, takes a an argument in unix time (seconds) */
function time_since($original) {
    // array of time period chunks
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'ano'),
        array(60 * 60 * 24 * 30 , 'mese'),
        array(60 * 60 * 24 * 7, 'semana'),
        array(60 * 60 * 24 , 'dia'),
        array(60 * 60 , 'hora'),
        array(60 , 'minuto'),
    );
    
    $today = time(); /* Current unix time  */
    $since = $today - $original;
    
    // $j saves performing the count function each time around the loop
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        
        // finding the biggest chunk (if the chunk fits, break)
        if (($count = floor($since / $seconds)) != 0) {
            // DEBUG print "<!-- It's $name -->\n";
            break;
        }
    }
    
    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    
    if ($i + 1 < $j) {
        // now getting the second item
        $seconds2 = $chunks[$i + 1][0];
        $name2 = $chunks[$i + 1][1];
        
        // add second item if it's greater than 0
        if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) !== 0) {
            $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
        } 
    }

    if($print=='0 minutos')
     return 'agora pouco';

     else return $print;
}



/*
 *valida email 
 */
function validaEmail($email) {


  //Run the email through an email validation filter.
  if( filter_var($email, FILTER_VALIDATE_EMAIL) ){
    return $email;


   } else {

      $good = filter_var($email, FILTER_SANITIZE_EMAIL);
      if(filter_var($good, FILTER_SANITIZE_EMAIL))
       return $good;

       else return '[email inválido]';

   }

  return $email;
}


 /*
  *REMOVE ACENTOS
  */
function limpaString($var) {

# $var = ereg_replace("[^a-zA-Z0-9 ]", "", strtr($var, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC "));

	// lowercase
	$var = ereg_replace("[áàâã]","a",$var);	
	$var = ereg_replace("[éèê]","e",$var);	
	$var = ereg_replace("[óòôõº]","o",$var);	
	$var = ereg_replace("[íìî]","i",$var);
	$var = ereg_replace("[úùûü]","u",$var);	
	$var = str_replace("ç","c",$var);
/*
	// uppercase
	$var = eregi_replace("[ÁÀÂÃ]","A",$var);	
	$var = eregi_replace("[ÉÈÊ]","E",$var);	
	$var = eregi_replace("[ÓÒÔÕ]","O",$var);	
	$var = eregi_replace("[ÍÌÎ]","I",$var);
	$var = eregi_replace("[ÚÙÛÜ]","U",$var);	
	$var = str_replace("Ç","C",$var);

	//especiais
	$var = str_replace("'\"","",$var);
*/
	return $var;
}


/*
 *CALCULA IDADE
 */
 function diferencaAnos($var,$ref) {

  $var = explode('-',$var);
  $ref = explode('-',$ref);

  list($ano,$mes,$dia)=$var;
  list($ano_atual,$mes_atual,$dia_atual)=$ref;

 if (!checkdate($mes, $dia, $ano) || !checkdate($mes_atual, $dia_atual, $ano_atual)) {
  echo '[data inválida]';
 #  echo "A data que você informou está errada <b>[ ${var[0]}/${var[1]}/${var[2]} ou ${ref[0]}/${ref[1]}/${ref[2]}]</b>";

  } else { 

   $dif = $ano_atual-$ano;

   if ($mes_atual<$mes) {
    $dif=$dif-1;

   } elseif ($mes==$mes_atual && $dia_atual<$dia) {
    $dif=$dif-1;
   } 

  return $dif;
  }

}

/*
 *REMOVE TUDO QUE NAO É NÚMERO
 */
 function apenasNumeros($var){

  return ereg_replace('^[0-9]+$','',$var);

 }

/*
 *RETORNA TIMESTAMP DA DATA EM INGLES
 */
 function en2timestamp($date,$sep='-') {


   $date = explode($sep,$date);
   $unix = mktime(0,0,0,$date[1],$date[2],$date[0]);


   return $unix;

 }



/*
 *RETORNA O DIA DA SEMANA
 */
 function date_diasemana($date,$type='') {

  if (!empty($date)) {

   #pega informações da data
   $date = en2timestamp($date);
   $wday = getdate($date);
   $wday = $wday['wday']; #usa apenas o dia da semana em números de 0 a 6

     switch($wday) {
	 case 0: $s_min = 'dom'; $s_nor = 'domingo';
       break;
	 case 1: $s_min = 'seg'; $s_nor = 'segunda';
       break;
	 case 2: $s_min = 'ter'; $s_nor = 'terça';
       break;
	 case 3: $s_min = 'qua'; $s_nor = 'quarta';
       break;
	 case 4: $s_min = 'qui'; $s_nor = 'quinta';
       break;
	 case 5: $s_min = 'sex'; $s_nor = 'sexta';
       break;
	 case 6: $s_min = 'sab'; $s_nor = 'sábado';
       break;
     }

     $return = empty($type)?$s_nor:$s_min;

   return $return;

  }

 }


function date_mes($mes, $type='') {

     switch ($mes){

	  case 1: $mes = "Janeiro"; $mes_min='Jan'; 
	    break;

	  case 2: $mes = "Fevereiro"; $mes_min='Fev';
	    break;

	  case 3: $mes = "Março"; $mes_min = 'Mar';
	    break;

	  case 4: $mes = "Abril"; $mes_min='Abr';
	    break;

	  case 5: $mes = "Maio"; $mes_min='Mai';
	    break;

	  case 6: $mes = "Junho"; $mes_min='Jun';
	    break;

	  case 7: $mes = "Julho"; $mes_min='Jul';
	    break;

	  case 8: $mes = "Agosto"; $mes_min='Ago';
	    break;

	  case 9: $mes = "Setembro"; $mes_min='Set';
	    break;

	  case 10: $mes = "Outubro"; $mes_min='Out';
	    break;

	  case 11: $mes = "Novembro"; $mes_min='Nov';
	    break;

	  case 12: $mes = "Dezembro";  $mes_min='Dez';
	    break;

     }


    if($type=='min')
     return $mes_min;
     
     else return $mes;

}


/*
 *CASO O TEXTO SEJA DE BBCODE ELE CONVERTE
 */
function txt_bbcode($var) {

 $txt = utf8_encode(html_entity_decode($var));

 return $txt;
}


# GERA PASSWORD
###############
function gera_senha($numL) {
    $chars = "?abcdefghijkmnopqrstuvwxyz023456789#";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;

     while ($i <= $numL) {
        $num = rand() % 36;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
      }

    return $pass;

}
# //GERA PASSWORD
###



# CONVERTE A DATA DO PORTUGUES PARA INGLES
##########################################
function datept2en($date, $nsep='-') {
 if (!empty($date)) {

   $date = preg_split('/[\/\ .-]/', $date);
   return $date[2].$nsep.$date[1].$nsep.$date[0];

 }

}

#// CONVERTE A DATA DO PORTUGUES PARA INGLES
###

# CONVERTE A DATA DO INGLES PARA PORTUGUES
##########################################
function dateen2pt($date,$nsep='-') {

 if (!empty($date)) {

   $date = preg_split('/[\/\ .-]/',$date);
   return $date[2].$nsep.$date[1].$nsep.$date[0];

 }

}

#// CONVERTE A DATA DO PORTUGUES PARA INGLES
###



## debug do session
function debug($var) {
	echo '<pre>'. print_r($var, 1) .'</pre>';
}



## LOG
#COMPUTA TUDO NA TABELA DE LOG
###############################
function logquery() {
 global $conn;

 if (!isset($_SESSION['user'])) {
     $userdata = array(
      'id' => '',
      'nome' => '',
      'email' => '',
      'senha' => '',
      'ip' => $_SERVER['REMOTE_ADDR'],
      'host' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
      'useragent' => $_SERVER['HTTP_USER_AGENT']
     );
     
     foreach($userdata as $k=>$v) {
      $log[$k]=$v;
     }


 } else {

     foreach($_SESSION['user'] as $k=>$v) {
      $log[$k]=$v;
     }

 }


  #computa variaveis para o log
     $server = array(
      'php_self' => $_SERVER['PHP_SELF'],
      'query_string' => $_SERVER['QUERY_STRING'],
      'request_uri' => $_SERVER['REQUEST_URI'],
      'request_time' => $_SERVER['REQUEST_TIME'],
      'http_referer' => isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:''
     );

     foreach($server as $k=>$v) {
      $slog[$k]=$v;
     }



  $sql_log = "INSERT INTO ".TABLE_PREFIX."_log 
  		(
  		 log_adm_id,
		 log_nome,
		 log_email,
		 log_senha,
		 log_php_self,
		 log_query_string,
		 log_request_uri,
		 log_request_time,
		 log_http_referer,
		 log_ip,
		 log_host,
		 log_useragent
		) VALUES (
		 ?,?,?,?,?,?,?,?,?,?,?,?
		)
	  ";
  if($qr_log = $conn->prepare($sql_log)) {

    $qr_log->bind_param('isssssssssss', $log['id'], 
                                        $log['nome'], 
                                        $log['email'],
                                        $log['senha'], 
                                        $slog['php_self'], 
                                        $slog['query_string'], 
                                        $slog['request_uri'], 
                                        $slog['request_time'], 
                                        $slog['http_referer'], 
                                        $log['ip'], 
                                        $log['host'],
                                        $log['useragent']);
    $qr_log->execute();
    $qr_log->close();


   } else echo $conn->error;


}
## //LOG
#####


## DEBUG
# grava todo tipo de erro numa tabela e pode enviar para o administrador
########
 function debuglog($numero,$texto,$errfile, $errline){
  global $conn;


  if(DEBUG==1) {

    ## VARIAVEIS DE CONFIG
     if (!isset($_SESSION['user'])) {
	 $userdata = array(
	  'id' => '',
	  'nome' => '',
	  'ip' => $_SERVER['REMOTE_ADDR'],
	  'useragent' => $_SERVER['HTTP_USER_AGENT']
	 );
	 
	 foreach($userdata as $k=>$v) {
	  $log[$k]=$v;
	 }

     } else {

	 foreach($_SESSION['user'] as $k=>$v) {
	  $log[$k]=$v;
	 }

     }




      # se DEBUG_LOG nao for vazio vai gravar no arquivo de log
      if (DEBUG_LOG<>'') {

	/*
	if(!file_exists(DEBUG_LOG)) {
	 mkdir(DEBUG_LOG,0777,true);
	}
	*/

	$ddf = fopen(DEBUG_LOG,'a');
	fwrite($ddf,"".date("r").": [$numero] $texto $errfile $errline \r\n [$log[id]]$log[nome] - $log[ip], $log[useragent] \r\n\r\n");
	fclose($ddf);

      }



      $sql_dlog = "INSERT INTO ".TABLE_PREFIX."_debuglog
		    (
		     del_adm_id,
		     del_nome,
		     del_useragent,
		     del_ip,
		     del_err_number,
		     del_err,
		     del_err_file,
		     del_err_line
		    ) VALUES (
		     ?,?,?,?,?,?,?,?
		    )
	      ";

      if( !($qr_dlog = $conn->prepare($sql_dlog)) ) {
       	echo 'erro '.$conn->error;


      } else {

        $qr_dlog->bind_param('isssissi', $log['id'], $log['nome'], $log['ip'], $log['useragent'], $numero, $texto, $errfile, $errline);
        $qr_dlog->execute();
        $qr_dlog->close();

      }
 }

}


 if (DEBUG==1)
  set_error_handler('debuglog');
## //DEBUG
#####
