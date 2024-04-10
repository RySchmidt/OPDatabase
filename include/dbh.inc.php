<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

$dsn = "mysql:host=localhost;dbname=one_piece_unspoiled";
$dbusername = "root";
$dbpassword = "";

try {
	$pdo = new PDO($dsn, $dbusername, $dbpassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}
