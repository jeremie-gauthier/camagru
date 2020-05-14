<?php
  session_start();

  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (!Session::exists("email")) {
    header("Location: /auth/login");
    die(2);
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Users.php";

  $key = $_REQUEST['key'];
  
  $user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);
  $user = $user_cls->getByMail(Session::get("email"));
  
  if ($user && count($user) != 1) {
    echo "Une erreur est survenue";
    die(2);
  } else if ($user && $user[0]["secureHash"] != $key) {
    header("Location: /account/settings");
    die(2);
  }

  require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php";
?>

<link rel="stylesheet" type="text/css" href="/account/account.css" />

<div class="container">
  <h1>Reinitialisation du mot de passe</h1>
  <hr />

  <form name="reset_pwd" method="POST" action="/account/password/handler.php" onsubmit="submitForm()">
    <div class="form-group no-margin">
      <input type="hidden" name="key" value="<? echo $key ?>"/>

      <label for="pseudo">Nouveau mot de passe</label>
      <input
        type="password"
        class="form-control"
        id="pwd"
        name="pwd"
        required
      />
      <span class="text-danger feedback" id="pwd-error"></span>
    </div>
    <div class="form-group no-margin">
      <label for="email">Confirmation</label>
      <input
        type="password"
        class="form-control"
        id="confirm_pwd"
        name="confirm_pwd"
        required
      />
    </div>
    <button type="submit" class="btn btn-primary">Confirmer</button>
  </form>

  <span class="text-danger">
    <?php
      if (Session::exists("password-err")) {
        echo Session::get("password-err");
      }
    ?>
  </span>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/footer.php" ?>

<script type="text/javascript" src="/utils/scripts/formValidation.js"></script>
<script>
  const form = document.forms.reset_pwd;
  const { pwd, confirm_pwd } = form;
  const pwdErr = document.getElementById("pwd-error");

  pwd.onkeyup = () => checkPwd(pwd.value, confirm_pwd.value, pwdErr);
  confirm_pwd.onkeyup = () => checkPwd(pwd.value, confirm_pwd.value, pwdErr);

  const submitForm = () => {
    checkPwd(pwd.value, confirm_pwd.value, pwdErr);
    return pwdErr.innerHTML === "";
  }
</script>
