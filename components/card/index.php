<template id="template-card">
  <div class="card" id="card">
    <img src="" class="card-img-top" id="card-img" />
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
        <div id="card-owner-actions" hidden>
          <button class="btn btn-primary" id="modify">Modifier</button>
          <button class="btn btn-danger">Supprimer</button>
        </div>
        <!-- Date -->
        <div id="card-img-date"></div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript" src="/components/card/card.js"></script>
<script type="text/javascript" src="/components/card/comments.js"></script>
