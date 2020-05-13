<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Pictures.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";

  header("Content-Type: application/json; charset=UTF-8");

  $baseURL = $_SERVER['DOCUMENT_ROOT'] . "/assets/users/";
  $ext = ".png";

  // POST
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
    $imgId = $pic_cls->create(Session::get("userId"), $legend);

    file_put_contents($baseURL . $imgId . $ext, base64_decode($img));

    $response = (object) [
      "imgId" => $imgId,
      "message" => "Image enregistree"
    ];
    $json = json_encode($response);
    echo $json;
  }

  // DELETE
  else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $imgId = htmlspecialchars($_REQUEST['id']);

    $pic_cls = new Pictures($DB_DSN, $DB_USER, $DB_PASSWORD);
    $status = $pic_cls->delete($imgId, Session::get("userId"));

    if ($status) {
      unlink($baseURL . $imgId . $ext);
      http_response_code(204);
    } else {
      http_response_code(403);
    }
  }

  // NOT A VALID REQUEST
  else {
    http_response_code(401);
    header("Location: /");
  }
?>
