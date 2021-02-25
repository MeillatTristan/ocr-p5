<?php

namespace App\Manager;
use App\Database\ConfigDatabase;
use App\Model\commentModel;

class CommentsManager
{

  public function __construct()
  {
    $this->databaseConnexion = new ConfigDatabase();
    $this->database = $this->databaseConnexion->getConnexion();
  }
  
  public function createComment($idPost, $content, $author, $date){

    $request = $this->database->prepare("INSERT INTO comments (author, content, idPost, date) VALUES (:author, :content, :idPost, :date)");
    $params = [':content' => $content, ':idPost' => $idPost,':author' => $author, ':date' => $date];
    if($request->execute($params)){
      return("y");
    }
    return('n');
  }

  public function getComments(){
    $request = $this->database->query("SELECT * FROM comments");
    $comments = $request->fetchAll();
    $commentsObjects = [];
    foreach ($comments as $comment) {
      $commentObject = new CommentModel($comment['id'], $comment['content'], $comment['author'], $comment['date'], $comment['idPost'], $comment['validate']);
      $commentsObjects[] = $commentObject;
    }
    return $commentsObjects;
  }

  public function getComment($idComment){
    $request = $this->database->query("SELECT * FROM comments WHERE id = $idComment");
    $comment = $request->fetch();
    $commentObject = new CommentModel($comment['id'], $comment['content'], $comment['author'], $comment['date'], $comment['idPost'], $comment['validate']);
    return $commentObject;
  }

  public function validateComment($idComment){
    $comment = $this->getComment($idComment);
    if($comment->validate == "y"){
      $request = $this->database->prepare("UPDATE comments SET validate = :validate WHERE id = :id");
      $params = [':validate' => "n", "id" => $idComment];
      $request->execute($params);
    }
    $request = $this->database->prepare("UPDATE comments SET validate = :validate WHERE id = :id");
    $params = [':validate' => "y", "id" => $idComment];
    $request->execute($params);
  }

public function deleteComment($idComment){
    $request = $this->database->prepare("DELETE FROM comments WHERE id=:id");
    $params = [':id' => $idComment];
    if($request->execute($params)){
      return('y');
    }
      return('n');
  }

}