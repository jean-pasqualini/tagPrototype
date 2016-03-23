<?php

use Artack\DOMQuery\DOMQuery;
use Cocur\Slugify\Slugify;

require "vendor/autoload.php";

$slugify = new Slugify();

$config = json_decode(file_get_contents("config.json"), true);

$html = file_get_contents("static.html");

$dom = DOMQuery::create($html);

$dom->find('a')->setStyle('border', 'solid red 2px');

class TagInjector {

protected $slugify;

public function __construct($slugify)
{

$this->slugify = $slugify;

}

public function placeholderRender($texte, $element)
{
     $replace = array(
        "#text#" => $this->slugify->slugify($element->getInnerHtml())
     );

     return str_replace(array_keys($replace), array_values($replace), $texte);
}

}

$tagInjector = new TagInjector($slugify);

foreach($config as $elementSelector => $attributes)
{
   $domElementCollection = $dom->find($elementSelector);

   foreach($domElementCollection as $domElement)
   {
   foreach($attributes as $key => $value)
   {
        $domElement->setAttribute($key, $tagInjector->placeholderRender($value, $domElement));
   }  

   }

}

echo $dom->getHtml();
