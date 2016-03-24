<?php

use Artack\DOMQuery\DOMQuery;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require "vendor/autoload.php";

$slugify = new Slugify();

$config = json_decode(file_get_contents(__DIR__."/config.json"), true);

class TagInjector {

    protected $slugify;
    
    protected $dom;
    
    protected $config;
    
    public function __construct($slugify, $dom, array $config)
    {
        $this->slugify = $slugify;
        
        $this->dom = $dom;
        
        $this->config = $config;
    }
    
    public function placeholderRender($texte, $element)
    {
         $replace = array(
            "#text#" => $this->slugify->slugify($element->getInnerHtml())
         );
    
         return str_replace(array_keys($replace), array_values($replace), $texte);
    }
    
    public function inject()
    {
        foreach($this->config as $tagConfiguration)
        {
           $domElementCollection = $this->dom->find($tagConfiguration['selecteur']);
        
           foreach($domElementCollection as $domElement)
           {
               foreach($tagConfiguration['attr'] as $key => $value)
               {
                    $domElement->setAttribute($key, $this->placeholderRender($value, $domElement));
               }  
           }
        
        }
    }
    
    public function getDom()
    {
        return $this->dom;
    }
}

class TagInjectorFactory {
    
    protected $config;
    
    protected $slugify;
    
    public function __construct($slugify, $config)
    {
        $this->slugify = $slugify;
        
        $this->config = $config;
    }
    
    public function findConfigByRequest($request)
    {
        foreach($this->config['firewall'] as $firewall)
        {
            if(preg_match('#'.$firewall['pattern'].'#i', $request->getPathinfo())) {
                return $firewall['tags'];
            }
        }
        
        return array();
    }
    
    public function factory($request, $response)
    {
        $dom = DOMQuery::create($response->getContent());
        
        $dom->find('a')->setStyle('border', 'solid red 2px');
        
        return new TagInjector($this->slugify, $dom, $this->findConfigByRequest($request));
    }
}
 
//$pageWeb = file_get_contents("static/bootstrap.html");
$pageWeb = file_get_contents("static/laposte.html");

// On construit la requête et la réponse
$request = Request::create('/test');
$response = new Response($pageWeb);

$tagInjectorFactory = new TagInjectorFactory($slugify, $config);

$tagInjector = $tagInjectorFactory->factory($request, $response);

$tagInjector->inject();

echo $tagInjector->getDom()->getHtml();
