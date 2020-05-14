<?php session_start(); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php" ?>
<link rel="stylesheet" type="text/css" href="/gallery/gallery.css">

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/navbar.php" ?>

<div class="container">
  <h1>Ma galerie</h1>
  <hr />

  <a href="/picture">Ajouter une photo</a>
  <?php require $_SERVER['DOCUMENT_ROOT'] . "/components/toast.php" ?>
  <div class="list-pictures">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/gallery/loadPictures.php" ?>
  </div>

</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/footer.php" ?>
