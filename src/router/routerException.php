<?php 

namespace App\router;

use App\Service\TwigRender;

class RouterException{

  private $renderer;    

  public function __construct()
  {
    $this->renderer = new TwigRender();
  }

  public function error404(){
    $this->renderer->render('404');
  }
}
