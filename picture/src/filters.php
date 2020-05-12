<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: /");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php";
?>

<link rel="stylesheet" type="text/css" href="/picture/styles/filters.css">

<div id="list-filters" aria-labelledby="btn-filters" hidden>
  <button type="button" class="filter" onclick="state.pic?.filter.normal()">
    Normal
  </button>

  <button type="button" class="filter" onclick="state.pic?.filter.grey()">
    Nuances de gris
  </button>

  <button type="button" class="filter" onclick="state.pic?.filter.sepia()">
    Sepia
  </button>

  <button type="button" class="filter" onclick="state.pic?.filter.sketch()">
    Sketch
  </button>

  <button type="button" class="filter" onclick="state.pic?.filter.inversion()">
    Negatif
  </button>
</div>
