<?php

namespace App\Controller;
use App\Service\TwigRender;


class FrontendController
{
    private $renderer;
    private $verif;
    private $loginManager;
    private $postManager;
    private $commentManager;
    private $formManager;

    public function __construct()
    {
        // $this->verif = new FunctionValidator();
        $this->renderer = new TwigRender();
        // $this->loginManager = new LoginAccountManager();
        // $this->postManager = new PostManager();
        // $this->commentManager = new CommentManager();
        // $this->formManager = new FormManager();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function homepageView()
    {
        $this->renderer->render('homepage');
    }

    public function PostsView()
    {
        $this->renderer->render('posts');
    }

    public function sendMail()
    {
        if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['email']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash']['danger'] = 'Tous les champs ne sont pas remplis ou corrects.';
        } else {
            $nom = strip_tags(htmlspecialchars($_POST['nom']));
            $prenom = strip_tags(htmlspecialchars($_POST['prenom']));
            $email = strip_tags(htmlspecialchars($_POST['email']));
            $message = strip_tags(htmlspecialchars($_POST['message']));
            $headers = "From: VotreGmailId@gmail.com";
            $dest = "tristan.meillat@sfr.fr";
            $sujet = "message de " . $nom . $prenom;

            if (mail($dest, $sujet, $$message, $headers)) {
              echo "Email envoyé avec succès à $dest ...";
            } else {
              echo "Échec de l'envoi de l'email...";
            }
        }
    }

    public function connexionView(){
        $this->renderer->render('connexion');
    }

    public function inscriptionView(){
        $this->renderer->render('inscription');
    }
}