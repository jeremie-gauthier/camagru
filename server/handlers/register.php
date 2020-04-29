<?php

session_start();
require_once "../utils/validation/pseudo.php";
require_once "../utils/validation/email.php";
require_once "../utils/validation/password.php";
require_once "../utils/class/Session.php";
require_once "../utils/class/Database.php";
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
    $db = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
    $query = "SELECT email FROM users WHERE email=:email";
    $values = [":email" => $email];
    $db->query($query, $values);
    $result = $db->get_result();
    if ($result && count($result) != 0) {
      Session::set(
        "register-err",
        "Cette adresse email est deja associee a un autre compte"
      );
      header("Location: ../../register.php");
      die(1);  
    }

    // AJOUTER HASH ET VALIDATION MAIL PAR LA SUITE
    $query = "INSERT INTO users (pseudo, email, password) VALUES (:pseudo, :email, :pwd)";
    $values = [
      ":pseudo" => $pseudo,
      ":email" => $email,
      ":pwd" => password_hash($pwd, PASSWORD_DEFAULT)
    ];
    $db->query($query, $values);
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
