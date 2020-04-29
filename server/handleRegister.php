<?php

session_start();
require_once "utils/validation/pseudo.php";
require_once "utils/validation/email.php";
require_once "utils/validation/password.php";
require_once "utils/class/Session.php";
require_once "utils/class/Database.php";
require_once "../config/database.php";


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

  try {
    $db = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
    // AJOUTER HASH ET VALIDATION MAIL PAR LA SUITE
    // PLS ENCRYPT THIS PWD
    $query = "INSERT INTO users (pseudo, email, password) VALUES (:pseudo, :email, :pwd)";
    $values = [
      ":pseudo" => $pseudo,
      ":email" => $email,
      ":pwd" => $pwd
    ];
    $db->query($query, $values);
    echo "Insertion succeed";
  } catch (Exception $e) {
    echo ("Une erreur est survenue" . $e);
    die(2);
  }
}
else {
  header("Location: ../register.php");
  die(2);
}

?>
