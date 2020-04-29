<?php

// env vars processed by Apache are defined in /etc/apache2/envvars (Ubuntu)
// env vars processed by php are defined in shell (export XXX=YYY)
//  ensure that 'E' is in variables_order strings in /etc/php/7.2/cli/php.ini

$DB_NAME        = getenv("CAMAGRU_DB_NAME");
$DB_HOST        = getenv("CAMAGRU_DB_HOST");
$DB_DSN         = 'mysql:host=' . $DB_HOST . ';dbname=' . $DB_NAME;
$DB_USER        = getenv("CAMAGRU_DB_USER");
$DB_PASSWORD    = getenv("CAMAGRU_DB_PASSWORD");

?>
