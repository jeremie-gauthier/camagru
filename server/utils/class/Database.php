<?php

class Database {
  private $pdo;
  private $stmt;
  
  function __construct($DB_DSN, $DB_USER, $DB_PASSWORD) {
    try {
      $this->pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      $this->pdo = null;
      throw new Exception("Connection failed: " . $e->getMessage());
    }
  }

  function __destruct() {
    $this->stmt = null;
    $this->pdo = null;
  }

  function query($query, $values = null) {
    if ($this->pdo == null) return;

    $this->stmt = $this->pdo->prepare($query);
    $this->stmt->execute($values);
  }

  function get_first_result() {
    return $this->stmt->fetch();
  }

  function get_results() {
    return $this->stmt->fetchAll();
  }

  function close() {
    $this->pdo = null;
  }
}
?>
