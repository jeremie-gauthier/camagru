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
          "userId" => $user[0]["idUsers"]
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

} else {
  header("Location: /auth/login");
  die(2);
}

?>
