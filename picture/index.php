<?php 
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: index.php");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php";
?>
<link rel="stylesheet" type="text/css" href="/picture/styles/main.css" />
<link rel="stylesheet" type="text/css" href="/picture/styles/overlay.css" />

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/navbar.php" ?>

<div class="w-100 row">
  <div class="col-md-7">
    <div class="embed-responsive embed-responsive-16by9" id="picture-area">
      <canvas class="picture" id="canvas"></canvas>
    </div>

  <?php require $_SERVER['DOCUMENT_ROOT'] . "/components/toast.php" ?>
  </div>
  <div class="pimp-area col-md-5">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <button
          class="nav-link extras active"
          id="btn-stickers"
          onclick="switchNav(this)"
        >
          Stickers
        </button>
      </li>
      <li class="nav-item">
        <button
          class="nav-link extras"
          id="btn-filters"
          onclick="switchNav(this)"
        >
          Filtres
        </button>
      </li>
      <li class="nav-item">
        <button
          class="nav-link extras"
          id="btn-elems"
          onclick="switchNav(this)"
        >
          Mes elements
        </button>
      </li>
      <li class="nav-item">
        <button
          class="nav-link extras"
          id="btn-my-pictures"
          onclick="switchNav(this)"
        >
          Mes photos
        </button>
      </li>
    </ul>
    <div class="tab-content" id="tab-content">
      <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/picture/src/stickers.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/picture/src/filters.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/picture/src/elements.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/picture/src/pictures.php";
      ?>
    </div>
  </div>
</div>

<div class="footer w-100 row">
  <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/picture/src/controls.php" ?>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/footer.php" ?>

<script type="text/javascript" src="utils/scripts/AsyncRequest.js"></script>
<script type="text/javascript" src="utils/scripts/promises/fileReader.js"></script>
<script type="text/javascript" src="utils/scripts/promises/imgLoader.js"></script>
<script type="text/javascript" src="utils/scripts/DOM.js"></script>
<script type="text/javascript" src="utils/scripts/navs.js"></script>
<script type="text/javascript" src="/picture/scripts/picture.js"></script>
<script type="text/javascript" src="/picture/scripts/overlay.js"></script>
<script type="text/javascript" src="/picture/scripts/filters.js"></script>
<script type="text/javascript" src="/picture/scripts/stickers.js"></script>
<script type="text/javascript" src="/picture/scripts/controls.js"></script>
