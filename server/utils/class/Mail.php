<?php

class Mail {
  const CAMAGRU_EMAIL = "camagru.jergauth.42@gmail.com";
  const HEADERS = [
    'From' => self::CAMAGRU_EMAIL,
    'Reply-To' => self::CAMAGRU_EMAIL,
    'MIME-Version' => '1.0',
    'Content-Type' => 'text/html;'
  ];
  
  private function send($to, $subject, $message) {
    mail($to, $subject, $message, self::HEADERS);
  }
  
  function newAccount($to, $hash) {
    $subject = "Confirmation de votre compte";
    $message = "
      <html>
        <body>
          <h1>Camagru</h1>
          <hr />
          <p>Pour confirmer votre inscription, merci de valider votre compte en cliquant sur le lien suivant:</p>
          <a href='localhost/camagru/server/handlers/confirmation.php?key=" . $hash . "&email=" . $to . "'>Confirmer mon compte</a>
        </body>
      </html>";
    Mail::send($to, $subject, $message);
  }
}

?>
