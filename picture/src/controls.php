<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: /auth/login");
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php";
?>

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
    <h1 class="overlay-title">Ajoutez une l&eacute;gende</h1>
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
