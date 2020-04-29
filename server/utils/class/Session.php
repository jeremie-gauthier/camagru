<?php

class Session {
  public function get($key) {
    return $_SESSION[$key];
  }

  public function set($key, $value) {
    $_SESSION[$key] = $value;
  }

  public function update($key, $newValue) {
    unset($_SESSION[$key]);
    $_SESSION[$key] = $newValue;
  }

  public function append($key, $value) {
    $_SESSION[$key][] = $value;
  }

  public function del($key) {
    unset($_SESSION[$key]);
  }

  public function exists($key) {
    return array_key_exists($key, $_SESSION);
  }
}

?>
