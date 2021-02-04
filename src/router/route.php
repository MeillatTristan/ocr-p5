<?php

namespace App\router;

class Route{

    private $path;
    private $callable;

    public function __construct($path, $callable){


        $this->path = trim($path, '/');
        $this->callable = $callable;


    }

    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false; 
        }
        array_shift($matches);
        $this->matches = $matches;  // On sauvegarde les paramètre dans l'instance pour plus tard
        return true;
    }

    public function call(){
        return call_user_func_array($this->callable, $this->matches);
    }

}