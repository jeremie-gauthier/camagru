<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  print_r($_POST);
}
else {
  header("Location: ../register.php");
  die(2);
}

?>
