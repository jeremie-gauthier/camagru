<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Pictures.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";

try {
  $pic_cls = new Pictures($DB_DSN, $DB_USER, $DB_PASSWORD);
  $pictures = $pic_cls->getAllFrom(Session::get("userId"));

  foreach ($pictures as $picture) { ?>

    <div class="card" id="card<?php echo $picture['idPictures'] ?>">
      <img src="/assets/users/<?php echo $picture['idPictures'] ?>.png" class="card-img-top" />
      <div class="card-body">
        <span class="inline">
          <h5 class="card-title"><?php echo Session::get('pseudo') ?></h5>

          <!-- Like button -->
          <div class="inline">
            <span
              class="material-icons like-icon"
              id="like-card<?php echo $picture['idPictures'] ?>"
              onclick="likePicture(this)"
            >favorite<?php if ($picture['alreadyLiked'] == 0) echo "_border" ?></span>
            <span
              id="sum-likes-card<?php echo $picture['idPictures'] ?>"
            ><?php echo $picture['likes'] ?></span>

            <span
              class="material-icons comment-icon"
              id="comment-card<?php echo $picture['idPictures'] ?>"
              onclick="openComment(<?php echo $picture['idPictures'] ?>)"
            >chat</span>
            <span
              id="sum-comments-card<?php echo $picture['idPictures'] ?>"
            ><?php echo $picture['comments'] ?></span>
          </div>

        </span>

        <p
          class="card-text"
          id="legend-card<?php echo $picture['idPictures'] ?>"
        ><?php echo $picture['legend'] ?></p>

        <div
          class="inline no-space"
          id="comments-toggler"
          onclick="toggleComments(<?php echo $picture['idPictures'] ?>)"
        >
          <span class="card-comments-btn">Afficher les commentaires</span>
          <span class="material-icons arrow-up">play_arrow</span>
        </div>

        <div id="list-comments" hidden></div>

        <!-- Buttons -->
        <div class="btn-actions">
          <div>
            <?php if (Session::get("userId") == $picture['diUsers']) { ?>
              <button
                class="btn btn-primary"
                onclick="openLegend(<?php echo $picture['idPictures'] ?>)"
              >Modifier</button>
              <button
                class="btn btn-danger"
                onclick="delPicture(<?php echo $picture['idPictures'] ?>)"
              >Supprimer</button>
            <?php } ?>
          </div>
          <!-- Date -->
            <div>Publi&eacute;e le 
              <?php echo 
                  date_format(new DateTime($picture['regDate']), 'd/m/Y H:i')
              ?>
            </div>
        </div>
      </div>
    </div>

  <?php }

} catch (Exception $e) {
  echo "Une erreur est survenue";
}

?>

<script>
  const comToggler = document.getElementById("comments-toggler");
  const listComs = document.getElementById("list-comments");
  const cache = [];

  const toggleComments = async (pictureId) => {
    const arrow = comToggler.children[1];

    if (arrow.classList.contains("arrow-up")) {
      arrow.classList.remove("arrow-up");
      arrow.classList.add("arrow-down");
      listComs.hidden = false;
      if (!cache.includes(pictureId)) {
        const comments = await fetchComments(pictureId);
        commentsToDOM(comments);
      }
    } else if (arrow.classList.contains("arrow-down")) {
      arrow.classList.remove("arrow-down");
      arrow.classList.add("arrow-up");
      listComs.hidden = true;
    }
  };

  const fetchComments = async (pictureId) => {
    try {
      const url = `/gallery/src/comments.php?pictureId=${pictureId}`;

      const comments = await AsyncRequest.get(url);
      cache.push(pictureId);
      return comments;
    } catch (err) {
      showToast("error", err.message ?? err);
    }
  };

  const commentsToDOM = (comments) => {
    const formatDate = (date) => {
      const d = new Date(date);
      return d.toDateString();
    }

    comments.forEach((comment) => {
      const comDiv = createElement(listComs, "div", { class: "comment-block" });
      createElement(comDiv, "strong", { class: "comment-author" }, comment.author);
      createElement(comDiv, "p", { class: "comment-txt" }, comment.comment);
      createElement(comDiv, "span", { class: "comment-date" }, comment.regDate);
    });
  };

</script>