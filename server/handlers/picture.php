<?php
  extract(array_map('htmlspecialchars', $_POST));
  $data = explode('base64,', $picture)[1];
  $img = str_replace(' ', '+', $data);
  file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/assets/users/1.png", base64_decode($img));
  echo "Image enregistree";
?>