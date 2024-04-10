<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once 'dbh.inc.php';

try {

	$display_query = "SELECT *
		FROM _chapter
		INNER JOIN _info_cache ON _chapter._info_cache_id = _info_cache.id";

	$display_stmt = $pdo->prepare($display_query);
	$display_stmt->execute();

	$display_results = $display_stmt->fetchAll(PDO::FETCH_ASSOC);

	$display_query = NULL;
	$display_stmt = NULL;
	$pdo = null;

} catch (PDOException $e) {
	echo "You should not be here!<br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}

?>

<!DOCTYPE html>
<body>
<h2> Chapters</h2> <br>
<?php
if (empty($display_results)) {
	echo "<div>";
	echo "<p> <No Chapters Found> <p>";
	echo "<div>";
}
else {
	foreach ($display_results as $row) {
		echo "<div>";
		echo "<p>" . htmlspecialchars($row["number"]) . "<p>";
		echo "<p>" . htmlspecialchars($row["title"]) . "<p>";
		echo "<p>" . htmlspecialchars($row["release_date"]) . "<p>";
		echo "<p>" . htmlspecialchars($row["_volume_number"]) . "<p>";
		echo "<p>" . htmlspecialchars($row["_story_arc_id"]) . "<p>";
		echo "<p>" . htmlspecialchars($row["_cover_story_id"]) . "<p>";
		echo "</div>";
	}
}
?>
</body>
