<?php

session_start();
require_once "../utils/class/Session.php";
require_once "../utils/class/Users.php";
require_once "../../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['key']) && isset($_GET['email'])) {
  extract(array_map('htmlspecialchars', $_GET));

  try {
    $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);
    $user = $user_cls->getByMail($email);
    if ($user && count($user) == 1 && strcmp($user[0]['secureHash'], $key) == 0) {
      $user_cls->confirmAccount($email);
      Session::set("login-info", "Votre compte a bien ete valide.");
      header("Location: ../../login.php");
    } else { ?>
      <p>Une erreur est survenue lors de la confirmation de votre compte.</p>
      <p>Veuillez reessayer</p>
      <a href="../../index.php">Retour a l'accueil</a>
    <?php
    }
  } catch (Exception $e) { ?>
    <p>Une erreur est survenue lors de la confirmation de votre compte.</p>
    <p>Veuillez reessayer</p>
    <a href="../../index.php">Retour a l'accueil</a>
  <?php
  }
}

?>
