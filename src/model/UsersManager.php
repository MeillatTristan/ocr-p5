<?php

namespace App\Model;
use App\Database\ConfigDatabase;
use App\Model\UserModel;

class UsersManager
{

  public function __construct()
  {
    $this->databaseConnexion = new ConfigDatabase();
    $this->database = $this->databaseConnexion->getConnexion();
  }


  public function loginUser($mailToVerify, $passwordToVerify){
    $request = $this->database->prepare("SELECT * from users WHERE mail=:mail");
    $request->execute(["mail" => $mailToVerify]); 
    $user = $request->fetch();
    if(empty($user)){
      return(['n']);
    }
    else{
      $password = $user['password'];
      if(password_verify($passwordToVerify, $password)){
        $userBdd = new UserModel($user['id'], $user['firstname'], $user['name'], $user['mail'], $user['admin']);
        return(['y', $userBdd]);
      }
      else{
        return(['n']);
      }
    }
  }
  
  public function createUser($name, $firstname, $mail, $password){
    // check if mail already used
    $check = $this->database->prepare("SELECT * FROM users WHERE mail=:mail");
    $check->execute(["mail" => $mail]); 
    $user = $check->fetch();
    if(!empty($user)){
      return('e');
    }

    $request = $this->database->prepare("INSERT INTO users (firstname, name, mail, password) VALUES (:firstname, :name, :mail, :password)");
    $params = [':firstname' => $firstname, ':name' => $name, ':mail' => $mail, ':password' => $password];
    if($request->execute($params)){
      return("y");
    }
    else{
      return('n');
    }
  }

  public function getUsers(){
    $request = $this->database->query('SELECT * FROM users')->fetchAll();
    $usersArray = [];
    foreach ($request as $user) {
      $usersArray[] = new UserModel($user['id'], $user['firstname'], $user['name'], $user['mail'], $user['admin']);
    }
    return $usersArray;
  }
  
  public function getUser($id){
    $user = $this->database->query("SELECT * FROM users WHERE id = $id")->fetch();
    $user = new UserModel($user['id'], $user['firstname'], $user['name'], $user['mail'], $user['admin']);
    return $user;
  }

  public function rightChange($id){
    $user = $this->getUser($id);
    if($user->admin == 'y'){
      $request = $this->database->prepare('UPDATE users SET admin = :admin WHERE id = :id ');
      $params = [':admin' => 'n', ':id' => $id];
      $request->execute($params);
    }
    else{
      $request = $this->database->prepare('UPDATE users SET admin = :admin WHERE id = :id ');
      $params = [':admin' => 'y', ':id' => $id];
      $request->execute($params);
    }
  }
  
  public function deleteUser($id){
    $request = $this->database->prepare("DELETE FROM users WHERE id=:id");
    $params = [':id' => $id];
    $request->execute($params);
  }

}