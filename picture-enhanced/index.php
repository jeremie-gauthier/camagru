<?php 
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/server/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: index.php");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/header.php";
?>
<link rel="stylesheet" type="text/css" href="picture-enhanced/styles/main.css">

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/navbar.php" ?>

<div class="w-100 row">
  <div class="col-md-8">
    <div class="embed-responsive embed-responsive-16by9" id="picture-area">
      <canvas class="picture" id="canvas"></canvas>
    </div>

  <?php require $_SERVER['DOCUMENT_ROOT'] . "/components/toast.php" ?>
  </div>
  <div class="pimp-area col-md-4">
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
      <?php require_once "src/stickers.php" ?>
      <?php require_once "src/filters.php" ?>
      <?php require_once "src/elements.php" ?>
    </div>
  </div>
</div>

<div class="footer w-100 row">
  <button
    type="button"
    id="upload-toggler"
    class="floating-btn"
    onclick="upload()">
    <span class="material-icons">publish</span>
  </button>


  <button
    class="floating-btn"
    onclick="state.recording ? stop() : start()">
    <span class="material-icons" id="video-toggler">videocam</span>
  </button>
  
  <button
    disabled
    type="button"
    id="snapshot-toggler"
    class="floating-btn"
    onclick="snapshot()">
    <span class="material-icons">add_a_photo</span>
  </button>


  <button
    disabled
    type="button"
    id="sticker-glue-toggler"
    class="floating-btn"
    onclick="state.pic?.sticker.glue()">
    <span class="material-icons">layers</span>
  </button>

  <button
    disabled
    type="button"
    id="sticker-wipe-toggler"
    class="floating-btn"
    onclick="state.pic?.sticker.wipe()">
    <span class="material-icons">layers_clear</span>
  </button>

  <button
    disabled
    type="button"
    id="send-btn-toggler"
    class="floating-btn"
    onclick="send()">
    <span class="material-icons">send</span>
  </button>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/footer.php" ?>

<script type="text/javascript" src="scripts/promises.js"></script>
<script type="text/javascript" src="scripts/DOM.js"></script>
<script type="text/javascript" src="scripts/navs.js"></script>
<script type="text/javascript" src="picture-enhanced/scripts/picture.js"></script>
<script type="text/javascript" src="picture-enhanced/scripts/filters.js"></script>
<script type="text/javascript" src="picture-enhanced/scripts/stickers.js"></script>
<script type="text/javascript" src="picture-enhanced/scripts/camera.js"></script>
