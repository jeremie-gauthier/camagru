<?php

require_once "Database.php";

class Pictures extends Database{
  function __construct($DB_DSN, $DB_USER, $DB_PASSWORD) {
    parent::__construct($DB_DSN, $DB_USER, $DB_PASSWORD);
  }

  function create($userId, $legend) {
    try {
      $query = "
        INSERT INTO
          pictures (
            diUsers,
            legend
          )
        VALUES (
          :userId,
          :legend
        )
      ";
      $values = [
        ":userId" => $userId,
        ":legend" => $legend
      ];
      $this->query($query, $values);
      $inserted_id = $this->get_last_inserted_id();
      return $inserted_id;
    } catch (PDOException $e) {
      throw $e->getMessage();
    }
  }

  function delete($imgId, $userId) {
    try {
      $query = "
        DELETE FROM
          pictures
        WHERE
          idPictures = :imgId
          AND diUsers = :userId
      ";
      $values = [
        ":imgId" => $imgId,
        ":userId" => $userId
      ];
      $this->query($query, $values);
      $count = $this->affected_rows();
      return $count == 1;
    } catch (PDOException $e) {
      throw $e->getMessage();
    }
  }

  function getAllFrom($userId) {
    try {
      $query = "
        SELECT
          *
        FROM
          pictures
        WHERE
          diUsers = :userId
        ORDER BY
          regDate
        DESC
      ";
      $values = [
        ":userId" => $userId
      ];
      $this->query($query, $values);
      return $this->get_results();
    } catch (Exception $e) {
      throw $e;
    }
  }
}

?>
