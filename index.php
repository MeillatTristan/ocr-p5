<?php

require "vendor/autoload.php";

use App\controller\homeController;

use function App\controller\homeController\HomeControllerRender;


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// init routing

if (empty($_GET['url'])) {
    $_GET['url'] = '/';
}

$router = new App\Router\Router($_GET['url']);

// creating routes

// $router->get('/', function(){ echo $twig->render('homepage.html.twig') ;});

// $homeController = HomeControllerRender();
// $router->get('/', $homeController);

// Homme and Deco
$router->get('/', 'frontend#homepageView');

$router->get('/posts', function(){ echo "page posts"; });

$router->get('/posts/:id', function($id){echo "afficher l'article " . $id; });
$router->post('/posts/:id', function($id){echo "poster l'article " . $id; });

$router->run();