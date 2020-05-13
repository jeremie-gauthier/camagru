<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: /");
  }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php" ?>
<link rel="stylesheet" type="text/css" href="/account/account.css">

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/navbar.php" ?>

<div class="container">
  <h1>Inscription</h1>
  <hr />
  <span class="text-success">
    <?php
      if (Session::exists("register-info")) {
        echo Session::get("register-info");
      }
    ?>
  </span>
  <form name="settings" onsubmit="return submitForm()">
    <div class="form-group no-margin">
      <label for="pseudo">Votre pseudo</label>
      <input
        type="text"
        value="<?php echo Session::get('pseudo') ?>"
        class="form-control"
        id="pseudo"
        maxlength="16"
        required
        disabled
      />
      <span class="text-danger feedback" id="pseudo-error"></span>
    </div>
    <div class="form-group no-margin">
      <label for="email">Votre adresse mail</label>
      <input
        type="email"
        value="<?php echo Session::get('email') ?>"
        class="form-control"
        name="email"
        id="email"
        required
        disabled
      />
      <span class="text-danger feedback" id="email-error"></span>
    </div>
    <div class="inline-btn">
      <button
        hidden
        type="submit"
        id="btn-confirm"
        class="btn btn-primary"
      >Confirmer</button>
      <button
        type="button"
        class="btn btn-primary"
        id="btn-modify"
      >Modifier mes informations</button>
    </div>
  </form>
  <button type="button" onclick="">Changer de mot de passe</button>
  <span class="text-danger">
    <?php
      if (Session::exists("register-err")) {
        echo Session::get("register-err");
      }
    ?>
  </span>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/footer.php" ?>

<script type="text/javascript" src="/utils/scripts/formValidation.js"></script>
<script type="text/javascript" src="/account/settings/main.js"></script>