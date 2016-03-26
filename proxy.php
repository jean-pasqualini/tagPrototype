<?php

use Symfony\Component\HttpFoundation\Request;

require "vendor/autoload.php";

// http://logc406.xiti.com/hit.xiti?s=547787&s2=1&p=store_hp::selection_produits_et_services::des_timbres_plus_flexibles_pour_vos_envois&clic=N&vtag=4.6.4&hl=8x58x17&r=1920x1080x24x24&rn=1458979097921&pclick=accueil_particuliers&s2click=1

$request = Request::createFromGlobals();

$alloweds = array(
    "truc",
    'commander::boutique_web_du_timbre::commander_des_timbres_courants'
);

$fh = fopen(__DIR__.'/logs/log.txt', 'a+');

echo $request->getPathinfo();

$urlReele = str_replace('http://prototype-tag-onetest.c9users.io/proxy.php', 'http://logc406.xiti.com/hit.xiti', $request->getUri());

$tagName = $request->query->get('p', false);

if(in_array($tagName, $alloweds))
{
    fwrite($fh, '\e[32m TAG AUTORISER '.$tagName.'  \e[0m'.PHP_EOL);
    fwrite($fh, '\e[33m CALL '.$urlReele.'\e[0m'.PHP_EOL);
}
else
{
    fwrite($fh, '\e[31m TAG BLOQUER '.$tagName.'  \e[0m'.PHP_EOL);
}



fclose($fh);