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
  <h1>Mon compte</h1>
  <hr />
  <span class="text-success" id="settings-info">
    <?php
      if (Session::exists("settings-info")) {
        echo Session::get("settings-info");
      }
    ?>
  </span>
  <form name="settings">
    <h2>Mes informations</h2>
    <div class="form-group no-margin">
      <label for="pseudo">Votre pseudo</label>
      <input
        type="text"
        value="<?php echo Session::get('pseudo') ?>"
        class="form-control"
        id="pseudo"
        name="pseudo"
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
        id="email"
        name="email"
        required
        disabled
      />
      <span class="text-danger feedback" id="email-error"></span>
    </div>
    <div class="inline-btn">
      <button
        hidden
        type="button"
        id="btn-confirm"
        class="btn btn-primary"
        disabled
        onclick="submitForm()"
      >Confirmer</button>
      <button
        type="button"
        class="btn btn-primary"
        id="btn-modify"
        onclick="modifyBtnToggler()"
      >Modifier mes informations</button>
    </div>
  </form>
  <span class="text-danger">
    <?php
      if (Session::exists("settings-err")) {
        echo Session::get("settings-err");
      }
    ?>
  </span>

  <h2>Notifications</h2>
  <p id="notif-info">
    <?php
      if (Session::get("notifs") == 1) {
        echo "Les notifications sont actuellement activ&eacute;es.";
      } else {
        echo "Les notifications sont actuellement d&eacute;sactiv&eacute;es.";
      }
    ?>
  </p>
  <button
    type="button"
    class="btn btn-primary"
    id="notif-btn"
    value="<?php echo Session::get('notifs'); ?>"
    onclick="toggleNotifications()"
  >
    <?php
      if (Session::get("notifs") == 1) {
        echo "D&eacute;sactiver";
      } else {
        echo "Activer";
      }
    ?>
  </button>

  <h2>S&eacute;curit&eacute;</h2>
  <button
    type="button"
    class="btn btn-primary"
    id="pwd-btn"
    onclick="changePassword()"
  >Changer de mot de passe</button>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/components/toast.php" ?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/footer.php" ?>

<script type="text/javascript" src="/utils/scripts/formValidation.js"></script>
<script type="text/javascript" src="/utils/scripts/AsyncRequest.js"></script>
<script type="text/javascript" src="/account/settings/main.js"></script>
