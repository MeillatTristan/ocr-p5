<?php

require "vendor/autoload.php";

// die($_GET['url']);   

$router = new App\router\Router($_GET['url']);

$router->get('/posts', function(){ echo 'ceci est la page posts';});

$router->get('/posts/:id', function($id){echo "afficher l'article " . $id; });
$router->post('/posts/:id', function($id){echo "poster l'article " . $id; });

$router->run();