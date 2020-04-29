<?php
  session_start();
  require_once "server/utils/class/Session.php";
?>
<?php require_once "layouts/header.php" ?>
<link rel="stylesheet" type="text/css" href="style/auth.css">
<script type="text/javascript" src="scripts/formValidation.js"></script>

<?php require_once "layouts/navbar.php" ?>

<div class="container">
  <h1>Inscription</h1>
  <hr />
  <form name="register" method="POST" action="server/handleRegister.php" onsubmit="return submitForm()">
    <div class="form-group no-margin">
      <label for="pseudo">Choisissez un pseudo</label>
      <input type="text" class="form-control" name="pseudo" id="pseudo" maxlength="16" required>
      <span class="text-danger feedback" id="pseudo-error"></span>
    </div>
    <div class="form-group no-margin">
      <label for="email">Adresse mail</label>
      <input type="email" class="form-control" name="email" id="email" required>
      <span class="text-danger feedback" id="email-error"></span>
    </div>
    <div class="form-group no-margin">
      <label for="pwd">Mot de passe</label>
      <input type="password" class="form-control" name="pwd" id="pwd" minlength='8' required>
      <span class="text-danger feedback" id="pwd-error"></span>
    </div>
    <div class="form-group">
      <label for="confirm-pwd">Confirmation mot de passe</label>
      <input type="password" class="form-control" name="confirm-pwd" id="confirm-pwd" minlength='8' required>
    </div>
    <button type="submit" value="Submit" class="btn btn-primary">Inscription</button>
  </form>
  <span class="text-danger">
    <?php
      if (Session::exists("register-err")) {
        echo Session::get("register-err");
      }
    ?>
  </span>
</div>

<?php require_once "layouts/footer.php" ?>

<script>
  const form = document.forms.register;
  const [pseudoErr, emailErr, pwdErr] = mapElements([
    "pseudo-error",
    "email-error",
    "pwd-error"
  ]);

  window.onload = () => {
    form.pseudo.addEventListener('blur', () =>
      checkPseudo(form.pseudo.value, pseudoErr)
    );
    form.email.addEventListener('blur', () =>
      checkEmail(form.email.value, emailErr)
    );
    form.pwd.addEventListener('blur', () =>
      checkPwd(form.pwd.value, form['confirm-pwd'].value, pwdErr)
    );
    form['confirm-pwd'].addEventListener('blur', () =>
      checkPwd(form.pwd.value, form['confirm-pwd'].value, pwdErr)
    );
  }

  const submitForm = () => {
    checkPseudo(form.pseudo.value, pseudoErr);
    checkEmail(form.email.value, emailErr);
    checkPwd(form.pwd.value, form['confirm-pwd'].value, pwdErr);
    return [pseudoErr, emailErr, pwdErr].every((elem) => elem.innerHTML === "");
  }
</script>
