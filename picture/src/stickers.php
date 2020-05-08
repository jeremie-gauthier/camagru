<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/server/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: ../../index.php");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/header.php";
?>

<link rel="stylesheet" type="text/css" href="picture/styles/sticker.css">

<div id="list-stickers" aria-labelledby="btn-stickers">
  <div class="sticker" onclick="state.pic?.sticker.add('assets/Minion.png', 50, 50)">
    <img class="img-sticker" src="assets/Minion.png" />
    <span class="text-sticker">Minion</span>
  </div>
  <div class="sticker" onclick="state.pic?.sticker.add('assets/Soleil.png', 75, 75)">
    <img class="img-sticker" src="assets/Soleil.png" />
    <span class="text-sticker">Soleil</span>
  </div>
  <div class="sticker" onclick="state.pic?.sticker.add('assets/Cadre.png', 640, 480)">
    <img class="img-sticker" src="assets/Cadre.png" />
    <span class="text-sticker">Cadre</span>
  </div>
</div>
