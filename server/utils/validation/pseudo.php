<?php

function checkPseudo($pseudo) {
	$pattern = '/[^a-zA-Z\d\-]/';
  $len = strlen($pseudo);

	if ($pseudo == "" || $len < 3 || $len > 16 || preg_match($pattern, $pseudo)) {
    return false;
	} else {
    return true;
  }
};

?>
