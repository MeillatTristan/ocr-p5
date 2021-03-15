<?php

namespace App\Model;

/**
 * create a object of user
 */
class CommentModel
{
    public $id;
    public $content;
    public $author;
    public $dateCreate;
    public $idPost;
    public $validate;

    public function __construct($id, $content, $author, $dateCreate, $idPost, $validate)
    {
        $this->id = $id;
        $this->content = $content;
        $this->author = $author;
        $this->dateCreate = $dateCreate;
        $this->validate = $validate;
        $this->idPost = $idPost;
    }
}
