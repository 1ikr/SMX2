<?php
$url = "https://catalegdades.caib.cat/resource/rjfm-vxun.xml";
if (!$xml = file_get_contents($url)) {
    echo "No hem pogut carregar la url";
} else {
    $xml = simplexml_load_string($xml);
}

$mis_datos = $xml->rows;

$municipi = array();
$i = 0;
foreach($mis_datos->row as $dades){

    $municipi[$i] = $dades->municipi;
	$i=$i+1;
    //$municipi=(string) $dades->municipi;

}

var_dump($municipi);


?>
