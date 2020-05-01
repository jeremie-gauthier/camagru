# Users Class

An interface to manage data relative to users.

## Usage

Put the following in your php file

```php
require_once "server/utils/class/Users.php";
```

Create a new instance:

```php
require_once "config/database.php";
$user_cls = new Users($DB_DSN, $DB_USER, $DB_PASSWORD);
```

## Caution

All these methods throw an error if they failed.

Be sure to catch it in a try/catch block.

## Methods

- **getByMail(\$email)**

  _Return the user from the database who match the email._

- **create($pseudo, $email, \$pwd)**

  _Create a new entry in the database with the given values._
