<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: /");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php";
?>

<link rel="stylesheet" type="text/css" href="/picture/styles/elements.css">

<div id="list-elems" aria-labelledby="btn-elems" hidden>

</div>