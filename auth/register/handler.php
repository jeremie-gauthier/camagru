<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/validation/pseudo.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/validation/email.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/validation/password.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Users.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Mail.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
  extract(array_map('htmlspecialchars', $_POST));

  if (!checkPseudo($pseudo)
    || !checkEmail($email)
    || !checkPwd($pwd, $confirm_pwd)
  ) {
    Session::del("register-info");
    Session::set(
      "register-err",
      "Formulaire invalide, veuillez verifier vos informations."
    );
    header("Location: /auth/register");
    die(1);
  }

  try {
    $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);

    $user = $user_cls->getByMail($email);
    if ($user && count($user) != 0) {
      Session::del("register-info");
      Session::set(
        "register-err",
        "Cette adresse email est deja associee a un autre compte"
      );
      header("Location: /auth/register");
      die(1);  
    }
    
    $user_cls->create($pseudo, $email, $pwd);
    Session::del("register-err");
    Session::set(
      "register-info",
      "Votre compte a bien ete cree, veuillez le valider en suivant le lien qui vous a ete envoye par mail."
    );

    header("Location: /auth/register");
  } catch (Exception $e) {
    Session::del("register-info");
    Session::set(
      "register-err",
      "Une erreur est survenue lors de la creation de votre compte"
    );
    header("Location: /auth/register");
    die(2);
  }
}
else {
  header("Location: /auth/register");
  die(2);
}

?>
