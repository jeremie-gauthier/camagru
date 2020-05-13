<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Users.php";

  if (!Session::exists("pseudo")) {
    http_response_code(401);
    die(2);
  }

  if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    try {
      parse_str(file_get_contents('php://input'), $_PUT);
      extract(
        array_map(
          'htmlspecialchars',
          json_decode($_PUT["data"], true)
        )
      );
      $userId = Session::get("userId");

      $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);
      $user_cls->update($pseudo, $email, $userId);
      Session::update("pseudo", $pseudo);
      Session::update("email", $email);
      http_response_code(204);
    } catch (Exception $e) {
      throw ($e);
    }  
  }
?>
