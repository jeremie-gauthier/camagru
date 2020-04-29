<?php

session_start();
require_once("utils/validation/pseudo.php");
require_once("utils/validation/email.php");
require_once("utils/validation/password.php");
require_once("utils/class/Session.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  print_r($_POST);
  $pseudo = $_POST['pseudo'];
  $email = $_POST['email'];
  $pwd = $_POST['pwd'];
  $confPwd = $_POST['confirm-pwd'];

  if (!checkPseudo($pseudo)
    || !checkEmail($email)
    || !checkPwd($pwd, $confPwd)) {
    Session::set(
      "register-err",
      "Formulaire invalide, veuillez verifier vos informations."
    );
    header("Location: ../register.php");
    die(1);
  }
  echo "OK";
}
else {
  header("Location: ../register.php");
  die(2);
}

?>
