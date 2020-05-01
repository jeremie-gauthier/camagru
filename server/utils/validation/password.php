<?php

function isUpper($pwd) {
  return preg_match('/[A-Z]/', $pwd);
}

function isLower($pwd) {
  return preg_match('/[a-z]/', $pwd);
}

function isDigit($pwd) {
  return preg_match('/\d/', $pwd);
}

function isSpecial($pwd) {
  $specials = '/[ !\"#\$%&\'\(\)\*\+,-\.\/\\:;<=>\?@\[\]\^_`{\|}~]/';
  return preg_match($specials, $pwd);
}

function checkPwd($pwd, $confirmPwd) {
  $len = strlen($pwd);
  
  if ($pwd == ""
    || $len < 8
    || strcmp($pwd, $confirmPwd) != 0
    || !isUpper($pwd)
    || !isLower($pwd)
    || !isDigit($pwd)
    || !isSpecial($pwd)
  ) {
    return false;
	} else {
    return true;
  }
};

?>
