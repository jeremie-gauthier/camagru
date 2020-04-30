<?php

session_start();
require_once "../utils/validation/email.php";
require_once "../utils/class/Session.php";
require_once "../utils/class/Users.php";
require_once "../../config/database.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  extract(array_map('htmlspecialchars', $_POST));

  if (!checkEmail($email)) {
    Session::set(
      "login-err",
      "Connexion impossible, veuillez verifier vos informations"
    );
    header("Location: ../../login.php");
    die(1);  
  }

  try {
    $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);

    $user = $user_cls->getByMail($email);
    if ($user && count($user) == 1 && password_verify($pwd, $user[0]["password"])) {
      Session::del("login-err");
      Session::multiset([
        "pseudo" => $user[0]["pseudo"],
        "email" => $user[0]["email"]
      ]);

      header("Location: ../../index.php");
    } else {
      Session::set(
        "login-err",
        "Adresse mail ou mot de passe incorrect. Veuillez reessayer."
      );
      header("Location: ../../login.php");
      die(1);  
    }
  } catch (Exception $e) {
    Session::set(
      "login-err",
      "Une erreur est survenue, veuillez reessayer plus tard"
    );
    header("Location: ../../login.php");
    die(2);
  }

} else {
  header("Location: ../../login.php");
  die(2);
}


?>
