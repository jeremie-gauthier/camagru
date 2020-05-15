<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Likes.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Pictures.php";
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
    $userId = Session::get("userId");

    $like_cls = new Likes($DB_DSN, $DB_USER, $DB_PASSWORD);
    $like_cls->add($userId, $pictureId);
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
    $userId = Session::get("userId");

    $like_cls = new Likes($DB_DSN, $DB_USER, $DB_PASSWORD);
    $like_cls->del($userId, $pictureId);
    http_response_code(204);
  } catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
    die(2);
  }
} else if ($_SERVER["REQUEST_METHOD"] === "PUT") {
  try {
    parse_str(file_get_contents('php://input'), $_PUT);
    extract(
      array_map(
        'htmlspecialchars',
        json_decode($_PUT["data"], true)
      )
    );
    $userId = Session::get("userId");

    $pic_cls = new Pictures($DB_DSN, $DB_USER, $DB_PASSWORD);
    $pic_cls->update($userId, $pictureId, $legend);
    http_response_code(204);
  } catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
    die(2);
  }
}  else if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

?>
