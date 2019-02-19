<?php
ini_set('display_errors', 0);

if (!preg_match('|^[0-9a-zA-Z]{1,6}$|', $_GET['url'])) {
	die('That is not a valid short url');
}

require ('config.php');

$shortened_id = getIDFromShortenedURL($_GET['url']);

echo $shortened_id ;

if (CACHE) {
	$long_url = file_get_contents(CACHE_DIR . $shortened_id . CACHE_EXTENSION);
	if (empty($long_url) || !preg_match('|^https?://|', $long_url)) {
		$check_url_query = 'SELECT long_url FROM ' . DB_TABLE . ' WHERE id="' . $shortened_id . '"'; //sql attacks ??
		$query = $pdo->prepare($check_url_query);
		$query->execute();
		$results = $query->fetch();
		$long_url = $results[0];
		@mkdir(CACHE_DIR, 0777);
		$handle = fopen(CACHE_DIR . $shortened_id . CACHE_EXTENSION, 'w+');
		fwrite($handle, $long_url);
		fclose($handle);
	}
}
else {
	$check_url_query = 'SELECT long_url FROM ' . DB_TABLE . ' WHERE id="' . $shortened_id . '"'; //sql attacks ??
	$query = $pdo->prepare($check_url_query);
	$query->execute();
	$already_shortened = $query->fetch();
	if (!empty($already_shortened[0])) {
		$long_url = $already_shortened[0];
	}
	else {
		die(' no existe ese id en la DB');
	}
}

// echo $long_url;

header('HTTP/1.1 301 Moved Permanently');
header('Location: ' . $long_url);
exit;