<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require "dbh.inc.php";
?>

<link rel="stylesheet" href="/OPDatabase/css/displayTable.css">
<h2> Chapters</h2> <br>

<?php

try {

	$select_query = "SELECT *
		FROM _chapter
		INNER JOIN _info_cache ON _chapter._info_cache_id = _info_cache.id;";

	$select_stmt = $pdo->prepare($select_query);
	$select_stmt->execute();

	$query_results = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

	$select_query = NULL;
	$select_stmt = NULL;
	$pdo = NULL;

} catch (PDOException $e) {
	echo "You should not be here!<br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}

if (empty($query_results)) {
	echo "<div>";
	echo "<p> <No chapters found in database.> <p>";
	echo "<div>";
}
else {
	echo "<table class='display' id='chapterTable'>";
	
	echo "<thead>";
	echo "<tr class='display'>";
	echo "<th class='display' onclick=\"sortTable('chapterTable', 0)\"> Volume <br> Number </th>";
	echo "<th class='display' onclick=\"sortTable('chapterTable', 1)\"> Chapter <br> Number </th>";
	echo "<th class='display' onclick=\"sortTable('chapterTable', 2)\"> Title </th>";
	echo "<th class='display' onclick=\"sortTable('chapterTable', 3)\"> Publish Date </th>";
	echo "<th class='display' onclick=\"sortTable('chapterTable', 4)\"> Story Arc </th>";
	echo "</tr>";
	echo "<thead>";

	echo "<tbody>";
	foreach ($query_results as $row) { 
		echo "<tr class='display'>"; 
		echo "<td class='display'>" . htmlspecialchars($row["_volume_number"]) . "</td>";
		echo "<td class='display'>" . htmlspecialchars($row["number"]) . "</td>";
		echo "<td class='display'>" . htmlspecialchars($row["title"]) . "</td>";
		echo "<td class='display'>" . htmlspecialchars($row["release_date"]) . "</td>";
		echo "<td class='display'>" . htmlspecialchars($row["_story_arc_id"]) . "</td>";
		echo "</tr>";
	}
	echo "<tbody>";

	echo "</table>";
}
?>

<script src="/OPDatabase/javaScript/sortTable.js"></script>
