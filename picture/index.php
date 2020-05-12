<?php 
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/server/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: index.php");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/header.php";
?>
<link rel="stylesheet" type="text/css" href="picture/styles/main.css">
<link rel="stylesheet" type="text/css" href="picture/styles/overlay.css">

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/navbar.php" ?>

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
      <?php require_once "src/stickers.php" ?>
      <?php require_once "src/filters.php" ?>
      <?php require_once "src/elements.php" ?>
      <?php require_once "src/pictures.php" ?>
    </div>
  </div>
</div>

<div class="footer w-100 row">
  <input type='file' id="file-input" accept="image/png, .jpeg, .jpg" hidden />
  <button
    type="button"
    id="upload-toggler"
    class="floating-btn"
    onclick="document.getElementById('file-input').click()">
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
    id="comment-btn-toggler"
    class="floating-btn"
    onclick="show_comment()">
    <span class="material-icons">chat</span>
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

<div id="overlay-container" hidden>
  <div class="overlay-content">
    <h1 class="overlay-title">Ajoutez une l&eacute;gende<h1>
    <div id="overlay-counter">0/255</div>
    <textarea
      autofocus
      id="overlay-text"
      name="comment"
      rows='10'
      column='50'
      maxlength="255"
      placeholder="Ajoutez une l&eacute;gende..."
    ></textarea>
    <button
      type="button"
      id="overlay-btn"
      onclick="add_comment()"
    >Enregistrer</button>
  </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/footer.php" ?>

<script type="text/javascript" src="scripts/AsyncRequest.js"></script>
<script type="text/javascript" src="scripts/promises.js"></script>
<script type="text/javascript" src="scripts/DOM.js"></script>
<script type="text/javascript" src="scripts/navs.js"></script>
<script type="text/javascript" src="picture/scripts/picture.js"></script>
<script type="text/javascript" src="picture/scripts/overlay.js"></script>
<script type="text/javascript" src="picture/scripts/filters.js"></script>
<script type="text/javascript" src="picture/scripts/stickers.js"></script>
<script type="text/javascript" src="picture/scripts/controls.js"></script>
