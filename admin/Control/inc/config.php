<?php
// Host Name
$dbhost = 'localhost';

// Database Name
$dbname = 'sneakershop';

// Database Username
$dbuser = 'root';

// Database Password
$dbpass = '';

try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}
if (!function_exists('money')) {
    function money($number, $suffix = 'đ') {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . "{$suffix}";
        }
    }
}

?>