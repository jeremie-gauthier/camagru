# Session Class

An interface to interact with php sessions variables.

## Usage

Put the following in your php file

```php
session_start();
require_once "server/utils/class/Session.php";
```

Call a method:

```php
Session::method(...args);
```

## Methods

- **get(\$key)**

  _Return the value of the variable `$key`._

- **set($key, $value)**

  _Define the variable `$key` with the value `$value`._

- **multiset(\$array)**

  _Take an associative array and define each element like the **set** mehtod._

* **update($key, $newValue)**

  _Update an existing variable `$key` and set its value to `$newValue`._

* **append($key, $value)**

  _Append a new value to the existing array `$key`._

* **del(\$key)**

  _Remove the variable `$key` from the session variables._

* **multidel(\$keys)**

  _Removes all the key contained in the array `$keys` from the session variables._

* **exists(\$key)**

  _Return **true** if the variable `$key` is already set, else **false**._
