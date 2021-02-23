<?php

require "vendor/autoload.php";

// init routing

if (empty($_GET['url'])) {
    $_GET['url'] = '/';
}

$router = new App\Router\Router($_GET['url']);


// creating routes



// routes frontend
$router->get('/', 'frontend#homepageView');
$router->get('/posts', 'frontend#PostsView');
$router->get('posts/:id', 'frontend#postView');
$router->post('/contactForm', 'frontend#sendmail');
$router->get('/connexion', 'frontend#connexionView');
$router->get('/inscription', 'frontend#inscriptionView');
$router->post('/inscriptionRequest', 'frontend#inscriptionRequest');
$router->post('/connexionRequest', 'frontend#connexionRequest');
$router->get('/deconnexion', 'frontend#deconnexionRequest');

// routes backend
$router->get('/adminPosts', 'backend#adminPostsView');
$router->get('/adminPostForm', 'backend#adminPostFormView');
$router->post('/postsRequest', 'backend#postAddRequest');
$router->get('/adminPostFormModif/:id', 'backend#modifPostView');
$router->post('/modifPostRequest/:id', 'backend#modifPostRequest');
$router->get('/adminPostDelete/:id', 'backend#deletePost');
$router->post('commentRequest/:id', 'backend#commentRequest');
$router->get('/ManageCommentaire', 'backend#manageComment');
$router->get('/ManageCommentaireValid/:id', 'backend#manageCommentValid');
$router->get('/commentDelete/:id', 'backend#deleteComment');
$router->get('/manageUsers', 'backend#manageUsers');
$router->get('/adminRightChange/:id', 'backend#adminRightChange');



$router->get('/posts/:id', function($id){echo "afficher l'article " . $id; });
$router->post('/posts/:id', function($id){echo "poster l'article " . $id; });

$router->run();