<?php
ini_set('display_errors', 0);

$url_to_shorten = get_magic_quotes_gpc() ? stripslashes(trim($_REQUEST['longurl'])) : trim($_REQUEST['longurl']);

if (!empty($url_to_shorten) && preg_match('|^https?://|', $url_to_shorten)) {
	require ('config.php');

	// check if the client IP is allowed to shorten
	if ($_SERVER['REMOTE_ADDR'] != LIMIT_TO_IP) {
		die('You are not allowed to shorten URLs with this service.');
	}

	// check if the URL is valid
	if (CHECK_URL) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_to_shorten);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($ch);
		$response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($response_status == '404') {
			die('Not a valid URL');
		}
	}

	// check if the URL has already been shortened
	$check_url_query = 'SELECT id FROM ' . DB_TABLE . ' WHERE long_url="' . $url_to_shorten . '"';
	$query = $pdo->prepare($check_url_query);
	$query->execute();
	$already_shortened = $query->fetch();

	if (!empty($already_shortened[0])) {

		// URL has already been shortened
		$shortened_url = getShortenedURLFromID($already_shortened[0]);
	}
	else {

		// a new URL needs to be created, this is the SQL string
		$insertSql = 'INSERT INTO ' . DB_TABLE . ' (long_url, created, creator) VALUES ("' . ($url_to_shorten) . '", "' . time() . '", "' . ($_SERVER['REMOTE_ADDR']) . '")';

		// Create our SQL statement, which inserts data into our table.
		$insertSql = "INSERT INTO " . DB_TABLE . "(long_url, created, creator) VALUES (:long_url, :created, :creator)";

		// Prepare our SQL statement.
		$statement = $pdo->prepare($insertSql);

		// Execute the SQL statement.
		$statement->execute(array(
			"long_url" => $url_to_shorten,
			"created" => time() ,
			"creator" => $_SERVER['REMOTE_ADDR']
		));

		// Get the ID of the last inserted row by using the PDO::lastInsertId method.
		$id = $pdo->lastInsertId();

		// get the code associated to the url recently created;
		$shortened_url = getShortenedURLFromID($id);
	}

	echo BASE_HREF . $shortened_url;
} else {
	echo "not a URL";
}
