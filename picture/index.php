<?php session_start(); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/header.php" ?>
<link rel="stylesheet" type="text/css" href="style/picture.css">
<script type="text/javascript" src="scripts/DOM.js"></script>
<script type="text/javascript" src="scripts/camera.js"></script>
<script type="text/javascript" src="scripts/navs.js"></script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/navbar.php" ?>

<div class="w-100 row">
    <div class="picture-area col-md-9" id="picture-area"></div>
    <div class="sticker-area col-md-3">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <button
            class="nav-link extras"
            id="btn-stickers"
            onclick="switchNav(this)"
          >
            Stickers
          </button>
        </li>
        <li class="nav-item">
          <button
            class="nav-link extras active"
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

  <button
    type="button"
    class="btn btn-primary"
    id="no-filter"
    onclick="state.filter.normal()"
    disabled
  >
    Sans filtre
  </button>

  <button
    type="button"
    class="btn btn-primary"
    id="grey-filter"
    onclick="state.filter.grey()"
    disabled
  >
    Filtre gris
  </button>

  <button
    type="button"
    class="btn btn-primary"
    id="sepia-filter"
    onclick="state.filter.sepia()"
    disabled
  >
    Filtre sepia
  </button>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layouts/footer.php" ?>

<script>
  const [picArea, snap, cam, greyFltr, noFltr, sepiaFltr] = mapElements([
    "picture-area",
    "snapshot-toggler",
    "video-toggler",
    "grey-filter",
    "no-filter",
    "sepia-filter"
  ]);
  const state = new Proxy(
    { recording: false, editing: false, pic: null, filter: null },
    {
      set: (obj, prop, value) => {
        obj[prop] = value;
        if (prop === "recording") {
          snap.disabled = !value;
          cam.innerHTML = value ? "Eteindre la camera" : "Allumer la camera";
        } else if (prop === "editing") {
          greyFltr.disabled = !value;
          noFltr.disabled = !value;
          sepiaFltr.disabled = !value;
        } else if (prop === "pic") {
          state.filter = value ? new Filter(state.pic.ctx, state.pic.width, state.pic.height) : null;
        }
      }
    }
  );

  const startRecording = () => {
    if (navigator.mediaDevices) {
      state.recording = true;
      state.editing = false;
      removeElement(document.getElementById("canvas"));
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
    const canvas = createElement(picArea, "canvas", {
      "class": "picture",
      "id": "canvas"
    });
    state.pic = new Picture(stream, canvas);
    stopRecording();
  };
</script>
