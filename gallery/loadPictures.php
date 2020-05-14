<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/class/Pictures.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";

  try {
    $pic_cls = new Pictures($DB_DSN, $DB_USER, $DB_PASSWORD);
    $pictures = $pic_cls->getAllFrom(Session::get("userId"));

    foreach ($pictures as $picture) { ?>

      <div class="card" style="width: 100%; max-width: 640px;">
          <img src="/assets/users/<?php echo $picture['idPictures'] ?>.png" class="card-img-top" />
          <div class="card-body">
            <span class="inline">
              <h5 class="card-title"><?php echo Session::get('pseudo') ?></h5>
              Publi&eacute;e le <?php echo substr(date_format(new DateTime($picture['regDate']), 'd/m/Y H:i:s'), 0, -3) ?>
            </span>
            <p class="card-text"><?php echo $picture['legend'] ?></p>
            <div class="btn-actions">
              <button class="btn btn-primary">Modifier</button>
              <button class="btn btn-danger">Supprimer</button>
            </div>
          </div>
        </div>

    <?php }

  } catch (Exception $e) {
    echo "Une erreur est survenue";
  }

?>

