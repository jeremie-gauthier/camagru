<?php

require_once "Database.php";

class Users extends Database{
  function __construct($DB_DSN, $DB_USER, $DB_PASSWORD) {
    parent::__construct($DB_DSN, $DB_USER, $DB_PASSWORD);
  }

  function getByMail($email) {
    try {
      $query = "SELECT * FROM users WHERE email=:email";
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
      // AJOUTER HASH ET VALIDATION MAIL PAR LA SUITE
      $query = "INSERT INTO users (pseudo, email, password) VALUES (:pseudo, :email, :pwd)";
      $values = [
        ":pseudo" => $pseudo,
        ":email" => $email,
        ":pwd" => password_hash($pwd, PASSWORD_DEFAULT)
      ];
      $this->query($query, $values);
    } catch (Exception $e) {
      throw $e;
    }
  }
}

?>
