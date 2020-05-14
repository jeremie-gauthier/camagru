<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (Session::exists("pseudo")) {
    header("Location: /");
  }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php" ?>
<link rel="stylesheet" type="text/css" href="/auth/auth.css">
<link rel="stylesheet" type="text/css" href="/auth/login/overlay.css">

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/navbar.php" ?>

<div class="container">
  <h1>Connexion</h1>
  <hr />
  <div class="text-success" id="info-text">
    <?php
      if (Session::exists("login-info")) {
        echo Session::get("login-info");
      }
    ?>
  </div>
  <form name="login" method="POST" action="/auth/login/handler.php">
    <div class="form-group">
      <label for="email">Adresse mail</label>
      <input autofocus type="email" class="form-control" name="email" id="email" required>
    </div>
    <div class="form-group">
      <label for="pwd">Mot de passe</label>
      <input type="password" class="form-control" name="pwd" id="pwd" minlength='8' required>
    </div>
    <button type="submit" value="Submit" class="btn btn-primary">Connexion</button>
  </form>
  <div class="text-danger" id="error-text">
    <?php
      if (Session::exists("login-err")) {
        echo Session::get("login-err");
      }
    ?>
  </div>
  <button
    type="button"
    class="btn-link"
    onclick="forgottenPassword()"
  >Mot de passe oubli&eacute; ?</button>


  <div id="overlay-container" hidden>
    <div class="overlay-content">
      <h1 class="overlay-title">Indiquez votre adresse mail</h1>
      <div id="overlay-feedback"></div>
      <input
        type="email"
        id="overlay-input"
        name="email"
        maxlength="255"
        placeholder="Adresse mail"
      />
      <button
        type="button"
        id="overlay-btn"
        onclick="resetPwd()"
      >
        R&eacute;initialiser mon mot de passe
        <div id="load-indicator" class="spinner-border" role="status" hidden>
          <span class="sr-only">Loading...</span>
        </div>
      </button>
    </div>

  </div>
</div>


<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/footer.php" ?>

<script type="text/javascript" src="/utils/scripts/AsyncRequest.js"></script>
<script type="text/javascript" src="/auth/login/main.js"></script>
