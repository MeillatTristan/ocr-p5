<?php

require "vendor/autoload.php";

use App\Router\Router;

// init routing

if (empty($_GET['url'])) {
    $_GET['url'] = '/';
}

$router = new Router($_GET['url']);


// creating routes



// routes frontend
$router->get('/', 'Frontend#homepageView');
$router->post('/sendmail', 'Frontend#sendmail');
$router->get('/posts', 'Frontend#postsView');
$router->get('posts/:id', 'Frontend#postView');
$router->post('/contactForm', 'Frontend#sendmail');
$router->get('/connexion', 'Frontend#connexionView');
$router->get('/inscription', 'Frontend#inscriptionView');
$router->post('/inscriptionRequest', 'Frontend#inscriptionRequest');
$router->post('/connexionRequest', 'Frontend#connexionRequest');
$router->get('/deconnexion', 'Frontend#deconnexionRequest');
$router->get('mentions-legales', 'Frontend#mentionsLegalesView');

// routes backend
$router->get('/adminPosts', 'Backend#adminPostsView');
$router->get('/adminPostForm', 'Backend#adminPostFormView');
$router->post('/postsRequest', 'Backend#postAddRequest');
$router->get('/adminPostFormModif/:id', 'Backend#modifPostView');
$router->post('/modifPostRequest/:id', 'Backend#modifPostRequest');
$router->get('/adminPostDelete/:id', 'Backend#deletePost');
$router->post('commentRequest/:id', 'Backend#commentRequest');
$router->get('/ManageCommentaire', 'Backend#manageComment');
$router->get('/ManageCommentaireValid/:id', 'Backend#manageCommentValid');
$router->get('/commentDelete/:id', 'Backend#deleteComment');
$router->get('/manageUsers', 'Backend#manageUsers');
$router->get('/adminRightChange/:id', 'Backend#adminRightChange');
$router->get('/deleteUser/:id', 'Backend#deleteUser');

$router->run();
