<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Comments.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";

if (!Session::exists("pseudo")) {
  http_response_code(401);
  die(2);
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  try {
    extract(
      array_map(
        'htmlspecialchars',
        $_REQUEST
      )
    );

    $com_cls = new Comments($DB_DSN, $DB_USER, $DB_PASSWORD);
    $comments = $com_cls->getAllFrom($pictureId);
    foreach ($comments as &$comment) {
      $comment['regDate'] = date_format(new DateTime($comment['regDate']), 'd/m/Y H:i');
    }

    $json = json_encode($comments);
    http_response_code(200);
    echo $json;
  } catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
    die(2);
  }
} else {
  http_response_code(401);
  die(2);
}
