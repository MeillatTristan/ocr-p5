<?php 

namespace App\Controller;

use App\Service\TwigRender;
use App\Manager\UsersManager;
use DateTime;
use App\Manager\PostsManager;
use App\Manager\CommentsManager;

class backendController{
  private $renderer;
  private $usersManager;
  private $postsManager;

  public function __construct()
  {
    $this->renderer = new TwigRender();
    $this->usersManager = new UsersManager();
    $this->postsManager = new PostsManager();
    $this->commentsManager = new CommentsManager();

    if (!isset($_SESSION)) {
        session_start();
    }

    if(!isset($_SESSION['user'])){
      header('Location: /portfolio');
    }
    if($_SESSION['user']->admin != 'y'){
      header('Location: /portfolio');
    }
  }


  public function adminPostsView(){
    $posts = $this->postsManager->getPosts();
    $this->renderer->render('adminPosts', ['posts' => $posts]);
  }

  public function adminPostFormView(){
    if(isset($_SESSION['successMessage'])){
      if($_SESSION['successMessage'] == "y"){
          $successMessage = "Votre article à bien été posté !";
          unset($_SESSION['successMessage']);
          $this->renderer->render('adminPostForm', ["successMessage" => $successMessage, "class" => "successMessage"]);
      }
      else if($_SESSION['successMessage'] == "n"){
          $successMessage = 'Une erreur est survenu, veuillez réessayer.';
          unset($_SESSION['successMessage']);
          $this->renderer->render('adminPostForm', ["successMessage" => $successMessage, "class" => "errorMessage"]);
      }
    }
    $this->renderer->render('adminPostForm');
  }

  public function postAddRequest(){
    if(isset($_REQUEST['title']) and isset($_REQUEST['chapo']) and isset($_FILES['fileToUpload']) and isset($_REQUEST['content']) and isset($_SESSION['user'])){
      $title = $_REQUEST['title'];
      $chapo = $_REQUEST['chapo'];
      $thumbmail = $_FILES["fileToUpload"];
      $content = $_REQUEST['content'];
      $author = $_SESSION['user']->firstname . " " . $_SESSION['user']->name;
      $date = new DateTime('NOW');
      $date = $date->format('d/m/Y');
      $return = $this->postsManager->createPost($title, $thumbmail, $content, $chapo, $author, $date);
      
      unset($_FILES["fileToUpload"]);

      if($return == "y"){
        $_SESSION['successMessage'] = "y";
      }

      $_SESSION['successMessage'] = "n";

      header( "Location: /portfolio/adminPostForm" );
    }
    header("Location: /portfolio/");
    
  }

  public function modifPostView($idPost){
    if(isset($_SESSION['successMessage'])){
      if($_SESSION['successMessage'] == "y"){
          $successMessage = "Votre article à bien été Modifié !";
          unset($_SESSION['successMessage']);
          $post = $this->postsManager->getPost($idPost);
          $this->renderer->render('adminPostFormModif', ["successMessage" => $successMessage, "class" => "successMessage", 'post' => $post, 'id' => $idPost]);
      }
      else if($_SESSION['successMessage'] == "n"){
          $successMessage = 'Une erreur est survenu, veuillez réessayer.';
          unset($_SESSION['successMessage']);
          $post = $this->postsManager->getPost($idPost);
          $this->renderer->render('adminPostFormModif', ["successMessage" => $successMessage, "class" => "errorMessage", 'post' => $post, 'id' => $idPost]);
      }
    }
    else{
      $post = $this->postsManager->getPost($idPost);
      $this->renderer->render('adminPostFormModif', ['post' => $post, 'id' => $idPost]);
    }
  }

  public function modifPostRequest($idPost){
    $title = $_REQUEST['title'];
    $chapo = $_REQUEST['chapo'];

    if($_FILES['fileToUpload']['name'] != ""){
      $thumbmail = $_FILES["fileToUpload"];
    }
    else{
      $thumbmail = "n";
    }

    $content = $_REQUEST['content'];
    $date = new DateTime('NOW');
    $date = $date->format('d/m/Y');
    $return = $this->postsManager->modifPost($idPost, $title, $thumbmail, $content, $chapo, $date);
    if($return == "y"){
      $_SESSION['successMessage'] = "y";
    }
    else{
        $_SESSION['successMessage'] = "n";
    }
    header( "Location: /portfolio/adminPostFormModif/$idPost" );
  }

  public function deletePost($idPost){
    $return = $this->postsManager->deletePost($idPost);
    
    if($return == "n"){
      $_SESSION['successMessage'] = "n";
    }
    header( "Location: /portfolio/adminPosts" );
  }

  public function commentRequest($idComment){
    if(isset($_REQUEST['comment'] )){
      $content = $_REQUEST['comment'];
      $_SESSION['successMessage'] = "n";
      header( "Location: /portfolio/posts/$idComment" );
    }
    $author = $_SESSION['user']->firstname . " " . $_SESSION['user']->name;
    $date = new DateTime('NOW');
    $date = $date->format('d/m/Y');

    $return = $this->commentsManager->createComment($idComment, $content, $author, $date);

    if($return == "y"){
      $_SESSION['successMessage'] = "y";
    }
    else{
        $_SESSION['successMessage'] = "n";
    }
    header( "Location: /portfolio/posts/$idComment" );
  }

  public function manageComment(){
    $comments = $this->commentsManager->getComments();
    $this->renderer->render('adminComment', ['comments' => $comments]);
  }

  public function manageCommentValid($idComment){
    $this->commentsManager->validateComment($idComment);
    header( "Location: /portfolio/manageCommentaire" );

  }

  public function deleteComment($idComment){
    $this->commentsManager->deleteComment($idComment);
    header( "Location: /portfolio/manageCommentaire" );
  }

  public function manageUsers(){
    $users = $this->usersManager->getUsers();
    $this->renderer->render('adminUsers', ['users' => $users]);
  }

  public function adminRightChange($idUser){
    $this->usersManager->rightChange($idUser);
    header("Location: /portfolio/manageUsers");
  }

  public function deleteUser($idUser){
    $this->usersManager->deleteUser($idUser);
    header("Location: /portfolio/manageUsers");
  }

}