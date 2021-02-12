<?php

namespace App\Model;
use App\Database\ConfigDatabase;

class UsersManager
{

  public function __construct()
  {
    $this->databaseConnexion = new ConfigDatabase();
    $this->database = $this->databaseConnexion->getConnexion();
  }


  public function loginUser($mailToVerify, $passwordToVerify){
    $request = $this->database->prepare("SELECT id, mail, password from users WHERE mail=:mail");
    $request->execute(["mail" => $mailToVerify]); 
    $user = $request->fetch();
    if(empty($user)){
      return(['n']);
    }
    else{
      $password = $user['password'];
      if(password_verify($passwordToVerify, $password)){
        return(['y', $user['id']]);
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

}