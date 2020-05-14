<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/validation/password.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Users.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
  extract(array_map('htmlspecialchars', $_POST));
  
  Session::del("settings-info");
  if (!checkPwd($pwd, $confirm_pwd)) {
    Session::set(
      "password-err",
      "Mot de passe invalide."
    );
    header("Location: /account/password?key=" . $key);
    die(1);
  }

  try {
    $userId = Session::get("userId");
    $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);
    $user_cls->updatePassword($email, $userId);
    Session::del("password-err");
    Session::set("settings-info", "Votre mot de passe a ete modifie");

    header("Location: /account/settings");
  } catch (Exception $e) {
    Session::set(
      "password-err",
      "Une erreur est survenue lors de la modification de votre mot de passe."
    );
    header("Location: /account/password?key=" . $key);
    die(1);
  }
} else {
  header("Location: /account/password?key=" . $key);
  die(2);
}

?>
