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
                substr(
                  date_format(
                    new DateTime($picture['regDate']),
                    'd/m/Y H:i:s'),
                  0,
                  -3
                )
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

