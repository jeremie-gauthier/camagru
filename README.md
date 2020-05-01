# Camagru

A small Instagram-like project

## 🚀 Quick start

```bash
php -S 127.0.0.1:8888 -c php.ini
```

## 🔧 Installation

For security reasons, credentials are not visible in source code. They are instead defined in local env vars and then accessed in PHP with `getenv(env_var)`.

### **How to define env vars for PHP**

Just define your variables in shell (or `.bashrc` for persistent data) with the following command

```bash
export KEY=VALUE
```

⚠️ _Please note that **localhost** should be written as **127.0.0.1** on MacOS_ otherwise you'll get some troubles connecting to the database

If you have edited your `.bashrc`, don't forget to source it

```bash
source .bashrc
```

As we are using built-in php server. We can also define them on boot [like this](https://www.php.net/manual/fr/features.commandline.webserver.php#124576).

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
