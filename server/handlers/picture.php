<?php
  session_start();
  require_once "../utils/class/Pictures.php";
  require_once "../utils/class/Session.php";
  require_once "../../config/database.php";

  header("Content-Type: application/json; charset=UTF-8");

  extract(
    array_map(
      'htmlspecialchars',
      json_decode($_POST["data"], true)
    )
  );

  $img = str_replace(
    ' ',
    '+',
    explode('base64,', $picture)[1]
  );
  
  $pic_cls = new Pictures($DB_DSN, $DB_USER, $DB_PASSWORD);
  $imgId = $pic_cls->create(Session::get("userId"));

  $baseURL = $_SERVER['DOCUMENT_ROOT'] . "/assets/users/";
  file_put_contents($baseURL . $imgId . ".png", base64_decode($img));

  $response = (object) [
    "imgId" => $imgId,
    "message" => "Image enregistree"
  ];
  $json = json_encode($response);
  echo $json;
?>