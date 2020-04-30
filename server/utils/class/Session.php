<?php

class Session {
  function get($key) {
    return $_SESSION[$key];
  }

  function set($key, $value) {
    $_SESSION[$key] = $value;
  }

  function multiset($array) {
    foreach ($array as $key => $val) {
      Session::set($key, $val);
    }
  }

  function update($key, $newValue) {
    unset($_SESSION[$key]);
    $_SESSION[$key] = $newValue;
  }

  function append($key, $value) {
    $_SESSION[$key][] = $value;
  }

  function del($key) {
    unset($_SESSION[$key]);
  }

  function exists($key) {
    return array_key_exists($key, $_SESSION);
  }
}

?>
