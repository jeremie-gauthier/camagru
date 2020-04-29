<?php

session_start();
require_once "../utils/validation/pseudo.php";
require_once "../utils/validation/email.php";
require_once "../utils/validation/password.php";
require_once "../utils/class/Session.php";
require_once "../utils/class/Users.php";
require_once "../../config/database.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $email = htmlspecialchars($_POST['email']);
  $pwd = htmlspecialchars($_POST['pwd']);
  $confPwd = htmlspecialchars($_POST['confirm-pwd']);

  if (!checkPseudo($pseudo)
    || !checkEmail($email)
    || !checkPwd($pwd, $confPwd)) {
    Session::set(
      "register-err",
      "Formulaire invalide, veuillez verifier vos informations."
    );
    header("Location: ../../register.php");
    die(1);
  }

  try {
    $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);

    $user = $user_cls->getByMail($email);
    if ($user && count($user) != 0) {
      Session::set(
        "register-err",
        "Cette adresse email est deja associee a un autre compte"
      );
      header("Location: ../../register.php");
      die(1);  
    }
    
    $user_cls->create($pseudo, $email, $pwd);
    Session::del("register-err");
    Session::set("pseudo", $pseudo);
    Session::set("email", $email);

    header("Location: ../../index.php");
  } catch (Exception $e) {
    Session::set(
      "register-err",
      "Une erreur est survenue lors de la creation de votre compte"
    );
    header("Location: ../../register.php");
    die(2);
  }
}
else {
  header("Location: ../../register.php");
  die(2);
}

?>
