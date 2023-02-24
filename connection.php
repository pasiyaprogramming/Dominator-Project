<?php
define('DB_SERVER', 'localhost'); //database server ip
define('DB_USERNAME', 'root'); //database username
define('DB_PASSWORD', ''); //database password
define('DB_DATABASE', 'pharmacy'); //database name
$db = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD); //connection statement with pdo
