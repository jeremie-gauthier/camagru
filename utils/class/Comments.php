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

  function delete($commentId, $userId) {
    try {
      $query = "
        DELETE FROM
          comments
        WHERE
          idComments = :commentId
          AND diUsers = :userId
      ";
      $values = [
        ":commentId" => $commentId,
        ":userId" => $userId
      ];
      $this->query($query, $values);
    } catch (Exception $e) {
      throw $e;
    }
  }

  function getAllFrom($pictureId) {
    try {
      $query = "
        SELECT
          comments.*, users.pseudo AS author
        FROM
          comments
        INNER JOIN users
          ON comments.diUsers = users.idUsers
        WHERE
          diPictures = :pictureId
        ORDER BY
          comments.regDate ASC
      ";
      $values = [
        ":pictureId" => $pictureId
      ];
      $this->query($query, $values);
      $comments = $this->get_results();
      return $comments;
    } catch (Exception $e) {
      throw $e;
    }
  }
}

?>
