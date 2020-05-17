<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Pictures.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  try {
    extract(
      array_map(
        'htmlspecialchars',
        $_REQUEST
      )
    );

    $pic_cls = new Pictures($DB_DSN, $DB_USER, $DB_PASSWORD);
    if ($user == null) {
      $pictures = $pic_cls->getMore($offset, $limit);
    } else {
      $userId = Session::get("userId");
      $pictures = $pic_cls->getMoreFrom($userId, $offset, $limit);
    }

    foreach ($pictures as &$picture) {
      $picture['regDate'] = date_format(new DateTime($picture['regDate']), 'd/m/Y H:i');
    }

    $json = json_encode($pictures);
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
