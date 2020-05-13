<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php"
?>
<link rel="stylesheet" type="text/css" href="/components/layouts/navbar.css">

<nav class="navbar navbar-expand-lg sticky-top navbar-light navbar-bg" id="navbar">
  <a class="navbar-brand" href="/">Camagru</a>
  <div class="navbar-nav">
    <?php if (Session::exists("pseudo")) { ?>
      <a class="nav-item nav-link" href="/gallery">Galerie</a>
      <a class="nav-item nav-link" href="/account">Mon Compte</a>
      <a class="nav-item nav-link" href="/auth/logout.php">Deconnexion</a>
    <?php } else { ?>
      <a class="nav-item nav-link" href="/auth/login">Connexion</a>
      <a class="nav-item nav-link" href="/auth/register">Inscription</a>
    <?php } ?>
  </div>
</nav>