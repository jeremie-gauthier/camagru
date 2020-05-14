<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Users.php";

  if (!Session::exists("pseudo")) {
    http_response_code(401);
    die(2);
  }

  Session::del("settings-info");
  if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    try {
      require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/validation/pseudo.php";
      require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/validation/email.php";

      parse_str(file_get_contents('php://input'), $_PUT);
      extract(
        array_map(
          'htmlspecialchars',
          json_decode($_PUT["data"], true)
        )
      );

      if (!checkPseudo($pseudo) || !checkEmail($email)) {
        http_response_code(400);
        echo "Formulaire invalide";
        die(2);
      }

      $userId = Session::get("userId");

      $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);

      // ensure the mail can be used
      $user = $user_cls->getByMail($email);
      if ($user && $user[0]["idUsers"] != $userId) {
        http_response_code(403);
        echo "Adresse mail deja attribuee";
        die(2);
      }

      $user_cls->update($pseudo, $email, $userId);
      Session::update("pseudo", $pseudo);
      Session::update("email", $email);
      http_response_code(204);
    } catch (Exception $e) {
      http_response_code(500);
      echo $e;
      die(2);
    }  
  }

  else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    try {
      require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Mail.php";

      $email = htmlspecialchars($_REQUEST['email']);
      $userId = Session::get("userId");
      $hash = md5(time());

      $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);
      $user_cls->bindHash($userId, $hash);
      Mail::newPassword($email, $hash);
    } catch (Exception $e) {
      http_response_code(500);
      echo $e->getMessage();
      die(2);
    }
  }

  else {
    http_response_code(401);
    die(2);
  }
?>
