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

    try {
      $this->stmt = $this->pdo->prepare($query);
      $this->stmt->execute($values);
    } catch (Exception $e) {
      throw $e;
    }
  }

  function get_first_result() {
    try {
      return $this->stmt->fetch();
    } catch (Exception $e) {
      throw $e;
    }
  }

  function get_results() {
    try {
      return $this->stmt->fetchAll();
    } catch (Exception $e) {
      throw $e;
    }
  }

  function get_last_inserted_id() {
    try {
      return $this->pdo->lastInsertId();
    } catch (Exception $e) {
      throw $e;
    }      
  }

  function affected_rows() {
  try {
    return $this->stmt->rowCount();
    } catch (Exception $e) {
      throw $e;
    }
  }

  function close() {
    $this->pdo = null;
  }
}

?>
