<?php

define('DB_NAME', 'urls');
define('DB_USER', 'urls');
define('DB_PASSWORD', 'urls');
define('DB_HOST', 'localhost:8889');
define('DB_TABLE', 'shorturls');

// base location of script (include trailing slash)
define('BASE_HREF', 'http://' . $_SERVER['HTTP_HOST'] . '/');

// change to limit short url creation to a single IP
define('LIMIT_TO_IP', $_SERVER['REMOTE_ADDR']);

// check if URL first to avoid saving pages that don't exist
define('CHECK_URL', TRUE);

// URL allowed characters. Don't include chars that create errors when using the cache feature 
// (when creating a file on the server, those characters are used for the filename)
define('ALLOWED_CHARS', '0123456789abdeghijklmnopqrstuvwxyzABDEGHIJKLMNOPQRSTUVWXYZ');

// want cache? (to speed up checking, the script checks a file version for the link if exists first, if not, reads the DB)
define('CACHE', TRUE);

// what extension you want for your links ?
define('CACHE_EXTENSION', ".url");

// where the cache files will be stored? (include trailing slash)
define('CACHE_DIR', dirname(__FILE__) . '/cache/');


function getShortenedURLFromID ($integer, $base = ALLOWED_CHARS)
{
	$length = strlen($base);
	$out ="";

	while($integer > $length - 1)
	{
		$out = $base[fmod($integer, $length)] . $out;
		$integer = floor( $integer / $length );
	}
	return $base[$integer] . $out;
}

function getIDFromShortenedURL ($string, $base = ALLOWED_CHARS)
{
	$length = strlen($base);
	$size = strlen($string) - 1;
	$string = str_split($string);
	$out = strpos($base, array_pop($string));
	foreach($string as $i => $char)
	{
		$out += strpos($base, $char) * pow($length, $size - $i);
	}
	return $out;
}


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

