<?php

namespace App\Controller;

use App\Database\ConfigDatabase;
use App\Service\TwigRender;

class FrontendController
{
    private $renderer;
    private $verif;
    private $loginManager;
    private $postManager;
    private $commentManager;
    private $formManager;
    private $databaseConnexion;
    private $database;

    public function __construct()
    {
        // $this->verif = new FunctionValidator();
        $this->renderer = new TwigRender();
        $this->databaseConnexion = new ConfigDatabase();
        $this->database = $this->databaseConnexion->getConnexion();
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
        if(isset($_SESSION['successMessage'])){
            if($_SESSION['successMessage'] == "y"){
                $successMessage = "Votre inscription à bien été prise en compte, bienvenue !";
                unset($_SESSION['successMessage']);
                $this->renderer->render('inscription', ["successMessage" => $successMessage, "class" => "successMessage"]);
            }
            else if($_SESSION['successMessage'] == "n"){
                $successMessage = 'Une erreur est survenu, veuillez réessayer.';
                unset($_SESSION['successMessage']);
                $this->renderer->render('inscription', ["successMessage" => $successMessage, "class" => "errorMessage"]);
            }
        }
        else{
            $this->renderer->render('inscription');
        }
        
    }

    public function inscriptionRequest(){
        $name = $_POST['nom'];
        $firstname = $_POST['prenom'];
        $mail = $_POST['mail'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $request = $this->database->prepare("INSERT INTO users (firstname, name, mail, password) VALUES (:firstname, :name, :mail, :password)");
        $params = [':firstname' => $firstname, ':name' => $name, ':mail' => $mail, ':password' => $password];
        if($request->execute($params)){
            $_SESSION['successMessage'] = "y";
            header( "Location: /portfolio/inscription" );
        }
        else{
            $_SESSION['successMessage'] = "n";
            header( "Location: /portfolio/inscription" );
            // $this->renderer->render('inscription', ['errorMessage' => 'Une erreur est survenu, veuillez réessayer.']);
            // Votre inscription à bien été prise en compte, bienvenue !
        }
    }
}