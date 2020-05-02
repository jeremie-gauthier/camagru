<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . "/server/utils/class/Session.php"
?>
<link rel="stylesheet" type="text/css" href="style/navbar.css">

<nav class="navbar navbar-expand-lg sticky-top navbar-light navbar-bg">
  <a class="navbar-brand" href="index.php">Camagru</a>
  <div class="navbar-nav">
    <?php if (Session::exists("pseudo")) { ?>
      <a class="nav-item nav-link" href="profile.php">Profil</a>
      <a class="nav-item nav-link" href="#">Mon Compte</a>
      <a class="nav-item nav-link" href="logout.php">Deconnexion</a>
    <?php } else { ?>
      <a class="nav-item nav-link" href="login.php">Connexion</a>
      <a class="nav-item nav-link" href="register.php">Inscription</a>
    <?php } ?>
  </div>
</nav>