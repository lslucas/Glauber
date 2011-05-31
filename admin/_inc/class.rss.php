<?php

class Rss
{
#Declaracao de variaveis
private $conexao = null;
 
private $servidor;
private $usuario;
private $senha;
private $alias;
 

    public function __construct() {
        #Dados para conexao com o banco de dados
         if ($_SERVER['HTTP_HOST']=='localhost') {
         define('DB_SERVER','127.0.0.1');
         define('DB_USER','root');
         define('DB_PASS','phocus06');
         define('DB_DATABASE','saofrancisco');
         } else {
         define('DB_SERVER','187.45.196.182');
         define('DB_USER','musclemass');
         define('DB_PASS','mvdbt9');
         define('DB_DATABASE','musclemass');
         }
        #Efetua a conexao com o banco e seleciona a base de dados
        $this->conexao = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
        if ($this->conexao)
        {
        mysql_select_db(DB_DATABASE, $this->conexao);
        }
    }





    public function rss($site, $link, $descricao, $tabela, $id, $titulo, $where='', $orderby, $destino) {

        #Seleciona os dados no banco de dados
        $sql = "SELECT * FROM $tabela $where ORDER BY $orderby DESC LIMIT 0,30;";
        $res = mysql_query($sql);

        #Cria a variavel $xml com o codigo xml necessario para criar o RSS
        $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
        $xml .= "\n<rss version=\"2.0\">";
        $xml .= "\n<channel>";
        $xml .= "\n\t<title>".utf8_decode($site)."</title>";
        $xml .= "\n\t<link>".utf8_decode($link)."</link>";
        $xml .= "\n\t<description>".utf8_decode($descricao)."</description>";
        $xml .= "\n\t<language>pt-br</language>";

        #Verifica se o numero de linhas resultantes da query eh maior do que zero
        if (mysql_num_rows($res) > 0) {
        #"Quebra" a matriz

            while ($dados = mysql_fetch_array($res)) {

                $xml .= "\n<item>";
                $xml .= "\n\t<title>".stripslashes(html_entity_decode($dados[$titulo]))."</title>";
                $xml .= "\n\t<link>${destino}/".$dados[$id]."/".urlencode(stripslashes(trim(utf8_decode($dados[$titulo]))))."</link>";
                $xml .= "\n</item>";
            }
        }

        $xml .= "\n</channel>";
        $xml .= "\n</rss>";

        #Retorna o valor da variavel $xml
        return $xml;
    }
}

