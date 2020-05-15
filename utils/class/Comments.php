<?php

require_once "Database.php";

class Comments extends Database{
  function __construct($DB_DSN, $DB_USER, $DB_PASSWORD) {
    parent::__construct($DB_DSN, $DB_USER, $DB_PASSWORD);
  }

  function create($userId, $pictureId, $comment) {
    try {
      $query = "
        INSERT INTO
          comments (
            diUsers,
            diPictures,
            comment
          )
        VALUES (
          :userId,
          :pictureId,
          :comment
        )
      ";
      $values = [
        ":userId" => $userId,
        ":pictureId" => $pictureId,
        ":comment" => $comment
      ];
      $this->query($query, $values);
      $inserted_id = $this->get_last_inserted_id();
      return $inserted_id;
    } catch (Exception $e) {
      throw $e;
    }
  }
}

?>
