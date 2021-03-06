<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: /auth/login");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php";
?>

<link rel="stylesheet" type="text/css" href="/picture/styles/sticker.css">

<div id="list-stickers" aria-labelledby="btn-stickers">
  <div class="sticker" onclick="state.pic?.sticker.add('assets/stickers/Minion.png', 50, 50)">
    <img class="img-sticker" src="assets/stickers/Minion.png" alt="Sticker repr&eacute;sentant un Minion." />
    <span class="text-sticker">Minion</span>
  </div>
  <div class="sticker" onclick="state.pic?.sticker.add('assets/stickers/Soleil.png', 75, 75)">
    <img class="img-sticker" src="assets/stickers/Soleil.png" alt="Sticker repr&eacute;sentant le soleil." />
    <span class="text-sticker">Soleil</span>
  </div>
  <div class="sticker" onclick="state.pic?.sticker.add('assets/stickers/Cadre.png', 640, 480)">
    <img class="img-sticker" src="assets/stickers/Cadre.png" alt="Sticker repr&eacute;sentant un cadre pour photo." />
    <span class="text-sticker">Cadre</span>
  </div>
  <div class="sticker" onclick="state.pic?.sticker.add('assets/stickers/Geralt.png', 314, 250)">
    <img class="img-sticker" src="assets/stickers/Geralt.png" alt="Sticker repr&eacute;sentant Geralt de Riv (Witcher)." />
    <span class="text-sticker">Geralt</span>
  </div>
  <div class="sticker" onclick="state.pic?.sticker.add('assets/stickers/Ciri.png', 320, 400)">
    <img class="img-sticker" src="assets/stickers/Ciri.png" alt="Sticker repr&eacute;sentant Ciri (Witcher)." />
    <span class="text-sticker">Ciri</span>
  </div>
  <div class="sticker" onclick="state.pic?.sticker.add('assets/stickers/Witcher.png', 440, 350)">
    <img class="img-sticker" src="assets/stickers/Witcher.png" alt="Sticker repr&eacute;sentant un homme d&eacute;guis&eacute;." />
    <span class="text-sticker">Witcher</span>
  </div>
</div>
