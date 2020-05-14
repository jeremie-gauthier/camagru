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
      parse_str(file_get_contents('php://input'), $_PUT);
      extract(
        array_map(
          'htmlspecialchars',
          json_decode($_PUT["data"], true)
        )
      );

      $userId = Session::get("userId");
      $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);
      $user_cls->notifications($notif, $userId);
      Session::update("notifs", $notif);
      http_response_code(204);
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
