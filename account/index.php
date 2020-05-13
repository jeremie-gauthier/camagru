<?php 
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: /");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php"
?>
<!-- <link rel="stylesheet" type="text/css" href="/index.css"> -->

<?php require $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/navbar.php" ?>


<?php require $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/footer.php" ?>
