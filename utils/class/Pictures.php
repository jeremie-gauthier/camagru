<?php

require_once "Database.php";

class Pictures extends Database{
  function __construct($DB_DSN, $DB_USER, $DB_PASSWORD) {
    parent::__construct($DB_DSN, $DB_USER, $DB_PASSWORD);
  }

  function getById($id) {
    try {
      $query = "
        SELECT
          *
        FROM
          pictures
        WHERE
          idPictures = :id
      ";
      $values = [
        ":id" => $id
      ];
      $this->query($query, $values);
      $picture = $this->get_results();
      return $picture;
    } catch (Exception $e) {
      throw $e;
    }
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
    } catch (Exception $e) {
      throw $e;
    }
  }

  function update($userId, $pictureId, $legend) {
    try {
      $query = "
        UPDATE
          pictures
        SET
          legend = :legend
        WHERE
          diUsers = :userId
          AND idPictures = :pictureId
      ";
      $values = [
        ":legend" => $legend,
        ":userId" => $userId,
        ":pictureId" => $pictureId
      ];
      $this->query($query, $values);
    } catch (Exception $e) {
      throw $e;
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
    } catch (Exception $e) {
      throw $e;
    }
  }

  function getAllFrom($userId) {
    try {
      $query = "
        SELECT
          *,
          (
            SELECT
              COUNT(likes.diUsers)
            FROM
              likes
            WHERE
              likes.diPictures = pictures.idPictures
          ) AS likes,
          (
            SELECT
              COUNT(likes.diUsers)
            FROM
              likes
            WHERE
              likes.diPictures = pictures.idPictures
              AND likes.diUsers = 1
          ) AS alreadyLiked,
          (
            SELECT
              COUNT(comments.diUsers)
            FROM
              comments
            WHERE
              comments.diPictures = pictures.idPictures
          ) AS comments
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

  function getMoreFrom($userId, $offset, $limit) {
    try {
      $query = "
        SELECT
          *,
          (
            SELECT
              COUNT(likes.diUsers)
            FROM
              likes
            WHERE
              likes.diPictures = pictures.idPictures
          ) AS likes,
          (
            SELECT
              COUNT(likes.diUsers)
            FROM
              likes
            WHERE
              likes.diPictures = pictures.idPictures
              AND likes.diUsers = 1
          ) AS alreadyLiked,
          (
            SELECT
              COUNT(comments.diUsers)
            FROM
              comments
            WHERE
              comments.diPictures = pictures.idPictures
          ) AS comments
        FROM
          pictures
        WHERE
          diUsers = :userId
        ORDER BY
          regDate
        DESC
        LIMIT "
        . filter_var(htmlspecialchars($offset), FILTER_SANITIZE_NUMBER_INT)
        . ", " . filter_var(htmlspecialchars($limit), FILTER_SANITIZE_NUMBER_INT)
      ;
      $values = [
        ":userId" => $userId
      ];
      $this->query($query, $values);
      return $this->get_results();
    } catch (Exception $e) {
      throw $e;
    }
  }

  function getMore($offset, $limit) {
    try {
      $query = "
        SELECT
          *,
          (
            SELECT
              COUNT(likes.diUsers)
            FROM
              likes
            WHERE
              likes.diPictures = pictures.idPictures
          ) AS likes,
          (
            SELECT
              COUNT(likes.diUsers)
            FROM
              likes
            WHERE
              likes.diPictures = pictures.idPictures
              AND likes.diUsers = 1
          ) AS alreadyLiked,
          (
            SELECT
              COUNT(comments.diUsers)
            FROM
              comments
            WHERE
              comments.diPictures = pictures.idPictures
          ) AS comments
        FROM
          pictures
        ORDER BY
          regDate
        DESC
        LIMIT "
        . filter_var(htmlspecialchars($offset), FILTER_SANITIZE_NUMBER_INT)
        . ", " . filter_var(htmlspecialchars($limit), FILTER_SANITIZE_NUMBER_INT)
      ;
      $this->query($query);
      return $this->get_results();
    } catch (Exception $e) {
      throw $e;
    }
  }
}

?>
