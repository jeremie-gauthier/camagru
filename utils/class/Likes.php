<?php

require_once "Database.php";

class Likes extends Database{
  function __construct($DB_DSN, $DB_USER, $DB_PASSWORD) {
    parent::__construct($DB_DSN, $DB_USER, $DB_PASSWORD);
  }

  function add($userId, $pictureId) {
    try {
      $query = "
        INSERT INTO
          likes (
            diUsers,
            diPictures
          )
        VALUES (
          :userId,
          :pictureId
        )
      ";
      $values = [
        ":userId" => $userId,
        ":pictureId" => $pictureId
      ];
      $this->query($query, $values);
    } catch (Exception $e) {
      throw $e;
    }
  }

  function del($userId, $pictureId) {
    try {
      $query = "
        DELETE FROM
          likes
        WHERE
          diUsers = :userId
          AND diPictures = :pictureId
      ";
      $values = [
        ":userId" => $userId,
        ":pictureId" => $pictureId
      ];
      $this->query($query, $values);
    } catch (Exception $e) {
      throw $e;
    }
  }
}

?>
