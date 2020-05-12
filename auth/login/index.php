<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (Session::exists("pseudo")) {
    header("Location: /");
  }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php" ?>
<link rel="stylesheet" type="text/css" href="/auth/auth.css">
<script type="text/javascript" src="/utils/scripts/formValidation.js"></script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/navbar.php" ?>

<div class="container">
  <h1>Connexion</h1>
  <hr />
  <span class="text-success">
    <?php
      if (Session::exists("login-info")) {
        echo Session::get("login-info");
      }
    ?>
  </span>
  <form name="login" method="POST" action="/auth/login/handler.php">
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

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/footer.php" ?>
