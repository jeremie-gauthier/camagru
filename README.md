# Camagru

A small Instagram-like project

## 🔧 Installation

**Mac OS:** Follow [this tutorial](https://blog.edenpulse.com/apache-mysql-php-sur-osx/) to setup Apache/MySQL/PHP

For security reasons, credentials are not visible in source code. They are instead defined in local env vars and then accessed in PHP with `getenv(env_var)`.

### **How to define env vars for PHP**

<details>
<summary>
  <strong>Ubuntu</strong>
</summary>

First, ensure that environment vars are read by PHP.

You must have the following in your `/etc/php/7.2/cli/php.ini`

```ini
...

; variables_order
;   Default Value: "EGPCS"
;   Development Value: "EGPCS"
;   Production Value: "EGPCS"

...
```

Then you simply have to define your variables in shell (or `.bashrc` for persistent data) with the following command

```bash
export KEY=VALUE
```

If you have edited your `.bashrc`, don't forget to source it

```bash
source .bashrc
```

</details>

<details>
<summary>
  <strong>Mac OS</strong>
</summary>

Just define your variables in shell (or `.bashrc` for persistent data) with the following command

```bash
export KEY=VALUE
```

⚠️ _Please note that **localhost** should be written as **127.0.0.1** on MacOS_ otherwise you'll get some troubles connecting to the database

If you have edited your `.bashrc`, don't forget to source it

```bash
source .bashrc
```

</details>

### **How to create MySQL users**

Connect to mysql with root account (you will be asked to type your password)

```bash
mysql -u root -p
```

Create your user

```sql
CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'user_password'
```

Grant privileges to his account

```sql
GRANT ALL PRIVILEGES ON database_name.* TO 'db_user'@'localhost'
```

This new account now have all privileges on `database_name`
