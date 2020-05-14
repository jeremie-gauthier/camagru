<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/validation/email.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Users.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Mail.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";


if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
  extract(array_map('htmlspecialchars', $_POST));

  if (!checkEmail($email)) {
    Session::del("login-info");
    Session::set(
      "login-err",
      "Connexion impossible, veuillez verifier vos informations"
    );
    header("Location: /auth/login");
    die(1);  
  }

  try {
    $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);

    $user = $user_cls->getByMail($email);
    if ($user && count($user) == 1 && password_verify($pwd, $user[0]["password"])) {
      if ($user[0]['confirmedAccount'] == 1) {
        Session::multidel(["login-err", "login-info", "register-info"]);
        Session::multiset([
          "pseudo" => $user[0]["pseudo"],
          "email" => $user[0]["email"],
          "userId" => $user[0]["idUsers"],
          "notifs" => $user[0]["notifications"]
        ]);

        header("Location: /");
      } else {
        Mail::newAccount($user[0]['email'], $user[0]['secureHash']);
        Session::del("login-info");
        Session::set(
          "login-err",
          "Merci de confirmer votre compte. Un nouveau mail vient de vous etre envoye."
        );
        header("Location: /auth/login");
        die(1);
      }
    } else {
      Session::del("login-info");
      Session::set(
        "login-err",
        "Adresse mail ou mot de passe incorrect. Veuillez reessayer."
      );
      header("Location: /auth/login");
      die(1);
    }
  } catch (Exception $e) {
    Session::del("login-info");
    Session::set(
      "login-err",
      "Une erreur est survenue, veuillez reessayer plus tard"
    );
    header("Location: /auth/login");
    die(2);
  }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
  try {
    $email = htmlspecialchars($_REQUEST['email']);

    $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);
    $user = $user_cls->getByMail($email);

    if ($user && count($user) == 0) {
      http_response_code(404);
      echo "Utilisateur introuvable";
      die(2);
    }
    Session::multiset([
      "email" => $email,
      "userId" => $user[0]["idUsers"]
    ]);

    $userId = $user[0]["idUsers"];
    $hash = md5(time());
    $user_cls->bindHash($userId, $hash);
    Mail::newPassword($email, $hash);
    http_response_code(200);
    Session::del("login-err");
    Session::set(
      "login-info",
      "Un mail contenant les instructions de r&eacute;initialisation de votre mot de passe vient de vous etre envoy&eacute;."
    );
    echo "Un mail contenant les instructions de r&eacute;initialisation de votre mot de passe vient de vous etre envoy&eacute;.";
  } catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
    die(2);
  }
} else {
  header("Location: /auth/login");
  die(2);
}

?>
