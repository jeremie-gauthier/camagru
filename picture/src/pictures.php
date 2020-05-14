<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: /auth/login");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php";
?>

<link rel="stylesheet" type="text/css" href="picture/styles/pictures.css">

<div
  id="list-pictures"
  class="list-pictures"
  aria-labelledby="btn-my-pictures"
  hidden
>
</div>
