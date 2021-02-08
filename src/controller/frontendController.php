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
}