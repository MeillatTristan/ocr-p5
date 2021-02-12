<?php

require "vendor/autoload.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// init routing

if (empty($_GET['url'])) {
    $_GET['url'] = '/';
}

$router = new App\Router\Router($_GET['url']);


// creating routes



// routes
$router->get('/', 'frontend#homepageView');
$router->get('/posts', 'frontend#PostsView');
$router->post('/contactForm', 'frontend#sendmail');
$router->get('/connexion', 'frontend#connexionView');
$router->get('/inscription', 'frontend#inscriptionView');
$router->post('/inscriptionRequest', 'frontend#inscriptionRequest');
$router->post('/connexionRequest', 'frontend#connexionRequest');
$router->get('/deconnexion', 'frontend#deconnexionRequest');

$router->get('/posts/:id', function($id){echo "afficher l'article " . $id; });
$router->post('/posts/:id', function($id){echo "poster l'article " . $id; });

$router->run();