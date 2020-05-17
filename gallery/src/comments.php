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
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {
  try {
    extract(
      array_map(
        'htmlspecialchars',
        json_decode($_POST["data"], true)
      )
    );
    $userId = Session::get("userId");

    $com_cls = new Comments($DB_DSN, $DB_USER, $DB_PASSWORD);
    $com_cls->create($userId, $pictureId, $comment);

    $pic_cls = new Pictures($DB_DSN, $DB_USER, $DB_PASSWORD);
    $picture = $pic_cls->getById($pictureId);
    if (count($picture) != 1) {
      http_response_code(404);
      return;
    }

    $usr_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);
    $user = $usr_cls->getById($picture[0]["diUsers"]);
    if (count($user) != 1) {
      http_response_code(404);
      return;
    }

    if ($user[0]["notifications"] == 1) {
      Mail::notifNewComment($user[0]["email"], Session::get("pseudo"));
    }
    http_response_code(204);
  } catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
    die(2);
  }
} else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
  try {
    extract(
      array_map(
        'htmlspecialchars',
        $_REQUEST
      )
    );
    if ($currentUser != Session::get("pseudo")) {
      http_response_code(403);
      return;
    }
    $userId = Session::get("userId");

    $com_cls = new Comments($DB_DSN, $DB_USER, $DB_PASSWORD);
    $com_cls->delete($commentId, $userId);
    http_response_code(204);
  } catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
    die(2);
  }
} else {
  http_response_code(401);
  die(2);
}
