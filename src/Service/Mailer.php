<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * return an array with mail information
 */
class Mailer
{
    public $mail;

    public function __construct()
    {
        $data = require __DIR__ . './../Config/configMail.php';
        $this->mail = new PHPMailer();  // Cree un nouvel objet PHPMailer
        $this->mail->IsSMTP(); // active SMTP
        $this->mail->SMTPDebug = 0;  // debogage: 1 = Erreurs et messages, 2 = messages seulement
        $this->mail->AuthType = "PLAIN";
        $this->mail->SMTPAuth = true;  // Authentification SMTP active
        $this->mail->SMTPSecure = 'ssl'; // Gmail REQUIERT Le transfert securise
        $this->mail->Host = $data[0];
        $this->mail->Port = $data[3];
        $this->mail->Username = $data[1];
        $this->mail->isHTML(true);   
        $this->mail->Password = $data[2];                               //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    }

    public function sendMail($to, $from, $from_name, $body, $subject){
        $this->mail->SetFrom($from, $from_name);
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        $this->mail->AddAddress($to);
        if(!$this->mail->Send()) {
            return 'Mail error: '.$this->mail->ErrorInfo;
        }
        else{
            return true;
        }    
    }
}
