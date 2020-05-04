<?php session_start(); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/header.php" ?>
<link rel="stylesheet" type="text/css" href="style/picture.css">
<script type="text/javascript" src="scripts/DOM.js"></script>
<script type="text/javascript" src="scripts/camera.js"></script>
<script type="text/javascript" src="scripts/navs.js"></script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/navbar.php" ?>

<div class="w-100 row">
    <div class="picture-area col-md-9" id="picture-area">
      <canvas class="picture" id="canvas"></canvas>
    </div>
    <div class="sticker-area col-md-3">
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
      </ul>
      <div class="tab-content" id="tab-content">
        <?php require_once "stickers.php" ?>
        <?php require_once "filters.php" ?>
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
    onclick="state.recording ? stopRecording() : startRecording()"
  >
    Allumer la camera
  </button>
  
  <button
    type="button"
    class="btn btn-primary"
    id="snapshot-toggler"
    onclick="takeSnapshot()"
    disabled
  >
    Prendre une photo
  </button>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/footer.php" ?>

<script>
  const [canvas, picArea, snap, cam] = mapElements([
    "canvas",
    "picture-area",
    "snapshot-toggler",
    "video-toggler"
  ]);
  const state = new Proxy(
    { recording: false, editing: false, pic: null, original: null, hasFilter: false, nbStickers: 0 },
    {
      set: (obj, prop, value) => {
        const previousValue = obj[prop];
        obj[prop] = value;
        if (prop === "recording") {
          snap.disabled = !value;
          cam.innerHTML = value ? "Eteindre la camera" : "Allumer la camera";
        } else if (prop === "pic") {
          const { ctx, width, height } = value;
          obj.original = ctx.getImageData(0, 0, width, height);
        } else if (prop === "hasFilter" && previousValue === false) {
          const { ctx, width, height } = obj.pic;
          obj.original = ctx.getImageData(0, 0, width, height);
          console.log("CATCH", obj.original);
        }
        // } else if (prop === "nbStickers" && !obj.hasFilter) {
        //   const { ctx, width, height } = obj.pic;
        //   obj.original = ctx.getImageData(0, 0, width, height);
        // }
      }
    }
  );

  const startRecording = () => {
    if (navigator.mediaDevices) {
      state.recording = true;
      state.editing = false;
      canvas.setAttribute("hidden", "");
      const video = createElement(picArea, "video", {
        "autoplay": "true",
        "class": "picture",
        "id": "stream"
      });
      start(video);
    }
  };

  const stopRecording = () => {
    state.recording = false;
    const stream = document.getElementById("stream");
    stop(stream);
    removeElement(stream);
  };

  const takeSnapshot = () => {
    state.editing = true;
    const stream = document.getElementById("stream");
    canvas.removeAttribute("hidden");
    state.pic = new Picture(stream, canvas);
    stopRecording();
  };
</script>
