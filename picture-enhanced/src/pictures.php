<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/server/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: ../../index.php");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/header.php";
?>

<link rel="stylesheet" type="text/css" href="picture-enhanced/styles/elements.css">

<div id="list-pictures" aria-labelledby="btn-my-pictures" hidden>

</div>