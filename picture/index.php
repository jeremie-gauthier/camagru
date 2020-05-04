<?php session_start(); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/header.php" ?>
<link rel="stylesheet" type="text/css" href="picture/styles/picture.css">

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/navbar.php" ?>

<div class="w-100 row">
    <div class="picture-area col-md-9" id="picture-area">
      <canvas class="picture" id="canvas"></canvas>
    </div>
    <div class="pimp-area col-md-3">
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
    class="btn btn-primary"
    id=""
  >
    Telecharger une image
  </button>

  <button
    type="button"
    class="btn btn-primary"
    id="video-toggler"
    onclick="state.recording ? stop() : start()"
  >
    Allumer la camera
  </button>
  
  <button
    type="button"
    class="btn btn-primary"
    id="snapshot-toggler"
    onclick="snapshot()"
    disabled
  >
    Prendre une photo
  </button>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/footer.php" ?>

<script type="text/javascript" src="scripts/DOM.js"></script>
<script type="text/javascript" src="scripts/navs.js"></script>
<script type="text/javascript" src="picture/scripts/picture.js"></script>
<script type="text/javascript" src="picture/scripts/filters.js"></script>
<script type="text/javascript" src="picture/scripts/camera.js"></script>
<script type="text/javascript" src="picture/scripts/stickers.js"></script>
