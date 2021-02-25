<?php 

namespace App\Model;

class PostModel{
  public $id;
  public $title;
  public $chapo;
  public $thumbnail;
  public $content;
  public $author;
  public $lastModif;
  public $dateCreate;

  public function __construct($id, $title, $chapo, $thumbnail, $content, $author, $lastModif, $dateCreate){
    $this->id = $id;
    $this->title = $title;
    $this->chapo = $chapo;
    $this->thumbnail = $thumbnail;
    $this->content = $content;
    $this->author = $author;
    $this->lastModif = $lastModif;
    $this->dateCreate = $dateCreate;
  }
}
