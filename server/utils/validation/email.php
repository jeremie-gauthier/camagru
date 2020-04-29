<?php

function checkEmail($email) {
	$pattern = '/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/';

	if ($email == "" || !preg_match($pattern, $email)) {
    return false;
  } else {
    return true;
  }
};

?>
