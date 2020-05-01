<?php

class Mail {
  const CAMAGRU_EMAIL = "camagru.jergauth.42@gmail.com";
  const HEADERS = [
    'From' => self::CAMAGRU_EMAIL,
    'Reply-To' => self::CAMAGRU_EMAIL,
    'MIME-Version' => '1.0',
    'Content-Type' => 'text/html;'
  ];
  
  function __construct() {
    ini_set("SMTP", "smtp.gmail.com");
    ini_set("sendmail_from", self::CAMAGRU_EMAIL);
    ini_set("smtp_port", "587");
  }

  private function send($to, $subject, $message) {
    mail($to, $subject, $message, self::HEADERS);
  }
  
  function newAccount($to, $hash) {
    $subject = "Confirmation de votre compte";
    $link = "127.0.0.1:8888/server/handlers/confirmation.php?key=" . $hash . "&email=" . $to;
    $message = "
      <html>
        <body>
          <h1>Camagru</h1>
          <hr />
          <p>Pour confirmer votre inscription, merci de valider votre compte en utilisant le lien suivant:</p>
          " . $link . "
        </body>
      </html>";
    $this->send($to, $subject, $message);
  }
}

?>
