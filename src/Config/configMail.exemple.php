<?php

namespace App\Config;

return array(
  $Host       = 'smtp.exemple.com',                     //Set the SMTP server to send through
  $Username   = 'exemple@exemple.com',                     //SMTP username
  $Password   = 'exemple',                               //SMTP password
  $Port       = 465,                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
);