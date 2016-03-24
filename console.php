<?php

use Artack\DOMQuery\DOMQuery;
use Cocur\Slugify\Slugify;

require "vendor/autoload.php";

$config = json_decode(file_get_contents(__DIR__."/config.json"), true);

foreach($config['firewall'] as $firewall)
{
    echo "[PAGE GROUP] ".$firewall['description'].' correspondant au pattern '.$firewall['pattern'].' '.PHP_EOL;
    
    echo "[PAGE] ".$firewall['test']['url'].PHP_EOL;
    
    echo '---> [CODE STATUS] 200 OK'.PHP_EOL;
    
    if(!preg_match('#'.$firewall['pattern'].'#i', $firewall['test']['url'])) {
        echo '---> [ERROR] PATTERN NOT MATCHING'.PHP_EOL;
    }
    else {
        echo '---> [SUCCESS] PATTERN MATCHING'.PHP_EOL;
    }
    
    foreach($firewall['tags'] as $tag)
    {
        echo "-------> [TAG] ".$tag['description'].PHP_EOL;
    }
}