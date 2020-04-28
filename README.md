# Camagru

A small Instagram-like project

## 🔧 Installation

**MAC**

Follow this tutorial https://blog.edenpulse.com/apache-mysql-php-sur-osx/

For security reasons, credentials are not visible in source code.

They are instead defined in local env vars for both PHP and Apache.

### **How to define env vars for Apache**

**Ubuntu**

Edit `/etc/apache2/envvars` and define your variables like this

```bash
export KEY=VALUE
```

### **How to define env vars for PHP**

**Ubuntu**

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

### **Restart Apache**

Restart Apache after having defined those variables to take them into account

```bash
systemctl restart apache2
```
