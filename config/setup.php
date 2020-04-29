<?php

require_once "database.php";

try {
  $pdo = new PDO('mysql:host=' . $DB_HOST, $DB_USER, $DB_PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $dbFile = "database.sql";
  $dbSQL = fopen($dbFile, "r");
  $data = fread($dbSQL, filesize($dbFile));
  fclose($dbSQL);
  $pdo->exec($data);
  echo "[+] Database successfully created" . PHP_EOL;
} catch (PDOException $e) {
  echo "[-] Connection failed: " . $e->getMessage() . PHP_EOL;
} finally {
  $pdo = null;
}


?>
