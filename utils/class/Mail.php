<?php

class Mail {
  const HOST = "86.247.50.28:9000";
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
    $link = self::HOST . "/auth/register/confirmation.php?key=" . $hash . "&email=" . $to;
    $message = "
      <html>
        <body>
          <h1>Camagru</h1>
          <hr />
          <p>Pour confirmer votre inscription, merci de valider votre compte en utilisant le lien suivant:</p>
          " . $link . "
        </body>
      </html>";
    Mail::send($to, $subject, $message);
  }
  
  function newPassword($to, $hash) {
    $subject = "Reinitialisation de votre mot de passe";
    $link = self::HOST . "/account/password?key=" . $hash;
    $message = "
      <html>
        <body>
          <h1>Camagru</h1>
          <hr />
          <p>Pour reinitialiser votre mot de passe, merci d'utiliser le lien suivant:</p>
          " . $link . "
        </body>
      </html>";
    Mail::send($to, $subject, $message);
  }

  function notifNewComment($to, $author) {
    $subject = "Vous avez recu un nouveau commentaire";
    $message = "
      <html>
        <body>
          <h1>Camagru</h1>
          <hr />
          <p><strong>" . $author . "</strong> a comment&eacute; l'une de vos photos.</p>
          <p>Connectez-vous pour consulter ce commentaire.</p>
        </body>
      </html>";
    Mail::send($to, $subject, $message);
  }
}

?>
