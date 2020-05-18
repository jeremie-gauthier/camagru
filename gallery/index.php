<?php
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Session.php";
  if (!Session::exists("pseudo")) {
    header("Location: /auth/login");
  }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/header.php" ?>
<link rel="stylesheet" type="text/css" href="/gallery/styles/gallery.css">
<link rel="stylesheet" type="text/css" href="/gallery/styles/overlay.css">
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v7.0"></script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/navbar.php" ?>


<div class="container">
  <h1>Ma galerie</h1>
  <hr />

  <a href="/picture" class="material-icons add-a-photo">add_a_photo</a>

  <div id="no-picture" hidden>Vous n'avez partag&eacute; aucune photo.</div>
  <div id="list-pictures">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/components/card/index.php" ?>
  </div>

  <div id="overlay-legend-container" class="overlay-container" hidden>
    <div class="overlay-content">
      <h1 class="overlay-title">L&eacute;gende</h1>
      <div id="overlay-legend-counter" class="overlay-counter">0/255</div>
      <textarea
        autofocus
        id="overlay-legend-text"
        class="overlay-text"
        name="legend"
        rows='10'
        column='50'
        maxlength="255"
        placeholder="Ajoutez une l&eacute;gende..."
      ></textarea>
      <button
        type="button"
        id="overlay-legend-btn"
        class="overlay-btn"
        onclick="putLegend()"
      >Enregistrer</button>
    </div>
  </div>

  <div id="overlay-comment-container" class="overlay-container" hidden>
    <div class="overlay-content">
      <h1 class="overlay-title">Ajoutez un commentaire</h1>
      <div id="overlay-comment-counter" class="overlay-counter">0/255</div>
      <textarea
        autofocus
        id="overlay-comment-text"
        class="overlay-text"
        name="comment"
        rows='10'
        column='50'
        maxlength="255"
        placeholder="Ajoutez un commentaire..."
      ></textarea>
      <button
        type="button"
        id="overlay-comment-btn"
        class="overlay-btn"
        onclick="addComment()"
      >Envoyer</button>
    </div>
  </div>

  <?php require $_SERVER['DOCUMENT_ROOT'] . "/components/toast.php" ?>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/components/layouts/footer.php" ?>

<script type="text/javascript" src="/utils/scripts/DOM.js"></script>
<script type="text/javascript" src="/utils/scripts/throttle.js"></script>
<script type="text/javascript" src="/utils/scripts/AsyncRequest.js"></script>
<script type="text/javascript" src="/gallery/scripts/overlay.js"></script>
<script type="text/javascript" src="/gallery/scripts/main.js"></script>

<script type="text/javascript">
  const listDiv = document.getElementById("list-pictures");

  const loadPictures = async () => {
    try {
      const hasMore = await fetchCards(listDiv, "<?php echo Session::get("pseudo") ?>", true);
      if (hasMore === false) {
        window.removeEventListener("scroll", loadPicturesOnScroll);
      }
    } catch (err) {
      showToast("error", err.message ?? err);
    }
  }
  const throttledLoading = throttle(loadPictures, 500);

  const loadPicturesOnScroll = () => {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
      throttledLoading();
    }
  }
  
  document.addEventListener("DOMContentLoaded", throttledLoading);
  window.addEventListener("scroll", loadPicturesOnScroll);

</script>