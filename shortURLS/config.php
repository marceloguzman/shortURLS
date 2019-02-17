<?php

define('DB_NAME', 'urls');
define('DB_USER', 'urls');
define('DB_PASSWORD', 'urls');
define('DB_HOST', 'localhost:8889');
define('DB_TABLE', 'shortenedurls');


try {
    $hostname = DB_HOST;
    $dbname = DB_NAME;
    $username = DB_USER;
    $pw = DB_PASSWORD;
	$table = DB_TABLE;

    $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }

?>