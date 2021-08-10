<?php

namespace App\Controller;

use App\Service\TwigRender;
use App\Manager\UsersManager;
use DateTime;
use App\Manager\PostsManager;
use App\Manager\CommentsManager;

/**
 * backendController manage all the backoffice
 */
class BackendController
{
    private $renderer;
    private $usersManager;
    private $postsManager;

    /**
     * instancie all method necessary
     */
    public function __construct()
    {
        $this->renderer = new TwigRender();
        $this->usersManager = new UsersManager();
        $this->postsManager = new PostsManager();
        $this->commentsManager = new CommentsManager();

        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: /portfolio');
        }
        if ($_SESSION['user']->admin != 'y') {
            header('Location: /portfolio');
        }
    }

    /**
     * render posts view admin page
     */
    public function adminPostsView()
    {
        $posts = $this->postsManager->getPosts();
        $this->renderer->render('adminPosts', ['posts' => $posts]);
    }

    /**
     * render adding page post form
     */
    public function adminPostFormView()
    {
        if (isset($_SESSION['successMessage'])) {
            if ($_SESSION['successMessage'] == "y") {
                $successMessage = "Votre article à bien été posté !";
                unset($_SESSION['successMessage']);
                $this->renderer->render('adminPostForm', ["successMessage" => $successMessage, "class" => "successMessage"]);
            } elseif ($_SESSION['successMessage'] == "n") {
                $successMessage = 'Une erreur est survenu, veuillez réessayer.';
                unset($_SESSION['successMessage']);
                $this->renderer->render('adminPostForm', ["successMessage" => $successMessage, "class" => "errorMessage"]);
            }
            elseif ($_SESSION['successMessage'] == "uniqueTitle") {
                $successMessage = 'Ce titre est déjà utilisé, merci de le changer.';
                unset($_SESSION['successMessage']);
                $this->renderer->render('adminPostForm', ["successMessage" => $successMessage, "class" => "errorMessage"]);
            }
        }
        else{
            $this->renderer->render('adminPostForm');
        }
    }

    /**
     * adding post in database with information of the form
     */
    public function postAddRequest()
    {
        if (isset($_REQUEST['title']) && isset($_REQUEST['chapo']) && isset($_FILES['fileToUpload']) && isset($_REQUEST['content']) && isset($_SESSION['user'])) {
            $title = $_REQUEST['title'];
            $chapo = $_REQUEST['chapo'];
            $thumbmail = $_FILES["fileToUpload"];
            $content = $_REQUEST['content'];
            $author = $_SESSION['user']->firstname . " " . $_SESSION['user']->name;
            $date = new DateTime('NOW');
            $date = $date->format('d/m/Y');
            $return = $this->postsManager->createPost($title, $thumbmail, $content, $chapo, $author, $date);
      
            unset($_FILES["fileToUpload"]);

            if ($return == "y") {
                $_SESSION['successMessage'] = "y";
            }
            elseif ($return == "uniqueTitle") {
                $_SESSION['successMessage'] = "uniqueTitle";
            }
            else{
                $_SESSION['successMessage'] = "n";
            }
            header("Location: /portfolio/adminPostForm");
        }
    }

    /**
     * render form to modify a post
     */
    public function modifPostView($idPost)
    {
        if (isset($_SESSION['successMessage'])) {
            if ($_SESSION['successMessage'] == "y") {
                $successMessage = "Votre article à bien été Modifié !";
                unset($_SESSION['successMessage']);
                $post = $this->postsManager->getPost($idPost);
                $this->renderer->render('adminPostFormModif', ["successMessage" => $successMessage, "class" => "successMessage", 'post' => $post, 'id' => $idPost]);
            } elseif ($_SESSION['successMessage'] == "n") {
                $successMessage = 'Une erreur est survenu, veuillez réessayer.';
                unset($_SESSION['successMessage']);
                $post = $this->postsManager->getPost($idPost);
                $this->renderer->render('adminPostFormModif', ["successMessage" => $successMessage, "class" => "errorMessage", 'post' => $post, 'id' => $idPost]);
            }
        } else {
            $post = $this->postsManager->getPost($idPost);
            $this->renderer->render('adminPostFormModif', ['post' => $post, 'id' => $idPost]);
        }
    }

    /**
     * change in databse the post
     */
    public function modifPostRequest($idPost)
    {
        $title = $_REQUEST['title'];
        $chapo = $_REQUEST['chapo'];

        if ($_FILES['fileToUpload']['name'] != "") {
            $thumbmail = $_FILES["fileToUpload"];
        } else {
            $thumbmail = "n";
        }

        $content = $_REQUEST['content'];
        $date = new DateTime('NOW');
        $date = $date->format('d/m/Y');
        $return = $this->postsManager->modifPost($idPost, $title, $thumbmail, $content, $chapo, $date);
        if ($return == "y") {
            $_SESSION['successMessage'] = "y";
        } else {
            $_SESSION['successMessage'] = "n";
        }
        header("Location: /portfolio/adminPostFormModif/$idPost");
    }

    /**
     * delete a post
     */
    public function deletePost($idPost)
    {
        $return = $this->postsManager->deletePost($idPost);
    
        if ($return == "n") {
            $_SESSION['successMessage'] = "n";
        }
        header("Location: /portfolio/adminPosts");
    }

    /**
     * create a comment in database
     */
    public function commentRequest($idComment)
    {
        if (isset($_REQUEST['comment'])) {
            $content = $_REQUEST['comment'];
            $_SESSION['successMessage'] = "n";
            header("Location: /portfolio/posts/$idComment");
        }
        $author = $_SESSION['user']->firstname . " " . $_SESSION['user']->name;
        $date = new DateTime('NOW');
        $date = $date->format('d/m/Y');

        $return = $this->commentsManager->createComment($idComment, $content, $author, $date);

        if ($return == "y") {
            $_SESSION['successMessage'] = "y";
        } else {
            $_SESSION['successMessage'] = "n";
        }
        header("Location: /portfolio/posts/$idComment");
    }

    /**
     * render page manage comment
     */
    public function manageComment()
    {
        $comments = $this->commentsManager->getComments();
        $this->renderer->render('adminComment', ['comments' => $comments]);
    }

    /**
     * inverse validation of comment
     */
    public function manageCommentValid($idComment)
    {
        $this->commentsManager->validateComment($idComment);
        header("Location: /portfolio/manageCommentaire");
    }

    /**
     * delete a comment in database
     */
    public function deleteComment($idComment)
    {
        $this->commentsManager->deleteComment($idComment);
        header("Location: /portfolio/manageCommentaire");
    }

    /**
     * render page manage user
     */
    public function manageUsers()
    {
        $users = $this->usersManager->getUsers();
        $this->renderer->render('adminUsers', ['users' => $users]);
    }

    /**
     * change admin right of a user
     */
    public function adminRightChange($idUser)
    {
        $this->usersManager->rightChange($idUser);
        header("Location: /portfolio/manageUsers");
    }

    /**
     * delete a user
     */
    public function deleteUser($idUser)
    {
        $this->usersManager->deleteUser($idUser);
        header("Location: /portfolio/manageUsers");
    }
}
