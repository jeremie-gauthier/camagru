<?php
  session_start();
  require_once "server/utils/class/Session.php";
  if (Session::exists("pseudo")) {
    header("Location: index.php");
  }
?>
<?php require_once "layouts/header.php" ?>
<link rel="stylesheet" type="text/css" href="style/auth.css">
<script type="text/javascript" src="scripts/formValidation.js"></script>

<?php require_once "layouts/navbar.php" ?>

<div class="container">
  <h1>Connexion</h1>
  <hr />
  <form name="login" method="POST" action="server/handlers/login.php">
    <div class="form-group">
      <label for="email">Adresse mail</label>
      <input type="email" class="form-control" name="email" id="email" required>
    </div>
    <div class="form-group">
      <label for="pwd">Mot de passe</label>
      <input type="password" class="form-control" name="pwd" id="pwd" minlength='8' required>
    </div>
    <button type="submit" value="Submit" class="btn btn-primary">Connexion</button>
  </form>
  <span class="text-danger">
    <?php
      if (Session::exists("login-err")) {
        echo Session::get("login-err");
      }
    ?>
  </span>
</div>

<?php require_once "layouts/footer.php" ?>
