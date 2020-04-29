<?php

function checkPwd($pwd, $confirmPwd) {
  $len = strlen($pwd);
  $specials = '/[ !\"#\$%&\'\(\)\*\+,-\.\/\\:;<=>\?@\[\]\^_`{\|}~]/';
  
  $isUpper = function() use ($pwd) { preg_match('/[A-Z]/', $pwd); };
	$isLower = function() use ($pwd) { preg_match('/[a-z]/', $pwd); };
  $isDigit = function() use ($pwd) { preg_match('/\d/', $pwd); };
  $isSpecial = function() use ($pwd) { preg_match($specials, $pwd); };
	$checkChar = isUpper() && isLower() && isDigit() && isSpecial();

	if ($pwd == "" || $len < 8 || !$checkChar || strcmp($pwd, $confirmPwd) != 0) {
    return false;
	} else {
    return true;
  }
};

?>
