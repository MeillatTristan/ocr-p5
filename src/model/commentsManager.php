<?php

namespace App\Model;
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
    else{
      return('n');
    }
  }

  public function getComments(){
    $request = $this->database->query("SELECT * FROM comments");
    $comments = $request->fetchAll();
    $commentsObjects = [];
    foreach ($comments as $comment) {
      $commentObject = new commentModel($comment['id'], $comment['content'], $comment['author'], $comment['date'], $comment['idPost'], $comment['validate']);
      $commentsObjects[] = $commentObject;
    }
    return $commentsObjects;
  }

  public function getPost($id){
    $request = $this->database->query("SELECT * FROM posts WHERE id = $id");
    $post = $request->fetch();
    $postObject = new PostModel($post['id'], $post['title'], $post['chapo'], $post['thumbnail'], $post['description'], $post['author'], $post['lastMaj'], $post['dateCreation']);
    return $postObject;
  }

  public function modifPost($id, $title, $thumbnail, $description, $chapo, $date){
    if($thumbnail != "n"){
      $target_dir = "C:/wamp64/www/portfolio/public/assets/images/";
      $thumbnail['name'] = $title . "-" . $thumbnail['name'];
      $target_file = $target_dir . basename($thumbnail["name"]);

      if (!move_uploaded_file($thumbnail["tmp_name"], $target_file)) {
        return('n');
      }

      $request = $this->database->prepare("UPDATE posts SET title = :title, thumbnail = :thumbnail, description = :description, chapo = :chapo, lastMaj = :lastMaj WHERE id = :id");
      $params = [':id' => $id, ':title' => $title, ':thumbnail' => $thumbnail['name'], ':description' => $description, ':chapo' => $chapo, ':lastMaj' => $date];
      if($request->execute($params)){
        return("y");
      }
      else{
        return('n');
      }
    }
    $request = $this->database->prepare("UPDATE posts SET title = :title, description = :description, chapo = :chapo, lastMaj = :lastMaj WHERE id = :id");
    $params = [':id' => $id, ':title' => $title, ':description' => $description, ':chapo' => $chapo, ':lastMaj' => $date];
    if($request->execute($params)){
      return("y");
    }
    else{
      return('n');
    }
  }

  public function deletePost($id){
    $request = $this->database->prepare("DELETE FROM posts WHERE id=:id");
    $params = [':id' => $id];
    if($request->execute($params)){
      return('y');
    }
    else{
      return('n');
    }

  }

}