<?php require_once "layouts/header.php" ?>
<link rel="stylesheet" type="text/css" href="style/auth.css">

<?php require_once "layouts/navbar.php" ?>

<div class="container">
  <h1>Inscription</h1>
  <hr />
  <form>
    <div class="form-group">
      <label for="pseudo">Choisissez un pseudo</label>
      <input type="text" class="form-control" name="pseudo" id="pseudo" maxlength="5" required>
    </div>
    <div class="form-group">
      <label for="email">Adresse mail</label>
      <input type="email" class="form-control" name="email" id="email" required>
    </div>
    <div class="form-group">
      <label for="pwd">Mot de passe</label>
      <input type="password" class="form-control" name="pwd" id="pwd" required>
    </div>
    <div class="form-group">
      <label for="confirm-pwd">Confirmation mot de passe</label>
      <input type="password" class="form-control" name="confirm-pwd" id="confirm-pwd" required>
    </div>
    <button type="submit" class="btn btn-primary">Inscription</button>
  </form>
</div>

<?php require_once "layouts/footer.php" ?>
