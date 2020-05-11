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
    } catch (Exception $e) {
      throw $e;
    }
  }
}

?>
