<?php

require_once "Database.php";
require_once "Mail.php";

class Users extends Database{
  function __construct($DB_DSN, $DB_USER, $DB_PASSWORD) {
    parent::__construct($DB_DSN, $DB_USER, $DB_PASSWORD);
  }

  function getByMail($email) {
    try {
      $query = "
        SELECT
          *
        FROM
          users
        WHERE
          email = :email
      ";
      $values = [":email" => $email];
      $this->query($query, $values);
      $user = $this->get_results();
      return $user;
    } catch (Exception $e) {
      throw $e;
    }
  }

  function create($pseudo, $email, $pwd) {
    try {
      $hash = md5(time());
      $query = "
        INSERT INTO
          users (
            pseudo,
            email,
            password,
            secureHash
          )
        VALUES (
          :pseudo,
          :email,
          :pwd,
          :hash
        )
      ";
      $values = [
        ":pseudo" => $pseudo,
        ":email" => $email,
        ":pwd" => password_hash($pwd, PASSWORD_DEFAULT),
        ":hash" => $hash
      ];
      $this->query($query, $values);

      Mail::newAccount($email, $hash);
    } catch (Exception $e) {
      throw $e;
    }
  }

  function update($pseudo, $email, $userId) {
    try {
      $query = "
        UPDATE
          users
        SET
          pseudo = :pseudo,
          email = :email
        WHERE
          idUsers = :userId
      ";
      $values = [
        ":pseudo" => $pseudo,
        ":email" => $email,
        ":userId" => $userId
      ];
      $this->query($query, $values);
      if ($this->affected_rows() != 1) {
        throw new Exception("User not found");
      }
    } catch (Exception $e) {
      throw $e;
    }
  }

  function updatePassword($pwd, $userId) {
    try {
      $query = "
        UPDATE
          users
        SET
          password = :pwd,
          secureHash = NULL
        WHERE
          idUsers = :userId
      ";
      $values = [
        ":pwd" => password_hash($pwd, PASSWORD_DEFAULT),
        ":userId" => $userId
      ];
      $this->query($query, $values);
      if ($this->affected_rows() != 1) {
        throw new Exception("User not found");
      }
    } catch (Exception $e) {
      throw $e;
    }
  }

  function confirmAccount($email) {
    try {
      $query = "
        UPDATE
          users
        SET
          confirmedAccount = 1,
          secureHash = NULL
        WHERE
          email=:email
      ";
      $values = [":email" => $email];
      $this->query($query, $values);
    } catch (Exception $e) {
      throw $e;
    }
  }

  function notifications($notif, $userId) {
    try {
      $query = "
        UPDATE
          users
        SET
          notifications = :notif
        WHERE
          idUsers = :userId
      ";
      $values = [
        ":notif" => $notif,
        ":userId" => $userId
      ];
      $this->query($query, $values);
      if ($this->affected_rows() != 1) {
        throw new Exception("User not found");
      }
    } catch (Exception $e) {
      throw $e;
    }  
  }

  function bindHash($userId, $hash) {
    try {
      $query = "
        UPDATE
          users
        SET
          secureHash = :hash
        WHERE
          idUsers = :userId
      ";
      $values = [
        ":hash" => $hash,
        ":userId" => $userId
      ];
      $this->query($query, $values);
      if ($this->affected_rows() != 1) {
        throw new Exception("User not found");
      }
    } catch (Exception $e) {
      throw $e;
    }
  }
}

?>
