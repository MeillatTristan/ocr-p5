<?php

namespace App\Controller;

use App\Database\ConfigDatabase;
use App\Service\TwigRender;
use App\Model\UsersManager;

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
        $this->usersManager = new UsersManager();
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
        if(isset($_SESSION['id'])){
            header('Location: /portfolio');
            die();
        }
        if(isset($_SESSION['successMessage'])){
            if($_SESSION['successMessage'] == "n"){
                $successMessage = "Un de vos identifiants est incorrect, veuillez réessayer";
                unset($_SESSION['successMessage']);
                $this->renderer->render('connexion', ["successMessage" => $successMessage, "class" => "errorMessage"]);
            }
            else{
                unset($_SESSION['successMessage']);
            }
        }
        else{
            $this->renderer->render('connexion');
        }
    }

    public function connexionRequest(){
        if(isset($_SESSION['id'])){
            header('Location: /portfolio');
            die();
        }
        $mail = $_REQUEST['mail'];
        $passwordToVerify = $_REQUEST['password'];

        $return = $this->usersManager->loginUser($mail, $passwordToVerify);
        if($return[0] == "y"){
            $_SESSION['id'] = $return[1];
            header('Location: /portfolio');
            return("");
        }
        else{
            $_SESSION['successMessage'] = "n";
        }
        header('Location: /portfolio/connexion');
    }

    public function deconnexionRequest(){
        unset($_SESSION['id']);
        header('Location: /portfolio');
    }

    public function inscriptionView(){
        if(isset($_SESSION['successMessage'])){
            if($_SESSION['successMessage'] == "y"){
                $successMessage = "Votre inscription à bien été prise en compte, bienvenue !";
                unset($_SESSION['successMessage']);
                $this->renderer->render('inscription', ["successMessage" => $successMessage, "class" => "successMessage"]);
            }
            else if(isset($_SESSION['successMessage'])){
                if($_SESSION['successMessage'] == 'e'){
                    $successMessage = "Cette addresse mail est déjà utilisé, désolé.";
                    unset($_SESSION['successMessage']);
                    $this->renderer->render('inscription', ["successMessage" => $successMessage, "class" => "errorMessage"]);
                }
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

        $return = $this->usersManager->createUser($name, $firstname, $mail, $password);
        if($return == "y"){
            $_SESSION['successMessage'] = "y";
        }
        else if($return == 'e'){
            $_SESSION['successMessage'] = "e";
        }
        else{
            $_SESSION['successMessage'] = "n";
        }
        header( "Location: /portfolio/inscription" );
    }
}