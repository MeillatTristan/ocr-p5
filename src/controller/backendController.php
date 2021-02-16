<?php 

namespace App\Controller;

use App\Service\TwigRender;
use App\Model\UsersManager;

class backendController{
  private $renderer;
  private $usersManager;

  public function __construct()
  {
    $this->renderer = new TwigRender();
    $this->usersManager = new UsersManager();

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION['user'])){
      header('Location: /portfolio');
      exit();
    }
    if($_SESSION['user']->admin != 'y'){
      header('Location: /portfolio');
      exit();
    }
  }


  public function adminPostsView(){
    $this->renderer->render('adminPosts');
  }

  public function adminPostFormView(){
    $this->renderer->render('adminPostForm');
  }

}