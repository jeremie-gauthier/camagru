<?php 
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/server/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: index.php");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/header.php";
?>
<link rel="stylesheet" type="text/css" href="picture/styles/stickers.css">
<link rel="stylesheet" type="text/css" href="picture/styles/stream.css">
<link rel="stylesheet" type="text/css" href="picture-enhanced/styles/picture.css">

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/navbar.php" ?>

<div class="w-100 row">
  <div class="col-md-9">
    <div class="stickers-area">
      <div class="sticker-box">
        <input type="checkbox">
          <img src="assets/Minion.png" width=50 height=50 />
        </input>
      </div>
      <div class="sticker-box">
        <input type="checkbox">
          <img src="assets/Cadre.png" width=50 height=50 />
        </input>
      </div>
      <div class="sticker-box">
        <input type="checkbox">
          <img src="assets/Sun.png" width=50 height=50 />
        </input>
      </div>
    </div>
    <div class="embed-responsive embed-responsive-16by9" id="picture-area">
      <video hidden autoplay id="stream"></video>
    </div>

  <?php require $_SERVER['DOCUMENT_ROOT'] . "/components/toast.php" ?>
  </div>
  <div class="pimp-area col-md-3">
    <template id="img-taken">
      <div>
        <img src="" />
      </div>
    </template>
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
    type="button"
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
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/footer.php" ?>

<script type="text/javascript" src="scripts/promises.js"></script>
<script type="text/javascript" src="scripts/DOM.js"></script>
<script type="text/javascript" src="picture/scripts/camera.js"></script>

<script>
  const [video, cam, snap, img, uploadImg] = mapElements([
    "stream",
    "video-toggler",
    "snapshot-toggler",
    "img-taken",
    "upload-toggler",
  ]);

  const state = {
    recording: false
  };

</script>
