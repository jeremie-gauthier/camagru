<link rel="stylesheet" type="text/css" href="style/navbar.css">

<nav class="navbar navbar-expand-lg sticky-top navbar-light navbar-bg">
  <a class="navbar-brand" href="index.php">Camagru</a>
  <div class="navbar-nav">
    <?php if (isset($_SESSION["connected"])) { ?>
      <a class="nav-item nav-link" href="#">Profil</a>
      <a class="nav-item nav-link" href="#">Mon Compte</a>
    <?php } else { ?>
      <a class="nav-item nav-link" href="#">Connexion</a>
      <a class="nav-item nav-link" href="#">Inscription</a>
    <?php } ?>
  </div>
</nav>