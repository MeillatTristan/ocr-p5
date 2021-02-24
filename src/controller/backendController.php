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
    else{
        $this->renderer->render('adminPostForm');
    }
  }

  public function postAddRequest(){
    $title = $_REQUEST['title'];
    $chapo = $_REQUEST['chapo'];
    $thumbmail = $_FILES["fileToUpload"];
    $content = $_REQUEST['content'];
    echo $content;
    $author = $_SESSION['user']->firstname . " " . $_SESSION['user']->name;
    $date = new DateTime('NOW');
    $date = $date->format('d/m/Y');
    $return = $this->postsManager->createPost($title, $thumbmail, $content, $chapo, $author, $date);
     
    unset($_FILES["fileToUpload"]);

    if($return == "y"){
      $_SESSION['successMessage'] = "y";
    }
    else{
        $_SESSION['successMessage'] = "n";
    }
    header( "Location: /portfolio/adminPostForm" );
  }

  public function modifPostView($id){
    if(isset($_SESSION['successMessage'])){
      if($_SESSION['successMessage'] == "y"){
          $successMessage = "Votre article à bien été Modifié !";
          unset($_SESSION['successMessage']);
          $post = $this->postsManager->getPost($id);
          $this->renderer->render('adminPostFormModif', ["successMessage" => $successMessage, "class" => "successMessage", 'post' => $post, 'id' => $id]);
      }
      else if($_SESSION['successMessage'] == "n"){
          $successMessage = 'Une erreur est survenu, veuillez réessayer.';
          unset($_SESSION['successMessage']);
          $post = $this->postsManager->getPost($id);
          $this->renderer->render('adminPostFormModif', ["successMessage" => $successMessage, "class" => "errorMessage", 'post' => $post, 'id' => $id]);
      }
    }
    else{
      $post = $this->postsManager->getPost($id);
      $this->renderer->render('adminPostFormModif', ['post' => $post, 'id' => $id]);
    }
  }

  public function modifPostRequest($id){
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
    $return = $this->postsManager->modifPost($id, $title, $thumbmail, $content, $chapo, $date);
    if($return == "y"){
      $_SESSION['successMessage'] = "y";
    }
    else{
        $_SESSION['successMessage'] = "n";
    }
    header( "Location: /portfolio/adminPostFormModif/$id" );
  }

  public function deletePost($id){
    $return = $this->postsManager->deletePost($id);
    
    if($return == "n"){
      $_SESSION['successMessage'] = "n";
    }
    header( "Location: /portfolio/adminPosts" );
  }

  public function commentRequest($idPost){
    $content = $_REQUEST['comment'];
    $author = $_SESSION['user']->firstname . " " . $_SESSION['user']->name;
    $date = new DateTime('NOW');
    $date = $date->format('d/m/Y');

    $return = $this->commentsManager->createComment($idPost, $content, $author, $date);

    if($return == "y"){
      $_SESSION['successMessage'] = "y";
    }
    else{
        $_SESSION['successMessage'] = "n";
    }
    header( "Location: /portfolio/posts/$idPost" );
  }

  public function manageComment(){
    $comments = $this->commentsManager->getComments();
    $this->renderer->render('adminComment', ['comments' => $comments]);
  }

  public function manageCommentValid($id){
    $this->commentsManager->validateComment($id);
    header( "Location: /portfolio/manageCommentaire" );

  }

  public function deleteComment($id){
    $this->commentsManager->deleteComment($id);
    header( "Location: /portfolio/manageCommentaire" );
  }

  public function manageUsers(){
    $users = $this->usersManager->getUsers();
    $this->renderer->render('adminUsers', ['users' => $users]);
  }

  public function adminRightChange($id){
    $this->usersManager->rightChange($id);
    header("Location: /portfolio/manageUsers");
  }

  public function deleteUser($id){
    $this->usersManager->deleteUser($id);
    header("Location: /portfolio/manageUsers");
  }

}