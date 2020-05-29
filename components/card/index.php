<template id="template-card">
  <div class="card" id="card">
    <img src="" class="card-img-top" id="card-img" alt="" />
    <div class="card-body">
      <div class="inline">
        <h5 class="card-title" id="card-title"></h5>

        <!-- Like button -->
        <div class="inline">
          <span class="material-icons like-icon" id="like-card"></span>
          <span id="sum-likes-card"></span>

          <span class="material-icons comment-icon" id="comment-card">chat</span>
          <span id="sum-comments-card"></span>
        </div>
      </div>

      <p class="card-text" id="legend-card"></p>

      <div class="inline no-space" id="comments-toggler">
        <span class="card-comments-btn">Afficher les commentaires</span>
        <span class="material-icons arrow-up">play_arrow</span>
      </div>

      <div id="list-comments" hidden></div>

      <!-- Buttons -->
      <div class="btn-actions">
        <div id="card-owner-actions">
          <button class="btn btn-primary" id="action-update" hidden>Modifier</button>
          <button class="btn btn-danger" id="action-delete" hidden>Supprimer</button>
        </div>
        <!-- Date -->
        <div id="card-img-date"></div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
  <?php if (Session::exists("pseudo") === true) { ?>
    const currentUser = {
      pseudo: "<?php echo Session::get("pseudo") ?>",
      id: "<?php echo Session::get("userId") ?>"
    };
  <?php } else { ?>
    const currentUser = null;
  <?php } ?>
  
  let current = null;

  function isUserLogged(wrapped) {
    return function() {
      if (currentUser === null) {
		    window.location.href = "http://127.0.0.1:8888/auth/login";
      } else {
        const result = wrapped.apply(this, arguments);
        return result;
      }
    }
  }
</script>

<script type="text/javascript" src="/components/card/scripts/card.js"></script>
<script type="text/javascript" src="/components/card/scripts/like.js"></script>
<script type="text/javascript" src="/components/card/scripts/comments.js"></script>
